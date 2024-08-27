<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../UndirectedGraph.php';

class UndirectedGraphTest extends TestCase
{
    private UndirectedGraph $graph;

    protected function setUp(): void
    {
        $this->graph = new UndirectedGraph();
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

        // A <-> B に辺が存在する
        $this->assertTrue($this->graph->hasEdge('A', 'B'));
        $this->assertTrue($this->graph->hasEdge('B', 'A'));

        // Aを指定したときにB、Bを指定したときにAが取得できる
        $this->assertContains('B', $this->graph->getAdjacentVertices('A'));
        $this->assertContains('A', $this->graph->getAdjacentVertices('B'));
    }

    /**
     * 辺を削除できる
     */
    public function testRemoveEdge(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('A', 'C');
        $this->graph->removeEdge('A', 'B');

        // A <-> B に辺が存在しない
        $this->assertFalse($this->graph->hasEdge('A', 'B'));
        $this->assertFalse($this->graph->hasEdge('B', 'A'));
        // A <-> C に辺が存在する（消えていないことの確認）
        $this->assertTrue($this->graph->hasEdge('A', 'C'));

        // Aを指定したときにB、Bを指定したときにAが取得できない（連結先がないことの確認）
        $this->assertNotContains('B', $this->graph->getAdjacentVertices('A'));
        $this->assertNotContains('A', $this->graph->getAdjacentVertices('B'));
    }

    /**
     * 頂点を削除できる
     */
    public function testRemoveVertex(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('A', 'C');
        $this->graph->addEdge('B', 'D');
        $this->graph->removeVertex('A');

        // どこにもつながっていない（辺が存在しない）
        $this->assertEmpty($this->graph->getAdjacentVertices('A'));
        // B、Cを指定したときにAが取得できない
        $this->assertNotContains('A', $this->graph->getAdjacentVertices('B'));
        $this->assertNotContains('A', $this->graph->getAdjacentVertices('C'));
        // B <-> D の辺があることの確認
        $this->assertTrue($this->graph->hasEdge('B', 'D'));
    }

    /**
     * 指定した頂点に隣接する頂点のリストを取得できる
     */
    public function testGetAdjacentVertices(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('A', 'C');
        $this->graph->addEdge('B', 'D');

        $adjacentToA = $this->graph->getAdjacentVertices('A');
        $this->assertCount(2, $adjacentToA);
        $this->assertContains('B', $adjacentToA);
        $this->assertContains('C', $adjacentToA);

        $adjacentToB = $this->graph->getAdjacentVertices('B');
        $this->assertCount(2, $adjacentToB);
        $this->assertContains('A', $adjacentToB);
        $this->assertContains('D', $adjacentToB);
    }

    /**
     * 2つの頂点間に辺が存在するかチェックできる
     */
    public function testHasEdge(): void
    {
        $this->graph->addEdge('A', 'B');
        $this->graph->addEdge('B', 'C');

        $this->assertTrue($this->graph->hasEdge('A', 'B'));
        $this->assertTrue($this->graph->hasEdge('B', 'A'));
        $this->assertTrue($this->graph->hasEdge('B', 'C'));
        $this->assertFalse($this->graph->hasEdge('A', 'C'));
    }

    /**
     * 存在しない頂点を取得を扱おうとした場合
     */
    public function testNonExistentVertex(): void
    {
        $this->assertEmpty($this->graph->getAdjacentVertices('X'));
        $this->assertFalse($this->graph->hasEdge('X', 'Y'));
    }

    public function testToString(): void
    {
        // 空のグラフ
        $this->assertEquals('', $this->graph->__toString());

        // 頂点のみ（辺なし）
        $this->graph->addVertex('A');
        $this->assertEquals('A <-> ', $this->graph->__toString());

        // 1つの辺を持つグラフ
        $this->graph->addEdge('A', 'B');
        $this->assertEquals('A <-> B, B <-> A', $this->graph->__toString());

        // 複数の辺を持つグラフ
        $this->graph->addEdge('A', 'C');
        $this->graph->addEdge('B', 'D');
    
        $expectedString = 'A <-> B, C, B <-> A, D, C <-> A, D <-> B';
        $actualString = $this->graph->__toString();
    
        // 頂点の順序が不定なため、各部分を個別にチェック
        $this->assertStringContainsString('A <-> B, C', $actualString);
        $this->assertStringContainsString('B <-> A, D', $actualString);
        $this->assertStringContainsString('C <-> A', $actualString);
        $this->assertStringContainsString('D <-> B', $actualString);

        // 文字列の長さを確認
        $this->assertEquals(strlen($expectedString), strlen($actualString));
    }
}
