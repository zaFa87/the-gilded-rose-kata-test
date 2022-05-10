<?php

namespace Dyflexis\Applicants\Advanced\Test;

use Dyflexis\Applicants\Advanced\GildedRose;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @dataProvider normalItems
     * @dataProvider brieItems
     * @dataProvider sulfurasItems
     * @dataProvider backstagePasses
     * @dataProvider conjuredItems
     */
    public function test_it_creates_correctly($item, int $expectedQuality, int $expectedSellIn): void
    {
        
        $item->tick();

        self::assertEquals($item->quality, $expectedQuality);
        self::assertEquals($item->sellIn, $expectedSellIn);
    }

    public function normalItems(): array
    {
        return [
            'updates normal items before sell date' => [
                'item' => GildedRose::of('normal', 10, 5),
                'expectedQuality' => 9,
                'expectedSellIn' => 4,
            ],
            'updates normal items on the sell date' => [
                'item' => GildedRose::of('normal', 10, 0),
                'expectedQuality' => 8,
                'expectedSellIn' => -1,
            ],
            'updates normal items after the sell date' => [
                'item' => GildedRose::of('normal', 10, -5),
                'expectedQuality' => 8,
                'expectedSellIn' => -6,
            ],
            'updates normal items with a quality of 0' => [
                'item' => GildedRose::of('normal', 0, 5),
                'expectedQuality' => 0,
                'expectedSellIn' => 4,
            ],
        ];
    }

    public function brieItems(): array
    {
        return [
            'updates Brie items before the sell date' => [
                'item' => GildedRose::of('Aged Brie', 10, 5),
                'expectedQuality' => 11,
                'expectedSellIn' => 4,
            ],
            'updates Brie items before the sell date with maximum quality' => [
                'item' => GildedRose::of('Aged Brie', 50, 5),
                'expectedQuality' => 50,
                'expectedSellIn' => 4,
            ],
            'updates Brie items on the sell date' => [
                'item' => GildedRose::of('Aged Brie', 10, 0),
                'expectedQuality' => 12,
                'expectedSellIn' => -1,
            ],
            'updates Brie items on the sell date, near maximum quality' => [
                'item' => GildedRose::of('Aged Brie', 49, 0),
                'expectedQuality' => 50,
                'expectedSellIn' => -1,
            ],
            'updates Brie items on the sell date with maximum quality' => [
                'item' => GildedRose::of('Aged Brie', 50, 0),
                'expectedQuality' => 50,
                'expectedSellIn' => -1,
            ],
            'updates Brie items after the sell date' => [
                'item' => GildedRose::of('Aged Brie', 10, -10),
                'expectedQuality' => 12,
                'expectedSellIn' => -11,
            ],
            'updates Briem items after the sell date with maximum quality' => [
                'item' => GildedRose::of('Aged Brie', 50, -10),
                'expectedQuality' => 50,
                'expectedSellIn' => -11,
            ],
        ];
    }

    public function sulfurasItems(): array
    {
        return [
            'updates Sulfuras items before the sell date' => [
                'item' => GildedRose::of('Sulfuras, Hand of Ragnaros', 10, 5),
                'expectedQuality' => 10,
                'expectedSellIn' => 5,
            ],
            'updates Sulfuras items on the sell date' => [
                'item' => GildedRose::of('Sulfuras, Hand of Ragnaros', 10, 5),
                'expectedQuality' => 10,
                'expectedSellIn' => 5,
            ],
            'updates Sulfuras items after the sell date' => [
                'item' => GildedRose::of('Sulfuras, Hand of Ragnaros', 10, -1),
                'expectedQuality' => 10,
                'expectedSellIn' => -1,
            ],
        ];
    }

    public function backstagePasses(): array
    {
        /**
         *  "Backstage passes", like aged brie, increases in Quality as it's SellIn
         *  value approaches; Quality increases by 2 when there are 10 days or
         *  less and by 3 when there are 5 days or less but Quality drops to
         *  0 after the concert
         */
        return [
            'updates Backstage pass items long before the sell date' => [
                'item' => GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 11),
                'expectedQuality' => 11,
                'expectedSellIn' => 10,
            ],
            'updates Backstage pass items close to the sell date' => [
                'item' => GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 10),
                'expectedQuality' => 12,
                'expectedSellIn' => 9,
            ],
            'updates Backstage pass items close to the sell data, at max quality' => [
                'item' => GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 50, 10),
                'expectedQuality' => 50,
                'expectedSellIn' => 9,
            ],
            'updates Backstage pass items very close to the sell date' => [
                'item' => GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 5),
                'expectedQuality' => 13,
                'expectedSellIn' => 4,
            ],
            'updates Backstage pass items very close to the sell date, at max quality' => [
                'item' => GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 50, 5),
                'expectedQuality' => 50,
                'expectedSellIn' => 4,
            ],
            'updates Backstage pass items with one day left to sell' => [
                'item' => GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 1),
                'expectedQuality' => 13,
                'expectedSellIn' => 0,
            ],
            'updates Backstage pass items with one day left to sell, at max quality' => [
                'item' => GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 50, 1),
                'expectedQuality' => 50,
                'expectedSellIn' => 0,
            ],
            'updates Backstage pass items on the sell date' => [
                'item' => GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 0),
                'expectedQuality' => 0,
                'expectedSellIn' => -1,
            ],
            'updates Backstage pass items after the sell date' => [
                'item' => GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, -1),
                'expectedQuality' => 0,
                'expectedSellIn' => -2,
            ],
        ];
    }

    public function conjuredItems(): array
    {
        return [
            'updates Conjured items with one day left at min quality' => [
                'item' => GildedRose::of('Conjured', 1, 1),
                'expectedQuality' => 0,
                'expectedSellIn' => 0,
            ],
            'updates Conjured items with zero day left at min quality' => [
                'item' => GildedRose::of('Conjured', 1, 0),
                'expectedQuality' => 0,
                'expectedSellIn' => -1,
            ],
            'updates Conjured items before sell date' => [
                'item' => GildedRose::of('Conjured', 10, 5),
                'expectedQuality' => 8,
                'expectedSellIn' => 4,
            ],
            'updates Conjured items on the sell date' => [
                'item' => GildedRose::of('Conjured', 10, 0),
                'expectedQuality' => 6,
                'expectedSellIn' => -1,
            ],
            'updates Conjured items after the sell date' => [
                'item' => GildedRose::of('Conjured', 10, -5),
                'expectedQuality' => 6,
                'expectedSellIn' => -6,
            ],
            'updates Conjured items with a quality of 0' => [
                'item' => GildedRose::of('Conjured', 0, 5),
                'expectedQuality' => 0,
                'expectedSellIn' => 4,
            ],
        ];
    }
}
