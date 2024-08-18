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
        $this->assertEquals("1 ", $this->getListContent());
    }

    /**
     * 複数の要素を正しく追加できる
     */
    public function testAppendMultipleItems(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);
        $this->assertEquals("1 2 3 ", $this->getListContent());
    }

    /**
     * 循環構造が正しく維持される（リストを一周後も同じ内容が表示される）
     */
    public function testCircularStructure(): void
    {
        $this->list->append(1);
        $this->list->append(2);
        $this->list->append(3);
        $this->assertEquals("1 2 3 1 2 3 ", $this->getListContent(2));
    }

    /**
     * カウンタの回数分デバッグ用の表示メソッドを実行
     * @param int $counter カウンタ（初期値：1）
     * @return string|false 出力バッファの内容|失敗
     */
    private function getListContent(int $counter = 1): string|false
    {
        ob_start();
        for ($i = 0; $i < $counter; $i++) {
            $this->list->display();
        }
        return ob_get_clean();
    }
}
