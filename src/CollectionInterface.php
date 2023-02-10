<?php

declare(strict_types=1);

namespace Chestnut\Collection;

use Closure;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Chestnut\Collection\Criteria\CriteriaInterface;

interface CollectionInterface extends Countable, IteratorAggregate, JsonSerializable
{
    public function clear(): static;

    public function isEmpty(): bool;

//    public function contains(mixed $item): static;

    public function exists(Closure $p): bool;

    public function forAll(Closure $p): bool;

    public function map(Closure $func): static;

    public function filter(Closure $p): static;

    public function partition(Closure $p): array;

//    public function matching(CriteriaInterface $criteria): static;
}
