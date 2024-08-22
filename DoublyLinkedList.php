<?php

require_once __DIR__ . '/Node.php';

/**
 *  双方向連結リスト
 */
class DoublyLinkedList {

    public ?Node $head = null;  // 先頭の要素
    public ?Node $tail = null;  // 末尾の要素

    public function __construct() {
        $this->head = null;
        $this->tail = null;
    }

    /**
     * リストの終端に要素を追加
     * @param mixed $data 追加要素（実データ）
     * @return void
     */
    public function append(mixed $data): void {
        // 新要素
        $newNode = new Node($data);

        // リストが空の場合
        if ($this->head === null) {
            $this->head = $newNode;
            $this->tail = $newNode;
            return;
        }

        // 現在の末尾の次要素に、新要素を設定
        $this->tail->next = $newNode;
        // 新要素の前の要素に、現在の末尾の要素を設定
        $newNode->prev = $this->tail;
        // リストの末尾を新要素に設定
        $this->tail = $newNode;
    }

    /**
     * リストで一致した要素を削除
     * @return mixed 削除した要素（リストが空だった場合はnullを返す）
     */
    public function delete(mixed $data): mixed {
        // リストが空の場合
        if ($this->head === null) {
            return null;
        }

        // 先頭の要素と一致した場合、要素を1個前にずらす
        if ($this->head->data === $data) {
            $deleteData = $this->head->data;
            // 先頭のアクセスポイントに次要素を設定
            $this->head = $this->head->next;
            // 先頭のアクセスポイントの前要素にnullを設定
            // $this->head->prev = null;
            return $deleteData;
        }

        $current = $this->head;

        // 先頭の要素から確認していって一致する要素があれば、削除
        while ($current !== null) {
            if ($current->data === $data) {
                $deleteData = $current->data;
                // 削除する前の次要素に、現在の次要素を設定
                $current->prev->next = $current->next;
                // 削除する次の前要素に、現在の前要素を設定
                $current->next->prev = $current->prev;
                return $deleteData;
            }
            $current = $current->next;
        }

        return null;
    }

    /**
     * リストの長さを取得
     * @return int リストの長さ
     */
    public function length(): int {
        $length = 0;

        // リストが空の場合
        if ($this->head === null) {
            return $length;
        }

        $current = $this->head;

        while ($current !== null) {
            $length++;
            $current = $current->next;
        }

        return $length;
    }

    /**
     * 指定したデータを探索
     * @param mixed $data 探索するデータ
     * @return Node|false データがあったとき要素を返し、なければfalseを返す
     */
    public function search(mixed $data): Node|false {

        // リストが空の場合
        if ($this->head === null) {
            return false;
        }

        $current = $this->head;

        while ($current !== null) {
            // 指定データと一致した場合、その要素を返す
            if ($current->data === $data) {
                return $current;
            }
            $current = $current->next;
        }

        // 検索結果が見つからなかった場合
        return false;
    }

    /**
     * リストを配列に変換
     * @return array 変換した配列
     */
    public function toArray(): array {
        $result = [];

        // リストが空の場合
        if ($this->head === null) {
            return $result;
        }

        $current = $this->head;

        while ($current !== null) {
            $result[] = $current->data;
            $current = $current->next;
        }

        return $result;
    }
    /**
     * 全要素を文字列で返す
     * @return string カンマ区切りで結合した要素
     */
    public function __toString(): string {
        // リストが空の場合
        if ($this->head === null) {
            return 'List is empty';
        }

        $current = $this->head;
        $result = [];

        // 要素の次の要素がなくなる（終端要素）までループ
        while ($current !== null) {
            $result[] = $current->data;
            $current = $current->next;
        }

        return implode(', ', $result);
    }
}
