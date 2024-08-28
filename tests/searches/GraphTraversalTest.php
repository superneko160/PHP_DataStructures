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
}
