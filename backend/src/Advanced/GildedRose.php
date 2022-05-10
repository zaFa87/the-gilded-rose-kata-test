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

class AgedBrieItem extends Items
{
    public function tick(){
        $this->sellIn = $this->sellIn - 1;
        $this->quality = min($this->quality + 1, 50);
            
        if ($this->sellIn <= 0) 
            $this->quality = min($this->quality + 1, 50);       
    }
}

class SulfurasItem extends Items
{
    public function tick(){}
}

class BackstagePasses extends Items
{
    public function tick()
    {
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
}

class ConjuredItem extends Items
{
    public function tick()
    {
        $this->sellIn = $this->sellIn - 1;

        if ($this->quality > 0)
            $this->quality = max($this->quality - 2, 0);

        if ($this->sellIn < 0) 
            $this->quality = max($this->quality - 2, 0);
    }
}
class GildedRose
{
    
    public static function of($name, $quality, $sellIn) {
        
        if($name == 'Aged Brie')
            return new AgedBrieItem($quality, $sellIn);
        
        if($name == 'Sulfuras, Hand of Ragnaros')
            return new SulfurasItem($quality, $sellIn);

        if($name == 'Backstage passes to a TAFKAL80ETC concert')
            return new BackstagePasses($quality, $sellIn);    

        if($name == 'Conjured')
            return new ConjuredItem($quality, $sellIn);
        
        return new Items($quality, $sellIn);   
    }
}