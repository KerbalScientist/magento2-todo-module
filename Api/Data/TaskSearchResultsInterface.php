<?php

namespace Kstools\Todo\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TaskSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get Task list.
     * @return TaskInterface[]
     */
    public function getItems();

    /**
     * Set Title list.
     * @param TaskInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
