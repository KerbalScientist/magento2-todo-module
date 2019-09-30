<?php

namespace Kstools\Todo\Controller\Adminhtml\Task;

use Kstools\Todo\Model\Task;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \Kstools\Todo\Controller\Adminhtml\Task
{
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('task_id');
        $model = $this->_objectManager->create(Task::class);
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Task no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('kstools_todo_task', $model);

        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Task') : __('New Task'),
            $id ? __('Edit Task') : __('New Task')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Tasks'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Task %1', $model->getId()) : __('New Task'));
        return $resultPage;
    }
}
