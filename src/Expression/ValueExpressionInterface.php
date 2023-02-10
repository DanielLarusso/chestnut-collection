<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

interface ValueExpressionInterface extends ExpressionInterface
{
    public function getValue(): mixed;
}