<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

class ExpressionBuilder implements ExpressionBuilderInterface
{
    public function __construct(private readonly ExpressionFactory $factory)
    {
    }

    public function andX(
        ComparisonExpressionInterface|CompositeExpressionInterface ...$expressions
    ): CompositeExpressionInterface {
        return $this->factory->createCompositeExpression(CompositeType::AND, $expressions);
    }

    public function orX(
        ComparisonExpressionInterface|CompositeExpressionInterface ...$expressions
    ): CompositeExpressionInterface {
        return $this->factory->createCompositeExpression(CompositeType::OR, $expressions);
    }

    public function eq(string $field, mixed $value): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::EQ,
            $this->factory->createValueExpression($value)
        );
    }

    public function gt(string $field, mixed $value): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::GT,
            $this->factory->createValueExpression($value)
        );
    }

    public function lt(string $field, mixed $value): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::LT,
            $this->factory->createValueExpression($value)
        );
    }

    public function gte(string $field, mixed $value): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::GTE,
            $this->factory->createValueExpression($value)
        );
    }

    public function lte(string $field, mixed $value): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::LTE,
            $this->factory->createValueExpression($value)
        );
    }

    public function neq(string $field, mixed $value): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::NEQ,
            $this->factory->createValueExpression($value)
        );
    }

    public function null(string $field): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::EQ,
            $this->factory->createValueExpression(null)
        );
    }

    public function in(string $field, array $values): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::IN,
            $this->factory->createValueExpression($values)
        );
    }

    public function notNull(string $field): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::NEQ,
            $this->factory->createValueExpression(null)
        );
    }

    public function notIn(string $field, array $values): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::NIN,
            $this->factory->createValueExpression($values)
        );
    }

    public function contains(string $field, mixed $value): ComparisonExpressionInterface
    {
        return $this->factory->createComparisonExpression(
            $field,
            ComparisonOperator::CONTAINS,
            $this->factory->createValueExpression($value)
        );
    }
}