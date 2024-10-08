<?php

/**
 * グラフ構造用の探索アルゴリズム
 */
class GraphTraversal {

    /**
     * 深さ優先探索（DFS）
     * @param GraphInterface $graph 探索するデータ
     * @param string $startVertex 探索を開始する頂点
     * @return array 探索結果
     */
    public static function depthFirstSearch(GraphInterface $graph, string $startVertex): array {
    
        // グラフが空の場合や開始頂点が存在しない場合
        if ($graph->isEmpty() || !$graph->hasVertex($startVertex)) {
            return [];
        }

        $visited = [];
        $result = [];

        self::depthFirstSearchUtil($graph, $startVertex, $visited, $result);

        return $result;
    }

    /**
     * 
     * @param GraphInterface $graph 探索するデータ
     * @param string $startVertex 探索を開始する頂点
     * @param array &$visited 訪問済み頂点
     * @param array &$result 探索結果
     * @return void
     */
    private static function depthFirstSearchUtil(GraphInterface $graph, string $vertex, array &$visited, array &$result): void {
        $visited[$vertex] = true;
        $result[] = $vertex;

        foreach ($graph->getAdjacentVertices($vertex) as $adjacentVertex) {
            if (!isset($visited[$adjacentVertex])) {
                self::depthFirstSearchUtil($graph, $adjacentVertex, $visited, $result);  // 再帰
            }
        }
    }

    /**
     * 幅優先探索（BFS）
     * @param GraphInterface $graph 探索するデータ
     * @param string $startVertex 探索を開始する頂点
     * @return array 探索結果
     */
    public static function breadthFirstSearch(GraphInterface $graph, string $startVertex): array
    {
        // グラフが空の場合や開始頂点が存在しない場合
        if ($graph->isEmpty() || !$graph->hasVertex($startVertex)) {
            return [];
        }

        $visited = [$startVertex => true];  // 始点を訪問済みとしてマーク
        $result = [];

        // BFSなのでキューを利用
        $queue = new SplQueue();
        $queue->enqueue($startVertex);  // 始点を追加

        // キューが空になるまで実行
        while (!$queue->isEmpty()) {

            // キューから頂点を取り出し、結果配列に追加
            $vertex = $queue->dequeue();  // 頂点を取得
            $result[] = $vertex;

            // 取り出した頂点の隣接頂点をすべて探索
            foreach ($graph->getAdjacentVertices($vertex) as $adjacentVertex) {
                if (!isset($visited[$adjacentVertex])) {
                    $visited[$adjacentVertex] = true;  // 訪問済みとしてマーク
                    $queue->enqueue($adjacentVertex);  // 未訪問の頂点をキューに追加
                }
            }
        }

        return $result;
    }
}
