<?php

namespace Kstools\Todo\Observer;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\PageCache\Model\Cache\Type;

class FlushCache implements ObserverInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function execute(Observer $observer)
    {
//        die(json_encode(get_class($this->objectManager->get(\Magento\PageCache\Model\Cache\Type::class))));
        $this->objectManager->get(Type::class)->clean();
    }
}
