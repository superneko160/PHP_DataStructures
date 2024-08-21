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
     * 表示（デバッグ用）
     * @return void
     */
    public function display(): void {
        // リストが空
        if ($this->head === null) {
            echo "List is empty";
            return;
        }

        $current = $this->head;
        do {
            echo $current->data . " ";
            $current = $current->next;
        } while ($current !== $this->head);  // 循環リストなので最初の要素に戻ってきたとき終了
    }
}
