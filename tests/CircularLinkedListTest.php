<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../CircularLinkedList.php';

class CircularLinkedListTest extends TestCase
{
    private $list;

    protected function setUp(): void
    {
        $this->list = new CircularLinkedList();
    }

    /**
     * 空のリストに要素を追加できる
     */
    public function testAppendToEmptyList(): void
    {
        $this->list->append(1);
        $this->expectOutputString('1');
        echo $this->list;
    }

    /**
     * 複数の要素を追加できる
     */
    public function testAppendMultipleItems(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);
        $this->expectOutputString('1, 2, 3');
        echo $this->list;
    }

    /**
     * 空のリストを削除した場合、nullが返される
     */
    public function testDeleteFromEmptyList(): void
    {
        $this->assertNull($this->list->delete());
    }

    /**
     * 1つだけの要素を削除できる
     */
    public function testDeleteFromSingleElementList(): void
    {
        $this->list->append(1);
        $this->assertEquals(1, $this->list->delete());
        $this->expectOutputString('List is empty');
        echo $this->list;
    }

    /**
     * 複数の要素を削除できる
     */
    public function testDeleteFromMultipleElementList(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);

        $this->assertEquals(3, $this->list->delete());
        $this->assertEquals(2, $this->list->delete());
        $this->expectOutputString('1');
        echo $this->list;
    }

    /**
     * echoやprintで表示したときカンマ区切りで表示される
     */
    public function testToString(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);
        $this->expectOutputString('1, 2, 3');
        echo $this->list;
    }

    /**
     * 空のリストをechoやprintで表示したとき List is empty と表示される
     */
    public function testToStringEmptyList(): void {
        $this->expectOutputString('List is empty');
        echo $this->list;
    }
}
