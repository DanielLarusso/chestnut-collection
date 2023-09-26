<?php

declare(strict_types=1);

namespace Chestnut\Collection\Criteria;

use Chestnut\Collection\Expression\CompositeExpression;
use Chestnut\Collection\Expression\CompositeType;
use Chestnut\Collection\Expression\ExpressionBuilder;
use Chestnut\Collection\Expression\ExpressionBuilderInterface;
use Chestnut\Collection\Expression\ExpressionFactory;
use Chestnut\Collection\Expression\ExpressionInterface;

class Criteria implements CriteriaInterface
{
    private ?ExpressionBuilder $expressionBuilder = null;

    public function __construct(
        private ?ExpressionInterface $expression = null,
        private ?array $orderings = null,
        private ?int $firstResult = null,
        private ?int $maxResults = null
    ) {

    }

    public static function create(): static
    {
        return new static();
    }

    public function expr(): ?ExpressionBuilderInterface
    {
        if ($this->expressionBuilder === null) {
            $this->expressionBuilder = new ExpressionBuilder(new ExpressionFactory());
        }
        return $this->expressionBuilder;
    }

    public function where(ExpressionInterface $expression): static
    {
        $this->expression = $expression;

        return $this;
    }

    public function andWhere(ExpressionInterface $expression): static
    {
        if (null === $this->expression) {
            return $this->where($expression);
        }

        $this->expression = new CompositeExpression(CompositeType::AND, $this->expression, $expression);

        return $this;
    }

    public function orWhere(ExpressionInterface $expression): static
    {
        // TODO: Implement orWhere() method.
    }

    public function getWhereExpression(): ?ExpressionInterface
    {
        // TODO: Implement getWhereExpression() method.
    }

    public function getOrderings(): array
    {
        // TODO: Implement getOrderings() method.
    }

    public function orderBy(array $orderings): static
    {
        // TODO: Implement orderBy() method.
    }

    public function getFirstResult(): ?int
    {
        // TODO: Implement getFirstResult() method.
    }

    public function setFirstResult(?int $firstResult): CriteriaInterface
    {
        // TODO: Implement setFirstResult() method.
    }

    public function getMaxResults(): ?int
    {
        // TODO: Implement getMaxResults() method.
    }

    public function setMaxResults(?int $maxResults): static
    {
        // TODO: Implement setMaxResults() method.
    }
}
