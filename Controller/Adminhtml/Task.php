<?php

namespace Kstools\Todo\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Registry;

abstract class Task extends Action
{
    protected $_coreRegistry;
    const ADMIN_RESOURCE = 'Kstools_Todo::top_level';

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Kstools'), __('Kstools'))
            ->addBreadcrumb(__('Task'), __('Task'));
        return $resultPage;
    }
}
