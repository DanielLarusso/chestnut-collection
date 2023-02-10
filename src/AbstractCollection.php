<?php

declare(strict_types=1);

namespace Chestnut\Collection;

use ArrayIterator;
use Closure;
use IteratorAggregate;
use Traversable;

use function array_filter;
use function array_map;
use function array_merge;
use function array_values;
use function count;
use function in_array;
use function is_array;
use function json_encode;

class AbstractCollection implements CollectionInterface
{
    protected array $items = [];

    protected int $position = 0;

    public function __construct(array|IteratorAggregate $items = [])
    {
        $this->addMultiple($items);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function jsonSerialize(): string
    {
        return json_encode($this->items);
    }

    public function clear(): static
    {
        $this->items = [];

        return $this;
    }

    public function isEmpty(): bool
    {
        return 0 >= $this->count();
    }

    public function exists(Closure $p): bool
    {
        foreach ($this->items as $key => $element) {
            if ($p($key, $element)) {
                return true;
            }
        }

        return false;
    }

    public function forAll(Closure $p): bool
    {
        foreach ($this->items as $key => $element) {
            if (!$p($key, $element)) {
                return false;
            }
        }

        return true;
    }

    public function map(Closure $func): static
    {
        return new static(array_map($func, $this->items));
    }

    public function filter(Closure $p): static
    {
        return new static(array_filter($this->items, $p));
    }

    public function contains($item): bool
    {
        return in_array($item, $this->items);
    }

    public function partition(Closure $p): array
    {
        $collection1 = $collection2 = [];
        foreach ($this->items as $key => $element) {
            if ($p($key, $element)) {
                $collection1[$key] = $element;
            } else {
                $collection2[$key] = $element;
            }
        }
        return [new static($collection1), new static($collection2)];
    }

//    public function matching(CriteriaInterface $criteria): static
//    {
//        $expr = $criteria->getWhereExpression();
//        $filtered = $this->getElements();
//
//        if ($expr instanceof ExpressionInterface) {
//            $visitor = new ClosureExpressionVisitor();
//            $filter = $visitor->dispatch($expr);
//            $filtered = array_filter($filtered, $filter);
//        }
//
//        if ($orderings = $criteria->getOrderings()) {
//            $next = null;
//            foreach (array_reverse($orderings) as $field => $ordering) {
//                $next = ClosureExpressionVisitor::sortByField($field, $ordering == 'DESC' ? -1 : 1, $next);
//            }
//
//            usort($filtered, $next);
//        }
//
//        $offset = $criteria->getFirstResult();
//        $length = $criteria->getMaxResults();
//
//        if ($offset || $length) {
//            $filtered = array_slice($filtered, (int)$offset, $length);
//        }
//
//        return new static($filtered);
//    }

    protected function addMultiple(array|IteratorAggregate $items): void
    {
        if ($items instanceof static) {
            $elements = array_values($items->getItems());
        } elseif (is_array($items)) {
            $elements = $items;
        } elseif ($items instanceof IteratorAggregate) {
            foreach ($items as $key => $element) {
                $elements[$key] = $element;
            }
        }

        if (!empty($elements)) {
            $this->items = array_merge($this->items, $elements);
        }
    }
}
