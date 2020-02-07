<?php

namespace App;

class GildedRose
{
    const BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT = 'Backstage passes to a TAFKAL80ETC concert';
    const SULFURAS_HAND_OF_RAGNAROS                   = 'Sulfuras, Hand of Ragnaros';
    const AGED_BRIE                                   = 'Aged Brie';
    public $name;
    public $quality;
    public $sellIn;

    private function __construct($name, $quality, $sellIn)
    {
        $this->name    = $name;
        $this->quality = $quality;
        $this->sellIn  = $sellIn;
    }

    public static function of($name, $quality, $sellIn)
    {
        return new static($name, $quality, $sellIn);
    }

    public function tick()
    {
        if ($this->isNormal()) {
            if ($this->qualityHigherThan0()) {
                $this->decreaseQuality();
            }

            $this->decreaseExpiration();

            if ($this->isExpired()) {
                if ($this->qualityHigherThan0()) {
                    $this->decreaseQuality();
                }
            }
        }

        if ($this->name == self::BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT) {
            if ($this->qualityLessThan50()) {
                $this->increaseQuality();
            }

            if ($this->sellinLessThan11() and $this->qualityLessThan50()) {
                $this->increaseQuality();
            }
            if ($this->sellinLessThan6() and $this->qualityLessThan50()) {
                $this->increaseQuality();
            }

            $this->decreaseExpiration();

            if ($this->isExpired()) {
                $this->quality = 0;
            }
        }

        if ($this->name === self::AGED_BRIE) {
            if ($this->qualityLessThan50()) {
                $this->increaseQuality();
            }

            $this->decreaseExpiration();

            if ($this->isExpired()) {
                if ($this->qualityLessThan50()) {
                    $this->increaseQuality();
                }
            }
        }
    }

    private
    function qualityLessThan50(): bool
    {
        return $this->quality < 50;
    }

    private
    function qualityHigherThan0(): bool
    {
        return $this->quality > 0;
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

    private
    function decreaseQuality(): void
    {
        $this->quality = $this->quality - 1;
    }

    private
    function increaseQuality(): void
    {
        $this->quality = $this->quality + 1;
    }

    private
    function isExpired(): bool
    {
        return $this->sellIn < 0;
    }

    private
    function decreaseExpiration(): void
    {
        $this->sellIn = $this->sellIn - 1;
    }

    private
    function isNormal(): bool
    {
        return $this->name != self::AGED_BRIE and
               $this->name != self::BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT and
               $this->name != self::SULFURAS_HAND_OF_RAGNAROS;
    }
}
