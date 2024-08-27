<?php

/**
 * 無向グラフ（辺に方向がないグラフ）
 * リストのインデックス：頂点
 * リストの要素：（頂点に接続される）辺
 */
class UndirectedGraph {

    // 頂点
    private array $vertices;

    public function __construct() {
        $this->vertices = [];
    }

    /**
     * 頂点の追加
     * @param string $vertex 追加する頂点
     * @return void
     */
    public function addVertex(string $vertex): void {
        if (!isset($this->vertices[$vertex])) {
            $this->vertices[$vertex] = [];
        }
    }

    /**
     * 2つの頂点間に辺を追加
     * @param string $vertex1 頂点1
     * @param string $vertex2 頂点2
     * @return void
     */
    public function addEdge(string $vertex1, string $vertex2): void {
        $this->addVertex($vertex1);
        $this->addVertex($vertex2);

        $this->vertices[$vertex1][] = $vertex2;
        $this->vertices[$vertex2][] = $vertex1;
    }

    /**
     * 2つの頂点間の辺を削除
     * @param string $vertex1 頂点1
     * @param string $vertex2 頂点2
     * @return void
     */
    public function removeEdge(string $vertex1, string $vertex2): void {
        $this->vertices[$vertex1] = array_diff($this->vertices[$vertex1], [$vertex2]);
        $this->vertices[$vertex2] = array_diff($this->vertices[$vertex2], [$vertex1]);
    }

    /**
     * 頂点とそれに接続するすべての辺を削除
     * @param string $vertex 削除したい頂点
     * @return void
     */
    public function removeVertex(string $vertex): void {
        foreach ($this->vertices[$vertex] as $adjacentVertex) {
            $this->removeEdge($vertex, $adjacentVertex);
        }
        unset($this->vertices[$vertex]);
    }

    /**
     * 指定した頂点に隣接する頂点のリストを取得
     * @param string $vertex 頂点
     * @return array 指定した頂点に隣接する頂点のリスト
     */
    public function getAdjacentVertices(string $vertex): array {
        return isset($this->vertices[$vertex]) ? $this->vertices[$vertex] : [];
    }

    /**
     * 2つの頂点間に辺が存在するかチェック
     * @param string $vertex1 頂点1
     * @param string $vertex2 頂点2
     * @return bool 2つの頂点間に辺が存在する場合true、そうでない場合false
     */
    public function hasEdge(string $vertex1, string $vertex2): bool {
        return isset($this->vertices[$vertex1]) && in_array($vertex2, $this->vertices[$vertex1]);
    }

    /**
     * グラフ構造を文字列で表現
     * @return string
     */
    public function __toString(): string {
        $result = [];
        foreach ($this->vertices as $vertex => $adjacentVertices) {
            $result[] = $vertex . ' <-> ' . implode(', ', $adjacentVertices);
        }
        return implode(', ', $result);
    }
}
