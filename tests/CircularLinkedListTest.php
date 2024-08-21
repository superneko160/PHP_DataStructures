<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Node.php';
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
     * リストの長さを返す
     */
    public function testLength(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);
        $this->assertEquals(3, $this->list->length());
    }

    /**
     * 空のリストの長さを返す
     */
    public function testLengthEmptyList(): void
    {
        $this->assertEquals(0, $this->list->length());
    }

    /**
     * リストを配列に変換
     */
    public function testToArray(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);
        $this->assertEquals([1, 2, 3], $this->list->toArray());
    }

    /**
     * 空のリストを空の配列に変換
     */
    public function testToArrayEmptyList(): void
    {
        $this->assertEquals([], $this->list->toArray());
    }

    /**
     * 存在するデータを探索した場合、要素を返す
     */
    public function testSearch(): void
    {
        $data = 'dummy';
        $node = new Node($data);
        $node->next = $node;
        $this->list->append($data);
        $this->assertEquals($node, $this->list->search($data));
    }

    /**
     * 存在しないデータを探索した場合、falseを返す
     */
    public function testSearchNotData(): void
    {
        $data = 'dummy1';
        $this->list->append('dummy2');
        $this->assertEquals(false, $this->list->search($data));
    }

    /**
     * 空のリストを探索した場合、falseを返す
     */
    public function testSearchToEmptyList(): void
    {
        $data = 'dummy';
        $this->assertEquals(false, $this->list->search($data));
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
