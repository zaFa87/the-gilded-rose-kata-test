<?php

namespace Dyflexis\Applicants\Advanced;

class GildedRose
{
    public $name;

    public $quality;

    public $sellIn;

    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public static function of($name, $quality, $sellIn) {
        return new static($name, $quality, $sellIn);
    }

    public function itemAgedBrie(){
        $this->sellIn = $this->sellIn - 1;
        
        if ($this->quality < 50)
            $this->quality = $this->quality + 1;

        if ($this->sellIn <= 0 and $this->quality < 50) 
            $this->quality = $this->quality + 1;        
    }

    public function itemSulfuras(){
        return;
    }

    public function itemBackstage(){
        $this->sellIn = $this->sellIn - 1;

        if ($this->quality < 50) {
            $this->quality = $this->quality + 1;

            if ($this->sellIn < 10) {
                if ($this->quality < 50){
                    $this->quality = $this->quality + 1;
                }
            }

            if ($this->sellIn < 6) {
                if ($this->quality < 50) {
                    $this->quality = $this->quality + 1;
                }
            }
        }

        if ($this->sellIn < 0)
            $this->quality = $this->quality - $this->quality;
    }

    public function itemNormal(){
        if ($this->quality > 0) {
            $this->quality = $this->quality - 1;
        }
        $this->sellIn = $this->sellIn - 1;

        if ($this->sellIn < 0) {
            if ($this->quality > 0) {
                $this->quality = $this->quality - 1;
            }
        }
    }

    public function tick()
    {
        if($this->name == 'Aged Brie'){
            $this->itemAgedBrie();
            return;
        }

        if($this->name == 'Sulfuras, Hand of Ragnaros'){
            $this->itemSulfuras();
            return;
        }

        if($this->name == 'Backstage passes to a TAFKAL80ETC concert'){
            $this->itemBackstage();
            return;
        }

        $this->itemNormal();
        return;
    }
}