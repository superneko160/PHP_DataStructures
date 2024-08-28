<?php

/**
 * グラフ構造用の探索アルゴリズム
 */
class GraphTraversal {

    /**
     * 深さ優先探索（DFS）
     * @param UndirectedGraph $graph 探索するデータ
     * @param string $startVertex 探索を開始する頂点
     * @return array 探索結果
     */
    public static function depthFirstSearch(UndirectedGraph $graph, string $startVertex): array {
    
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
     * @param UndirectedGraph $graph 探索するデータ
     * @param string $startVertex 探索を開始する頂点
     * @param array &$visited 訪問済み頂点
     * @param array &$result 探索結果
     * @return void
     */
    private static function depthFirstSearchUtil(UndirectedGraph $graph, string $vertex, array &$visited, array &$result): void {
        $visited[$vertex] = true;
        $result[] = $vertex;

        foreach ($graph->getAdjacentVertices($vertex) as $adjacentVertex) {
            if (!isset($visited[$adjacentVertex])) {
                self::depthFirstSearchUtil($graph, $adjacentVertex, $visited, $result);  // 再帰
            }
        }
    }
}
