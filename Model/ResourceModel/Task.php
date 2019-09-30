<?php

namespace Kstools\Todo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Task extends AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('kstools_todo_task', 'task_id');
    }
}
