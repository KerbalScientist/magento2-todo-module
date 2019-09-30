<?php

namespace Kstools\Todo\Controller\Adminhtml\Task;

use Exception;
use Kstools\Todo\Model\Task;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    const EVENT_NAME = 'kstools_todo_controller_adminhtml_task_save';

    protected $dataPersistor;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('task_id');

            $model = $this->_objectManager->create(Task::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Task no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Task.'));
                $this->dataPersistor->clear('kstools_todo_task');
                $this->_eventManager->dispatch(self::EVENT_NAME);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['task_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } /** @noinspection PhpRedundantCatchClauseInspection */ catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Task.'));
            }

            $this->dataPersistor->set('kstools_todo_task', $data);
            return $resultRedirect->setPath('*/*/edit', ['task_id' => $this->getRequest()->getParam('task_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
