<?php

namespace Kstools\Todo\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface TaskInterface extends ExtensibleDataInterface
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const TASK_ID = 'task_id';
    const DUE_DATE = 'due_date';

    /**
     * Get task_id
     *
     * @return string|null
     */
    public function getTaskId();

    /**
     * Set task_id
     *
     * @param string $taskId
     * @return TaskInterface
     */
    public function setTaskId($taskId);

    /**
     * Get Title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Set Title
     *
     * @param string $title
     * @return TaskInterface
     */
    public function setTitle($title);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return TaskExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param TaskExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        TaskExtensionInterface $extensionAttributes
    );

    /**
     * Get Description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Set Description
     *
     * @param string $description
     * @return TaskInterface
     */
    public function setDescription($description);

    /**
     * Get Due_Date
     *
     * @return string|null
     */
    public function getDueDate();

    /**
     * Set Due_Date
     *
     * @param string $dueDate
     * @return TaskInterface
     */
    public function setDueDate($dueDate);
}
