<?php

namespace Kstools\Todo\Model\Data;

use Kstools\Todo\Api\Data\TaskExtensionInterface;
use Kstools\Todo\Api\Data\TaskInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

class Task extends AbstractExtensibleObject implements TaskInterface
{

    /**
     * Get task_id
     * @return string|null
     */
    public function getTaskId()
    {
        return $this->_get(self::TASK_ID);
    }

    /**
     * Set task_id
     * @param string $taskId
     * @return TaskInterface
     */
    public function setTaskId($taskId)
    {
        return $this->setData(self::TASK_ID, $taskId);
    }

    /**
     * Get Title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->_get(self::TITLE);
    }

    /**
     * Set Title
     * @param string $title
     * @return TaskInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Magento\Framework\Api\ExtensionAttributesInterface
     */
    public function getExtensionAttributes()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param TaskExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        TaskExtensionInterface $extensionAttributes
    ) {
        /** @noinspection PhpParamsInspection */
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get Description
     * @return string|null
     */
    public function getDescription()
    {
        return $this->_get(self::DESCRIPTION);
    }

    /**
     * Set Description
     * @param string $description
     * @return TaskInterface
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Get Due_Date
     * @return string|null
     */
    public function getDueDate()
    {
        return $this->_get(self::DUE_DATE);
    }

    /**
     * Set Due_Date
     * @param string $dueDate
     * @return TaskInterface
     */
    public function setDueDate($dueDate)
    {
        return $this->setData(self::DUE_DATE, $dueDate);
    }
}
