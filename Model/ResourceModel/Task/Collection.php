<?php

namespace Kstools\Todo\Model\ResourceModel\Task;

use Kstools\Todo\Model\ResourceModel\Task;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Kstools\Todo\Model\Task::class,
            Task::class
        );
    }
}
