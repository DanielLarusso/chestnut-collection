<?php

declare(strict_types=1);

namespace Chestnut\Collection\Criteria;

use Chestnut\Collection\Expression\ExpressionInterface;
use Chestnut\Collection\Expression\ExpressionBuilderInterface;

interface CriteriaInterface
{
    public static function create(): static;

    public function expr(): ?ExpressionBuilderInterface;

    public function where(ExpressionInterface $expression): static;

    public function andWhere(ExpressionInterface $expression): static;

    public function orWhere(ExpressionInterface $expression): static;

    public function getWhereExpression(): ?ExpressionInterface;

    public function getOrderings(): array;

    public function orderBy(array $orderings): static;

    public function getFirstResult(): ?int;

    public function setFirstResult(?int $firstResult): self;

    public function getMaxResults(): ?int;

    public function setMaxResults(?int $maxResults): static;
}
