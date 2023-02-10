<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

interface ComparisonExpressionInterface extends ExpressionInterface
{
    public function getField(): string;

    public function getValue(): ValueExpressionInterface;

    public function getOperator(): ComparisonOperator;
}