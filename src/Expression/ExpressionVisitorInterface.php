<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

interface ExpressionVisitorInterface
{
    public function walkComparison(ComparisonExpressionInterface $comparison): mixed;

    public function walkValue(ValueExpressionInterface $value): mixed;

    public function walkCompositeExpression(CompositeExpressionInterface $expression): mixed;

    public function dispatch(ExpressionInterface $expression): mixed;
}