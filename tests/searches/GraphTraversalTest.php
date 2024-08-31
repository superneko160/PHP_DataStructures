<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../UndirectedGraph.php';
require_once __DIR__ . '/../../searches/GraphTraversal.php';

class GraphTraversalTest extends TestCase
{
    private UndirectedGraph $graph;

    protected function setUp(): void
    {
        $this->graph = new UndirectedGraph();
    }

    /**
     * 単純な連結グラフでのDFS
     */
    public function testDepthFirstSearchOnSimpleGraph(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('A', 'C');
        $this->graph->addEdge('B', 'D');
        $this->graph->addEdge('C', 'D');

        $result = GraphTraversal::depthFirstSearch($this->graph, 'A');

        // 順序は実装によって異なる可能性があるため、厳密な順序のチェックは避ける
        $this->assertEquals('A', $result[0]);  // DFSの結果が開始頂点から始まる
        $this->assertCount(4, $result);  // A,B,C,Dの4つ
        $this->assertContains('B', $result);
        $this->assertContains('C', $result);
        $this->assertContains('D', $result);
    }

    /**
     * 非連結グラフでのDFS
     */
    public function testDepthFirstSearchOnDisconnectedGraph(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('C', 'D');
        $this->graph->addVertex('E');

        $result = GraphTraversal::depthFirstSearch($this->graph, 'A');

        // DFSは開始頂点からたどることができる頂点のみを含む
        $this->assertCount(2, $result);  // A,Bの2つ
        $this->assertContains('A', $result);
        $this->assertContains('B', $result);
        $this->assertNotContains('C', $result);
        $this->assertNotContains('D', $result);
        $this->assertNotContains('E', $result);
    }

    /**
     * サイクルを含むグラフでのDFS
     */
    public function testDepthFirstSearchOnCyclicGraph(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('B', 'C');
        $this->graph->addEdge('C', 'D');
        $this->graph->addEdge('D', 'A');

        $result = GraphTraversal::depthFirstSearch($this->graph, 'A');

        // すべての頂点が含まれ、重複がないことを確認
        $this->assertCount(4, $result);
        $this->assertEquals('A', $result[0]);
        $this->assertContains('B', $result);
        $this->assertContains('C', $result);
        $this->assertContains('D', $result);
    }

    /**
     * 単一頂点のグラフでのDFS
     */
    public function testDepthFirstSearchOnSingleVertexGraph(): void
    {
        $this->graph->addVertex('A');

        $result = GraphTraversal::depthFirstSearch($this->graph, 'A');

        $this->assertCount(1, $result);  // Aの1つのみ
        $this->assertEquals('A', $result[0]);
    }

    /**
     * 空のグラフでのDFS
     */
    public function testDepthFirstSearchOnEmptyGraph(): void
    {
        $result = GraphTraversal::depthFirstSearch($this->graph, 'A');

        $this->assertEmpty($result);
    }

    /**
     * 存在しない開始頂点でのDFS
     */
    public function testDepthFirstSearchWithNonExistentStartVertex(): void
    {
        $this->graph->addEdge('A', 'B');

        $result = GraphTraversal::depthFirstSearch($this->graph, 'C');

        $this->assertEmpty($result);
        $this->assertNotContains('A', $result);
        $this->assertNotContains('B', $result);
    }

    /**
     * 単純な連結グラフでのBFS
     */
    public function testBreadthFirstSearchOnSimpleGraph(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('A', 'C');
        $this->graph->addEdge('B', 'D');
        $this->graph->addEdge('C', 'D');

        $result = GraphTraversal::breadthFirstSearch($this->graph, 'A');

        $this->assertEquals('A', $result[0]);
        $this->assertContains('B', array_slice($result, 1, 2));
        $this->assertContains('C', array_slice($result, 1, 2));
        $this->assertEquals('D', $result[3]);
        $this->assertCount(4, $result);
    }

    /**
     * 非連結グラフでのBFS
     */
    public function testBreadthFirstSearchOnDisconnectedGraph(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('C', 'D');
        $this->graph->addVertex('E');

        $result = GraphTraversal::breadthFirstSearch($this->graph, 'A');

        // BFSは開始頂点からたどることができる頂点のみを含む
        $this->assertCount(2, $result);  // A,Bの2つ
        $this->assertEquals('A', $result[0]);  // 開始頂点は必ず最初
        $this->assertEquals('B', $result[1]);  // BFSでは隣接頂点が2番目に来る
        $this->assertNotContains('C', $result);
        $this->assertNotContains('D', $result);
        $this->assertNotContains('E', $result);

        // 別の連結成分からスタートした場合のテスト
        $resultFromC = GraphTraversal::breadthFirstSearch($this->graph, 'C');

        $this->assertCount(2, $resultFromC);  // C,Dの2つ
        $this->assertEquals('C', $resultFromC[0]);  // 開始頂点は必ず最初
        $this->assertEquals('D', $resultFromC[1]);  // BFSでは隣接頂点が2番目に来る
        $this->assertNotContains('A', $resultFromC);
        $this->assertNotContains('B', $resultFromC);
        $this->assertNotContains('E', $resultFromC);

        // 孤立頂点からスタートした場合のテスト
        $resultFromE = GraphTraversal::breadthFirstSearch($this->graph, 'E');

        $this->assertCount(1, $resultFromE);  // Eのみ
        $this->assertEquals('E', $resultFromE[0]);
        $this->assertNotContains('A', $resultFromE);
        $this->assertNotContains('B', $resultFromE);
        $this->assertNotContains('C', $resultFromE);
        $this->assertNotContains('D', $resultFromE);
    }

    /**
     * 空のグラフでBFS
     */
    public function testBreadthFirstSearchOnEmptyGraph(): void
    {
        $result = GraphTraversal::breadthFirstSearch($this->graph, 'A');

        $this->assertEmpty($result);
    }

    /**
     * 存在しない開始頂点でのBFS
     */
    public function testBreadthFirstSearchWithNonExistentStartVertex(): void
    {
        $this->graph->addEdge('A', 'B');

        $result = GraphTraversal::breadthFirstSearch($this->graph, 'C');

        $this->assertEmpty($result);
    }
}
