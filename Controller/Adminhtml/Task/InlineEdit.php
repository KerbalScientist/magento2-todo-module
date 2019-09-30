<?php

namespace Kstools\Todo\Controller\Adminhtml\Task;

use Exception;
use Kstools\Todo\Model\Task;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

class InlineEdit extends Action
{
    const EVENT_NAME = 'kstools_todo_controller_adminhtml_task_inlineedit';

    protected $jsonFactory;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Inline edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelid) {
                    /** @var Task $model */
                    $model = $this->_objectManager->create(Task::class)->load($modelid);
                    try {
                        $model->setData(array_merge($model->getData(), $postItems[$modelid]));
                        $model->save();
                        $this->_eventManager->dispatch(self::EVENT_NAME);
                    } catch (Exception $e) {
                        $messages[] = "[Task ID: {$modelid}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
