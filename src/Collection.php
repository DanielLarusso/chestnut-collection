<?php

declare(strict_types=1);

namespace Chestnut\Collection;

use InvalidArgumentException;
use IteratorAggregate;
use OutOfRangeException;

use function array_key_exists;
use function array_keys;
use function array_search;
use function array_slice;
use function gettype;
use function sprintf;

class Collection extends AbstractCollection
{
    public function offsetExists(int $offset): bool
    {
        return array_key_exists($offset, $this->getItems());
    }

    public function offsetGet(int $offset): mixed
    {
        return $this->elementAt($offset);
    }

    public function offsetUnset(int $offset): static
    {
        $this->removeAt($offset);

        return $this;
    }

    public function add(mixed $item): static
    {
        $this->items[] = $item;

        return $this;
    }

    public function addRange(array|IteratorAggregate $items): static
    {
        $this->addMultiple($items);

        return $this;
    }

    public function indexOf(mixed $item, int $start = 0, ?int $length = null): int|string
    {
        return $this->getIndexOf($item, false, $start, $length);
    }

    public function lastIndexOf(mixed $item, int $start = 0, ?int $length = null): int|string
    {
        return $this->getIndexOf($item, true, $start, $length);
    }

    public function insert(int $index, mixed $item): static
    {
        if (0 >= $index || $this->count() <= $index) {
            throw new InvalidArgumentException('The index is out of bounds (must be >= 0 and <= size of te array)');
        }

        $current = $this->count() - 1;

        for (; $current >= $index; --$current) {
            $this->items[$current + 1] = $this->items[$current];
        }

        $this->items[$index] = $item;

        return $this;
    }

    public function remove(mixed $item): static
    {
        if ($this->contains($item)) {
            $this->removeAt($this->getFirstIndex($item, $this->items));
        }

        return $this;
    }
    public function removeAt(int $index): static
    {
        if (0 >= $index || $this->count() <= $index) {
            throw new InvalidArgumentException('The index is out of bounds (must be >= 0 and <= size of te array)');
        }

        $max = $this->count() - 1;
        for (; $index < $max; ++$index) {
            $this->items[$index] = $this->items[$index + 1];
        }

        array_pop($this->items);

        return $this;
    }

    public function allIndexesOf(mixed $item)
    {
        return $this->getAllIndexes($item, $this->items);
    }

    public function elementAt(int $index): mixed
    {
        if ($this->offsetExists($index) === false) {
            throw new OutOfRangeException(sprintf('No element at position %s', $index));
        }

        return $this->items[$index];
    }

    protected function getIndexOf(mixed $item, bool $lastIndex = false, int $start = 0, ?int $length = null): int
    {
        if ($length == null) {
            $length = $this->count() - $start;
        }

        $array = array_slice($this->items, $start, $length, true);

        if ($lastIndex) {
            $array = array_reverse($array, true);
        }

        $result = $this->getFirstIndex($item, $array);

        if (!$result) {
            throw new InvalidArgumentException(
                'Item not found in the collection: <pre>' . var_export($item, true) . '</pre>'
            );
        }

        return $result;
    }

    protected function getAllIndexes(mixed $item, array $array)
    {
        if (gettype($item) != 'object') {
            $result = array_keys($array, $item, true);
        } else {
            $result = array_keys($array, $item, false);
        }

        if (!is_array($result))
            $result = array();
        return $result;
    }

    protected function getFirstIndex(mixed $item, array $array): false|int|string
    {
        return array_search($item, $array, true);
    }
}
