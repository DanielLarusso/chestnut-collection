<?php

declare(strict_types=1);

namespace Chestnut\Collection\Expression;

enum ComparisonOperator: string
{
    case EQ = '=';
    case NEQ = '<>';
    case LT = '<';
    case LTE = '<=';
    case GT = '>';
    case GTE = '>=';
    case IN = 'IN';
    case NIN = 'NIN';
    case CONTAINS = 'CONTAINS';
}
