<?php

namespace Dyflexis\Applicants\Advanced;

class Items
{
    public $quality;

    public $sellIn;

    public function __construct($quality, $sellIn)
    {
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public function tick()
    {
        $this->quality = max($this->quality - 1, 0);
        $this->sellIn = $this->sellIn - 1;

        if ($this->sellIn < 0)
            $this->quality = max($this->quality - 1, 0);
    }
}

class Aged extends Items
{
    public function tick(){
        $this->sellIn = $this->sellIn - 1;
        $this->quality = min($this->quality + 1, 50);
            
        if ($this->sellIn <= 0) 
            $this->quality = min($this->quality + 1, 50);       
    }
}

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
        
        if($name == 'Aged Brie'){
            return new Aged($quality, $sellIn);
        }
        
        return new static($name, $quality, $sellIn);
        
    }

    public function agedBrieItem(){
        $this->sellIn = $this->sellIn - 1;
        $this->quality = min($this->quality + 1, 50);
        
        if ($this->sellIn <= 0) 
            $this->quality = min($this->quality + 1, 50);        
    }

    public function sulfurasItem(){
        return;
    }

    public function backstagePasses(){
        $this->sellIn = $this->sellIn - 1;

        if ($this->quality < 50) {
            $this->quality = $this->quality + 1;

            if ($this->sellIn < 10) 
                $this->quality = min($this->quality + 1, 50);

            if ($this->sellIn < 6) 
                $this->quality = min($this->quality + 1, 50);
        }

        if ($this->sellIn < 0)
            $this->quality = $this->quality - $this->quality;
    }

    public function normalItem(){
        $this->quality = max($this->quality - 1, 0);
        $this->sellIn = $this->sellIn - 1;

        if ($this->sellIn < 0)
            $this->quality = max($this->quality - 1, 0);
    }

    public function conjuredItem()
    {
        $this->sellIn = $this->sellIn - 1;

        if ($this->quality > 0)
            $this->quality = max($this->quality - 2, 0);

        if ($this->sellIn < 0) 
            $this->quality = max($this->quality - 2, 0);
    }

    public function tick()
    {
        // if($this->name == 'Aged Brie'){
        //     $this->agedBrieItem();
        //     return;
        // }

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