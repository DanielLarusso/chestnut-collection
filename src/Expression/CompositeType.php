<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

enum CompositeType: string
{
    case AND = 'AND';
    case OR = 'OR';
}
