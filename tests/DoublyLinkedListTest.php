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
     * 空のリストを削除した場合、nullが返される
     */
    public function testDeleteFromEmptyList(): void
    {
        $data = 'dummy';
        $this->assertNull($this->list->delete($data));
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
