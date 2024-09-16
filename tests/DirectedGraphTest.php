<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../DirectedGraph.php';

class DirectedGraphTest extends TestCase
{
    private DirectedGraph $graph;

    protected function setUp(): void
    {
        $this->graph = new DirectedGraph();
    }

    /**
     * 頂点を追加できる
     */
    public function testAddVertex(): void
    {
        $this->graph->addVertex('A');

        // どこにもつながっていない（辺が存在しない）
        $this->assertEmpty($this->graph->getAdjacentVertices('A'));
    }

    /**
     * 辺を追加できる
     */
    public function testAddEdge(): void
    {
        $this->graph->addEdge('A', 'B');

        // A -> B に辺が存在する
        $this->assertTrue($this->graph->hasEdge('A', 'B'));
        // B -> A に辺が存在しない（有向グラフの特性）
        $this->assertFalse($this->graph->hasEdge('B', 'A'));

        // Aを指定したときにBが取得できる
        $this->assertContains('B', $this->graph->getAdjacentVertices('A'));
        // Bを指定したときにAが取得できない（有向グラフの特性）
        $this->assertNotContains('A', $this->graph->getAdjacentVertices('B'));
    }

    /**
     * 辺を削除できる
     */
    public function testRemoveEdge(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('A', 'C');
        $this->graph->removeEdge('A', 'B');

        // A -> B に辺が存在しない
        $this->assertFalse($this->graph->hasEdge('A', 'B'));
        // A -> C に辺が存在する（消えていないことの確認）
        $this->assertTrue($this->graph->hasEdge('A', 'C'));

        // Aを指定したときにBが取得できない
        $this->assertNotContains('B', $this->graph->getAdjacentVertices('A'));
    }

    /**
     * 頂点を削除できる
     */
    public function testRemoveVertex(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('A', 'C');
        $this->graph->addEdge('B', 'D');
        $this->graph->addEdge('C', 'A');  // 循環経路の追加
        $this->graph->removeVertex('A');

        // どこにもつながっていない（辺が存在しない）
        $this->assertEmpty($this->graph->getAdjacentVertices('A'));
        // Bを指定したときにDが取得できる（削除されていない辺の確認）
        $this->assertContains('D', $this->graph->getAdjacentVertices('B'));
        // Cを指定したときに空のリストが返される（Aへの辺が削除されたことの確認）
        $this->assertEmpty($this->graph->getAdjacentVertices('C'));
    }

    /**
     * 指定した頂点から出る辺の終点となる頂点のリストを取得できる
     */
    public function testGetAdjacentVertices(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('A', 'C');
        $this->graph->addEdge('B', 'D');
        $this->graph->addEdge('D', 'A');  // 循環経路の追加

        $adjacentToA = $this->graph->getAdjacentVertices('A');
        $this->assertCount(2, $adjacentToA);
        $this->assertContains('B', $adjacentToA);
        $this->assertContains('C', $adjacentToA);

        $adjacentToB = $this->graph->getAdjacentVertices('B');
        $this->assertCount(1, $adjacentToB);
        $this->assertContains('D', $adjacentToB);
        $this->assertNotContains('A', $adjacentToB);

        $adjacentToD = $this->graph->getAdjacentVertices('D');
        $this->assertCount(1, $adjacentToD);
        $this->assertContains('A', $adjacentToD);
    }

    /**
     * 有向グラフの循環経路をテスト
     */
    public function testCyclicPath(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('B', 'C');
        $this->graph->addEdge('C', 'A');

        $this->assertTrue($this->graph->hasEdge('A', 'B'));
        $this->assertTrue($this->graph->hasEdge('B', 'C'));
        $this->assertTrue($this->graph->hasEdge('C', 'A'));

        $this->assertFalse($this->graph->hasEdge('B', 'A'));
        $this->assertFalse($this->graph->hasEdge('C', 'B'));
        $this->assertFalse($this->graph->hasEdge('A', 'C'));
    }

    /**
     * 文字列表現できる
     */
    public function testToString(): void
    {
        // 空のグラフ
        $this->assertEquals('', $this->graph->__toString());

        // 1つの辺を持つグラフ
        $this->graph->addEdge('A', 'B');
        $this->assertEquals('A -> B', $this->graph->__toString());

        // 辺を追加（複数の頂点、辺のテスト）
        $this->graph->addEdge('A', 'C');
        $this->graph->addEdge('B', 'D');

        $expectedString = 'A -> B, C, B -> D';
        $actualString = $this->graph->__toString();
    
        // 頂点の順序が不定なため、各部分を個別にチェック
        $this->assertStringContainsString('A -> B, C', $actualString);
        $this->assertStringContainsString('B -> D', $actualString);

        // 文字列の長さを確認
        $this->assertEquals(strlen($expectedString), strlen($actualString));
    }
}
