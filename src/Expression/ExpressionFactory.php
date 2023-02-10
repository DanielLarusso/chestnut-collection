<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

class ExpressionFactory
{
    public function createCompositeExpression(
        CompositeType $type,
        ComparisonExpressionInterface|CompositeExpressionInterface ...$expressions
    ): CompositeExpressionInterface {
        return new CompositeExpression($type, $expressions);
    }

    public function createComparisonExpression(
        string $field,
        ComparisonOperator $operator,
        ValueExpressionInterface $expression
    ): ComparisonExpressionInterface {
        return new ComparisonExpression($field, $operator, $expression);
    }

    public function createValueExpression(
        mixed $value
    ): ValueExpressionInterface {
        return new ValueExpression($value);
    }
}