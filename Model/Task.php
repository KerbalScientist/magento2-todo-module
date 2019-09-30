<?php
/**
 * Copyright (c) 2019
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Kstools\Todo\Model;

use Kstools\Todo\Api\Data\TaskInterface;
use Kstools\Todo\Api\Data\TaskInterfaceFactory;
use Kstools\Todo\Model\ResourceModel\Task\Collection;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class Task extends AbstractModel
{
    protected $_eventPrefix = 'kstools_todo_task';
    protected $taskDataFactory;

    protected $dataObjectHelper;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param TaskInterfaceFactory $taskDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\Task $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        TaskInterfaceFactory $taskDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\Task $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->taskDataFactory = $taskDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve task model with task data
     * @return TaskInterface
     */
    public function getDataModel()
    {
        $taskData = $this->getData();

        $taskDataObject = $this->taskDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $taskDataObject,
            $taskData,
            TaskInterface::class
        );

        return $taskDataObject;
    }
}
