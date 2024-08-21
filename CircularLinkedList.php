<?php

require_once __DIR__ . '/Node.php';

/**
 * 循環リスト
 */
class CircularLinkedList {

    // リストへのアクセスポイント
    // 循環リストなので先頭要素への参照を終端の要素に格納
    private $head;

    /**
     * コンストラクタ
     */
    public function __construct() {
        $this->head = null;
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
            // アクセスポイントに新要素を設定
            $this->head = $newNode;
            // 新要素の次要素に自分自身を設定
            $newNode->next = $this->head;
        } 
        // リストにすでに要素が格納されている場合
        else {
            // 現在のアクセスポイントを取得
            $current = $this->head;
            // 新要素を追加する前（1つ前）の要素を探す
            while ($current->next !== $this->head) {
                $current = $current->next;
            }
            // 新要素を追加する前（1つ前）の次要素に新要素に設定
            $current->next = $newNode;
            // 新要素の次要素にアクセスポイントを設定
            $newNode->next = $this->head;
        }
    }

    /**
     * リストの終端の要素を削除
     * @return mixed 削除した要素（リストが空だった場合はnullを返す）
     */
    public function delete(): mixed {
        // リストが空の場合
        if ($this->head === null) {
            return null;
        }

        // リストに1つの要素しかない場合
        if ($this->head->next === $this->head) {
            // データ一時退避
            $data = $this->head->data;
            // （最初の要素がなくなるので）アクセスポイントにnullを設定
            $this->head = null;
            // （退避させた）消去したデータを返す
            return $data;
        }

        $current = $this->head;
        $prev = null;

        // 最後から2番目の要素を見つける
        while ($current->next !== $this->head) {
            $prev = $current;
            $current = $current->next;
        }

        $prev->next = $this->head;  // 循環構造を維持
        // 消去したデータを返す
        return $current->data;
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
        do {
            $length++;
            $current = $current->next;
        } while ($current !== $this->head);  // 循環リストなので最初の要素に戻ってきたとき終了

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
        do {
            // 指定データと一致した場合、その要素を返す
            if ($current->data === $data) {
                return $current;
            }
            $current = $current->next;
        } while ($current !== $this->head);  // 循環リストなので最初の要素に戻ってきたとき終了

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
        do {
            $result[] = $current->data;
            $current = $current->next;
        } while ($current !== $this->head);  // 循環リストなので最初の要素に戻ってきたとき終了

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

        $result = [];
        $current = $this->head;

        do {
            $result[] = $current->data;
            $current = $current->next;
        } while ($current !== $this->head);  // 循環リストなので最初の要素に戻ってきたとき終了

        return implode(', ', $result);
    }
}
