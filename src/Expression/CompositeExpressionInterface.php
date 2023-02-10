<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

interface CompositeExpressionInterface extends ExpressionInterface
{
    public function getExpressionList(): array;

    public function getType(): CompositeType;
}