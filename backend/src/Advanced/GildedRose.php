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

    public function agedBrieItem(){
        $this->sellIn = $this->sellIn - 1;
        
        if ($this->quality < 50)
            $this->quality = $this->quality + 1;

        if ($this->sellIn <= 0 and $this->quality < 50) 
            $this->quality = $this->quality + 1;        
    }

    public function sulfurasItem(){
        return;
    }

    public function backstagePasses(){
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

    public function normalItem(){
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

    public function conjuredItem(){
        if ($this->quality > 1) {
            $this->quality = $this->quality - 2;
        }else{
            $this->quality = $this->quality - 1;
        }
        
        $this->sellIn = $this->sellIn - 1;

        if ($this->sellIn < 0) {
            if ($this->quality > 2) {
                $this->quality = $this->quality - 2;
            }else{
                $this->quality = $this->quality - 1;
            }
        }
    }

    public function tick()
    {
        if($this->name == 'Aged Brie'){
            $this->agedBrieItem();
            return;
        }

        if($this->name == 'Sulfuras, Hand of Ragnaros'){
            $this->sulfurasItem();
            return;
        }

        if($this->name == 'Backstage passes to a TAFKAL80ETC concert'){
            $this->backstagePasses();
            return;
        }

        if($this->name == 'Conjured'){
            $this->conjuredItem();
            return;
        }

        $this->normalItem();
        return;
    }
}