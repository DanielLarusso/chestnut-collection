<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

readonly class ComparisonExpression implements ComparisonExpressionInterface
{
    public function __construct(
        private string $field,
        private ComparisonOperator $operator,
        private ValueExpressionInterface $value
    ) {
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getValue(): ValueExpressionInterface
    {
        return $this->value;
    }

    public function getOperator(): ComparisonOperator
    {
        return $this->operator;
    }

    public function visit(ExpressionVisitorInterface $visitor): mixed
    {
        return $visitor->walkComparison($this);
    }
}