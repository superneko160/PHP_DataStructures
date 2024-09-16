<?php

/**
 * 有向グラフ（辺に方向があるグラフ）
 * リストのインデックス：頂点
 * リストの要素：（頂点から出る）辺
 */
class DirectedGraph {

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
     * 2つの頂点間に有向辺を追加
     * @param string $fromVertex 始点
     * @param string $toVertex 終点
     * @return void
     */
    public function addEdge(string $fromVertex, string $toVertex): void {
        $this->addVertex($fromVertex);
        $this->addVertex($toVertex);

        if (!in_array($toVertex, $this->vertices[$fromVertex])) {
            $this->vertices[$fromVertex][] = $toVertex;
        }
    }

    /**
     * 2つの頂点間の有向辺を削除
     * @param string $fromVertex 始点
     * @param string $toVertex 終点
     * @return void
     */
    public function removeEdge(string $fromVertex, string $toVertex): void {
        if (isset($this->vertices[$fromVertex])) {
            $this->vertices[$fromVertex] = array_diff($this->vertices[$fromVertex], [$toVertex]);
        }
    }

    /**
     * 頂点とそれに関連するすべての辺を削除
     * @param string $vertex 削除したい頂点
     * @return void
     */
    public function removeVertex(string $vertex): void {
        // 削除する頂点から出る辺を削除
        unset($this->vertices[$vertex]);

        // 他の頂点から、削除する頂点への辺を削除
        foreach ($this->vertices as &$edges) {
            $edges = array_diff($edges, [$vertex]);
        }
    }

    /**
     * 指定した頂点から出る辺の終点となる頂点のリストを取得
     * @param string $vertex 頂点
     * @return array 指定した頂点から出る辺の終点となる頂点のリスト
     */
    public function getAdjacentVertices(string $vertex): array {
        return isset($this->vertices[$vertex]) ? $this->vertices[$vertex] : [];
    }

    /**
     * 2つの頂点間に有向辺が存在するかチェック
     * @param string $fromVertex 始点
     * @param string $toVertex 終点
     * @return bool 2つの頂点間に有向辺が存在する場合true、そうでない場合false
     */
    public function hasEdge(string $fromVertex, string $toVertex): bool {
        return isset($this->vertices[$fromVertex]) && in_array($toVertex, $this->vertices[$fromVertex]);
    }

    /**
     * 頂点が存在するかチェック
     * @param string $vertex
     * @return bool
     */
    public function hasVertex(string $vertex): bool {
        return isset($this->vertices[$vertex]);
    }

    /**
     * グラフ構造が空かチェック
     * @return bool
     */
    public function isEmpty(): bool {
        return empty($this->vertices);
    }

    /**
     * グラフ構造を文字列で表現
     * @return string
     */
    public function __toString(): string {
        $result = [];
        foreach ($this->vertices as $vertex => $adjacentVertices) {
            if (!empty($adjacentVertices)) {
                $result[] = $vertex . ' -> ' . implode(', ', $adjacentVertices);
            }
        }
        return implode(', ', $result);
    }
}
