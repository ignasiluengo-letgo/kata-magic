<?php

declare(strict_types=1);

namespace Test\App;

use App\GildedRose;
use PHPUnit\Framework\TestCase;

final class GildedRoseTest extends TestCase
{
    /** @test */
    public function updates_normal_items_before_sell_date()
    {
        $item = GildedRose::of('normal', 10, 5); // quality, sell in X days

        $item->tick();

        $this->assertEquals(9, $item->quality);
        $this->assertEquals(4, $item->sellIn);
    }
}
