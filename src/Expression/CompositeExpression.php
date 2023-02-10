<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

class CompositeExpression implements CompositeExpressionInterface
{
    private readonly CompositeType $type;
    private array $expressions;

    public function __construct(
        CompositeType $type,
        ComparisonExpressionInterface|CompositeExpressionInterface ...$expressions
    ) {
        $this->type = $type;
        $this->expressions = $expressions;
    }

    public function getExpressionList(): array
    {
        return $this->expressions;
    }

    public function getType(): CompositeType
    {
        return $this->type;
    }

    public function visit(ExpressionVisitorInterface $visitor): mixed
    {
        // todo would be nicer if it was $visitor->walk($this);
        return $visitor->walkCompositeExpression($this);
    }
}