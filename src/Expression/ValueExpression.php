<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

readonly class ValueExpression implements ValueExpressionInterface
{
    public function __construct(private mixed $value)
    {
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function visit(ExpressionVisitorInterface $visitor): mixed
    {
        return $visitor->walkValue($this);
    }
}