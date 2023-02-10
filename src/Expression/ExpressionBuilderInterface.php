<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

interface ExpressionBuilderInterface
{
    public function andX(
        ComparisonExpressionInterface|CompositeExpressionInterface ...$expressions
    ): CompositeExpressionInterface;

    public function orX(
        ComparisonExpressionInterface|CompositeExpressionInterface ...$expressions
    ): CompositeExpressionInterface;

    public function eq(string $field, mixed $value): ComparisonExpressionInterface;

    public function gt(string $field, mixed $value): ComparisonExpressionInterface;

    public function lt(string $field, mixed $value): ComparisonExpressionInterface;

    public function gte(string $field, mixed $value): ComparisonExpressionInterface;

    public function lte(string $field, mixed $value): ComparisonExpressionInterface;

    public function neq(string $field, mixed $value): ComparisonExpressionInterface;

    public function null(string $field): ComparisonExpressionInterface;

    public function in(string $field, array $values): ComparisonExpressionInterface;

    public function notNull(string $field): ComparisonExpressionInterface;

    public function notIn(string $field, array $values): ComparisonExpressionInterface;

    public function contains(string $field, mixed $value): ComparisonExpressionInterface;
}