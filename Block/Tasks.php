<?php /** @noinspection PhpIncompatibleReturnTypeInspection */

namespace Kstools\Todo\Block;

use Kstools\Todo\Model\ResourceModel\Task\Collection as TaskCollection;
use Kstools\Todo\Model\ResourceModel\Task\CollectionFactory as TaskCollectionFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Tasks extends Template
{

    /**
     * @var TaskCollectionFactory
     */
    protected $taskCollectionFactory;

    /**
     * @var TimezoneInterface
     */
    protected $localeDate;

    /**
     * Constructor
     *
     * @param Context  $context
     * @param TaskCollectionFactory $taskCollectionFactory
     * @param TimezoneInterface $localeDate
     * @param array $data
     */
    public function __construct(
        Context $context,
        TaskCollectionFactory $taskCollectionFactory,
        TimezoneInterface $localeDate,
        array $data = []
    ) {
        $this->taskCollectionFactory = $taskCollectionFactory;
        $this->localeDate = $localeDate;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Framework\DataObject[]
     */
    public function getTasks()
    {
        /** @var TaskCollection $taskCollection */
        $taskCollection = $this->taskCollectionFactory->create();
        $taskCollection->addFieldToSelect('*')->load();
        return $taskCollection->getItems();
    }
}
