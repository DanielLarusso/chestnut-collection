<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

use RuntimeException;

use function get_class;
use function sprintf;

abstract class AbstractExpressionVisitor implements ExpressionVisitorInterface
{
    public function dispatch(ExpressionInterface $expression): mixed
    {
        // todo https://refactoring.guru/design-patterns/state
        switch (true) {
            case ($expression instanceof ComparisonExpressionInterface):
                return $this->walkComparison($expression);

            case ($expression instanceof ValueExpressionInterface):
                return $this->walkValue($expression);

            case ($expression instanceof CompositeExpressionInterface):
                return $this->walkCompositeExpression($expression);

            default:
                throw new RuntimeException(sprintf('Unknown Expression %s', get_class($expression)));
        }
    }
}