<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../DoublyLinkedList.php';

class DoublyLinkedListTest extends TestCase
{
    private $list;

    protected function setUp(): void
    {
        $this->list = new DoublyLinkedList();
    }

    /**
     * 空のリストに要素を追加できる
     */
    public function testAppendToEmptyList(): void
    {
        $this->list->append(1);
        $this->expectOutputString("1");
        echo $this->list;
    }

    /**
     * 複数の要素を正しく追加できる
     */
    public function testAppendMultipleItems(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);
        $this->expectOutputString("1, 2, 3");
        echo $this->list;
    }

    /**
     * 空のリストを削除した場合、falseが返される
     */
    public function testDeleteFromEmptyList(): void
    {
        $data = 'dummy';
        $this->assertFalse($this->list->delete($data));
    }

    /**
     * 存在しない要素を削除しようとした場合、falseが返される
     */
    public function testDeleteNotData(): void
    {
        $data = 'dummy1';
        $this->list->append('dummy2');
        $this->assertFalse($this->list->delete($data));
    }

    /**
     * 1つだけ要素が格納されたリストから指定要素を削除できる
     */
    public function testDeleteFromSingleElementList(): void
    {
        $this->list->append(1);
        $this->assertEquals(1, $this->list->delete(1));
        $this->expectOutputString("List is empty");
        echo $this->list;
    }

    /**
     * 複数の要素が格納されたリストから指定要素を削除できる
     */
    public function testDeleteMultipleItems(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);
        $this->assertEquals(2, $this->list->delete(2));
        $this->expectOutputString("1, 3");
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
     * 存在するデータを探索した場合、要素を返す
     */
    public function testSearch(): void
    {
        $data = 'dummy';
        $node = new Node($data);
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
     * echoやprintで表示したときカンマ区切りで表示される
     */
    public function testToString(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);
        $this->expectOutputString("1, 2, 3");
        echo $this->list;
    }

    /**
     * 空のリストをechoやprintで表示したとき
     */
    public function testToStringEmptyList(): void
    {
        $this->expectOutputString("List is empty");
        echo $this->list;
    }
}
