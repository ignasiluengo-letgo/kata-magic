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

    /** @test */
    public function updates_normal_items_on_the_sell_date()
    {
        $item = GildedRose::of('normal', 10, 0);

        $item->tick();

        $this->assertEquals(8, $item->quality);
        $this->assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_normal_items_with_a_quality_of_0()
    {
        $item = GildedRose::of('normal', 0, 5);

        $item->tick();

        $this->assertEquals(0, $item->quality);
        $this->assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_before_the_sell_date()
    {
        $item = GildedRose::of('Aged Brie', 10, 5);

        $item->tick();

        $this->assertEquals(11, $item->quality);
        $this->assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_before_the_sell_date_with_max_quality()
    {
        $item = GildedRose::of('Aged Brie', 50, 5);

        $item->tick();

        $this->assertEquals(50, $item->quality);
        $this->assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_before_on_sell_date()
    {
        $item = GildedRose::of('Aged Brie', 10, 0);

        $item->tick();

        $this->assertEquals(12, $item->quality);
        $this->assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_brie_items_before_on_sell_date_near_max_quality()
    {
        $item = GildedRose::of('Aged Brie', 49, 0);

        $item->tick();

        $this->assertEquals(50, $item->quality);
        $this->assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_sulfuras_items_before_the_sell_date()
    {
        $item = GildedRose::of('Sulfuras, Hand of Ragnaros', 10, 5);

        $item->tick();

        $this->assertEquals(10, $item->quality);
        $this->assertEquals(5, $item->sellIn);
    }

    /** @test */
    public function updates_sulfuras_items_on_the_sell_date()
    {
        $item = GildedRose::of('Sulfuras, Hand of Ragnaros', 10, 5);

        $item->tick();

        $this->assertEquals(10, $item->quality);
        $this->assertEquals(5, $item->sellIn);
    }

    /** @test */
    public function updates_sulfuras_items_after_the_sell_date()
    {
        $item = GildedRose::of('Sulfuras, Hand of Ragnaros', 10, -1);

        $item->tick();

        $this->assertEquals(10, $item->quality);
        $this->assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_long_before_the_sell_date()
    {
        $item = GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 11);

        $item->tick();

        $this->assertEquals(11, $item->quality);
        $this->assertEquals(10, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_close_to_the_sell_date()
    {
        $item = GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 10);

        $item->tick();

        $this->assertEquals(12, $item->quality);
        $this->assertEquals(9, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_close_to_the_sell_dataity()
    {
        $item = GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 50, 10);

        $item->tick();

        $this->assertEquals(50, $item->quality);
        $this->assertEquals(9, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_very_close_to_the_sell_date()
    {
        $item = GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 5);

        $item->tick();

        $this->assertEquals(13, $item->quality); // goes up by 3
        $this->assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_very_close_to_the_sell_dateity()
    {
        $item = GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 50, 5);

        $item->tick();

        $this->assertEquals(50, $item->quality);
        $this->assertEquals(4, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_with_one_day_left_to_sell()
    {
        $item = GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 1);

        $item->tick();

        $this->assertEquals(13, $item->quality);
        $this->assertEquals(0, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_with_one_day_left_to_sellity()
    {

        $item = GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 50, 1);

        $item->tick();

        $this->assertEquals(50, $item->quality);
        $this->assertEquals(0, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_on_the_sell_date()
    {

        $item = GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 0);

        $item->tick();

        $this->assertEquals(0, $item->quality);
        $this->assertEquals(-1, $item->sellIn);
    }

    /** @test */
    public function updates_backstage_pass_items_after_the_sell_date()
    {

        $item = GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, -1);

        $item->tick();

        $this->assertEquals(0, $item->quality);
        $this->assertEquals(-2, $item->sellIn);
    }
}
