<?php

namespace Kstools\Todo\Model;

use Exception;
use Kstools\Todo\Api\Data\TaskInterface;
use Kstools\Todo\Api\Data\TaskInterfaceFactory;
use Kstools\Todo\Api\Data\TaskSearchResultsInterfaceFactory;
use Kstools\Todo\Api\TaskRepositoryInterface;
use Kstools\Todo\Model\ResourceModel\Task as ResourceTask;
use Kstools\Todo\Model\ResourceModel\Task\CollectionFactory as TaskCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class TaskRepository implements TaskRepositoryInterface
{
    protected $taskCollectionFactory;

    protected $dataTaskFactory;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;
    protected $dataObjectHelper;

    protected $extensionAttributesJoinProcessor;

    private $storeManager;

    protected $resource;

    protected $searchResultsFactory;

    protected $taskFactory;

    protected $dataObjectProcessor;

    /**
     * @param ResourceTask $resource
     * @param TaskFactory $taskFactory
     * @param TaskInterfaceFactory $dataTaskFactory
     * @param TaskCollectionFactory $taskCollectionFactory
     * @param TaskSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceTask $resource,
        TaskFactory $taskFactory,
        TaskInterfaceFactory $dataTaskFactory,
        TaskCollectionFactory $taskCollectionFactory,
        TaskSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->taskFactory = $taskFactory;
        $this->taskCollectionFactory = $taskCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTaskFactory = $dataTaskFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        TaskInterface $task
    ) {
        /* if (empty($task->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $task->setStoreId($storeId);
        } */

        $taskData = $this->extensibleDataObjectConverter->toNestedArray(
            $task,
            [],
            TaskInterface::class
        );

        $taskModel = $this->taskFactory->create()->setData($taskData);

        try {
            $this->resource->save($taskModel);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the task: %1',
                $exception->getMessage()
            ));
        }
        return $taskModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($taskId)
    {
        $task = $this->taskFactory->create();
        $this->resource->load($task, $taskId);
        if (!$task->getId()) {
            throw new NoSuchEntityException(__('Task with id "%1" does not exist.', $taskId));
        }
        return $task->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ) {
        $collection = $this->taskCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            TaskInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        TaskInterface $task
    ) {
        try {
            $taskModel = $this->taskFactory->create();
            $this->resource->load($taskModel, $task->getTaskId());
            $this->resource->delete($taskModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Task: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($taskId)
    {
        return $this->delete($this->getById($taskId));
    }
}
