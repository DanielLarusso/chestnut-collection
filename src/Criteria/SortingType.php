<?php

declare(strict_types=1);

namespace Chestnut\Collection\Criteria;

enum SortingType: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';
}