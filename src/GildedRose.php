<?php

namespace App;

class GildedRose
{
    private const BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT = 'Backstage passes to a TAFKAL80ETC concert';
    private const SULFURAS_HAND_OF_RAGNAROS = 'Sulfuras, Hand of Ragnaros';
    private const AGED_BRIE = 'Aged Brie';
    private const NORMAL = 'normal';

    public $name;
    public $quality;
    public $sellIn;

    private function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public static function of($name, $quality, $sellIn)
    {
        return new static($name, $quality, $sellIn);
    }

    public function tick()
    {
        if ($this->isSulfuras()) {
            $this->sulfurasTick();
        }

        if ($this->isNormal()) {
            $this->normalTick();
        }

        if ($this->isBackStage()) {
            $this->tickBackStage();
        }

        if ($this->isAgedBrie()) {
            $this->tickAgedBrie();
        }
    }

    private
    function isNormal(): bool
    {
        return self::NORMAL === $this->name;
    }

    private
    function decreaseQuality(): void
    {
        if ($this->quality <= 0) {
            return;
        }

        $this->quality = $this->quality - 1;
    }

    private
    function decreaseExpiration(): void
    {
        $this->sellIn = $this->sellIn - 1;
    }

    private
    function isExpired(): bool
    {
        return $this->sellIn < 0;
    }

    private
    function increaseQuality(): void
    {
        if ($this->quality >= 50) {
            return;
        }

        $this->quality = $this->quality + 1;
    }

    private
    function sellinLessThan11(): bool
    {
        return $this->sellIn < 11;
    }

    private
    function sellinLessThan6(): bool
    {
        return $this->sellIn < 6;
    }

    private function normalTick(): void
    {
        $this->decreaseQuality();
        $this->decreaseExpiration();

        if ($this->isExpired()) {
            $this->decreaseQuality();
        }
    }

    private function tickBackStage(): void
    {
        $this->increaseQuality();

        if ($this->sellinLessThan11()) {
            $this->increaseQuality();
        }
        if ($this->sellinLessThan6()) {
            $this->increaseQuality();
        }

        $this->decreaseExpiration();

        if ($this->isExpired()) {
            $this->quality = 0;
        }
    }

    private function tickAgedBrie(): void
    {
        $this->increaseQuality();

        $this->decreaseExpiration();

        if ($this->isExpired()) {
            $this->increaseQuality();
        }
    }

    private function isSulfuras(): bool
    {
        return self::SULFURAS_HAND_OF_RAGNAROS === $this->name;
    }

    private function sulfurasTick(): void
    {
        return;
    }

    private function isBackStage(): bool
    {
        return self::BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT === $this->name;
    }

    private function isAgedBrie(): bool
    {
        return self::AGED_BRIE === $this->name;
    }
}
