<?php

declare(strict_types=1);

namespace Chestnut\Collection\Tests\Unit;

use Chestnut\Collection\Collection;
use Chestnut\Collection\CollectionInterface;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testCollection(): void
    {
        $result = new Collection();
        
        $this->assertInstanceOf(CollectionInterface::class, $result);
    }
}