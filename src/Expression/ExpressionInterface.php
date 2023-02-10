<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

interface ExpressionInterface
{
    public function visit(ExpressionVisitorInterface $visitor): mixed;
}