<?php
/**
 * 要素
 */
class Node {

    public $data;  // 要素に格納される実データ
    // public $prev;  // 前要素への参照（双方向リストの場合使用）
    public $next;  // 次要素への参照

    /**
     * コンストラクタ
     * @param mixed $data 実データ
     */
    public function __construct(mixed $data) {
        $this->data = $data;
        // $this->prev = null;
        $this->next = null;
    }
}
