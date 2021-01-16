<?php

namespace Tests\Unit\Colletion;

use PHPUnit\Framework\TestCase;
use App\Core\Collection\Colletion;
use stdClass;

class ColletionTest extends TestCase
{
    public function testColletionIsEmpty()
    {
        $colletion = new Colletion([]);
        $this->assertTrue($colletion->isEmpty());
    }

    public function testClearColletion()
    {
        $colletion = new Colletion(['item1', 'item2']);
        $this->assertFalse($colletion->isEmpty());
        $colletion->clear();
        $this->assertTrue($colletion->isEmpty());
    }

    public function testGetColletionItemsAsArray()
    {
        $colletion = new Colletion([
            'item1', 'item2'
        ]);

        $this->assertFalse(is_array($colletion));
        $this->assertTrue(is_array($colletion->toArray()));
    }

    public function testFilterItemsInColletion()
    {

        $colletion = new Colletion([
            'item1', 'item2'
        ]);

        $ob1 = new stdClass;
        $ob1->name = 'Name 1';
        $ob2 = new stdClass;
        $ob2->name = 'Name 2';

        $colletion->add($ob1);
        $colletion->add($ob2);

        $onlyStringValues = $colletion->filter(fn ($value) => is_string($value));
        $getByname = $colletion->filter(fn ($value) => is_object($value) && $value->name == 'Name 1');
        $getItem2 = $onlyStringValues->filter(fn ($item) => $item == 'item2')->toArray();

        $this->assertCount(4, $colletion);
        $this->assertCount(2, $onlyStringValues);
        $this->assertEquals("item1", $onlyStringValues->toArray()[0]);
        $this->assertEquals("item2", $onlyStringValues->toArray()[1]);
        $this->assertCount(1, $getByname);
        $this->assertCount(1, $getItem2);
        $this->assertEquals('item2', $getItem2[array_key_first($getItem2)]);
    }

    public function testMapItemsInColletion()
    {
        $colletion = new Colletion([1, 2, 3, 4, 5]);
        $products = new Colletion([
            ['price' => 10],
            ['price' => 5],
            ['price' => 2],
            ['price' => 20],
        ]);

        $multiplesOfTwo = $colletion->map(fn ($number) => $number * 2);
        $productsWithDiscount = $products
            ->map(function ($product) {
                if ($product['price'] % 2 === 0) {
                    $product['price'] += $product['price'] * 0.10;
                }
                return $product;
            });
        $this->assertEquals([2, 4, 6, 8, 10], $multiplesOfTwo->toArray());
        $this->assertEquals([
            ['price' => 11],
            ['price' => 5],
            ['price' => 2.2],
            ['price' => 22]
        ], $productsWithDiscount->toArray());
    }

    public function testAddItemInColletion()
    {
        $colletion = new Colletion([]);
        $colletion->add('manga');
        $this->assertFalse($colletion->isEmpty());
        $this->assertEquals(1, $colletion->count());
        $this->assertEquals('manga', $colletion->toArray()[0]);
    }

    public function testCheckIfColletionContainsAnItem()
    {
        $person = new stdClass;
        $person->name = 'Name 5';
        $person->email = 'exemple1@email.com';
        
        $person2 = new stdClass;
        $person2->name = 'Name 5';
        $person2->email = 'exemple@email.com';
        
        $persons = new Colletion([
            $person,  $person2
        ]);

        $this->assertTrue($persons->contains($person));
        $this->assertTrue($persons->contains(fn($person) => $person->email == 'exemple@email.com'));
    }
}
