<?php

namespace Kstools\Todo\Controller\Adminhtml\Task;

use Exception;
use Kstools\Todo\Model\Task;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class Delete extends \Kstools\Todo\Controller\Adminhtml\Task
{

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('task_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(Task::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Task.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['task_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Task to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
