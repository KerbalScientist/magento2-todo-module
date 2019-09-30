<?php

namespace Kstools\Todo\Api;

use Kstools\Todo\Api\Data\TaskInterface;
use Kstools\Todo\Api\Data\TaskSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface TaskRepositoryInterface
{

    /**
     * Save Task
     * @param TaskInterface $task
     * @return TaskInterface
     * @throws LocalizedException
     */
    public function save(
        TaskInterface $task
    );

    /**
     * Retrieve Task
     * @param string $taskId
     * @return TaskInterface
     * @throws LocalizedException
     */
    public function getById($taskId);

    /**
     * Retrieve Task matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return TaskSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Task
     * @param TaskInterface $task
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        TaskInterface $task
    );

    /**
     * Delete Task by ID
     * @param string $taskId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($taskId);
}
