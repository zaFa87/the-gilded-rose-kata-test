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

class AgedBrie extends Items
{
    public function tick(){
        $this->sellIn = $this->sellIn - 1;
        $this->quality = min($this->quality + 1, 50);
            
        if ($this->sellIn <= 0) 
            $this->quality = min($this->quality + 1, 50);       
    }
}

class SulfurasHandofRagnaros extends Items
{
    public function tick(){}
}

class BackstagepassestoaTAFKAL80ETCconcert extends Items
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

class Conjured extends Items
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

class ForgeClassName{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getClassName()
    {
        return 'Dyflexis\Applicants\Advanced\\'.preg_replace("/[\s,]/", "", $this->name);
    }
}

class GildedRose
{
    
    public static function of($name, $quality, $sellIn) {
        $forgedName = new ForgeClassName($name);
        $className = $forgedName->getClassName();
        if(class_exists($className))
            return new $className($quality, $sellIn);
    
        return new Items($quality, $sellIn);   
    }
}