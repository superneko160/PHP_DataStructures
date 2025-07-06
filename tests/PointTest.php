<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Point.php';


class PointTest extends TestCase
{
    /**
     * 座標を作成できる
     */
    public function testConstructor()
    {
        // デフォルトコンストラクタのテスト
        $point1 = new Point();
        $this->assertEquals(0, $point1->x);
        $this->assertEquals(0, $point1->y);

        // 引数付きコンストラクタのテスト
        $point2 = new Point(10, 20);
        $this->assertEquals(10, $point2->x);
        $this->assertEquals(20, $point2->y);
    }

    /**
     * 座標を取得できる
     */
    public function testGetters()
    {
        $point = new Point(5, 8);
        $this->assertEquals(5, $point->getX());
        $this->assertEquals(8, $point->getY());
    }

    /**
     * 座標を設定できる
     */
    public function testSetLocation()
    {
        $point = new Point();
        $point->setLocation(15, 25);
        $this->assertEquals(15, $point->x);
        $this->assertEquals(25, $point->y);
    }

    /**
     * 座標を移動できる
     */
    public function testTranslate()
    {
        $point = new Point(10, 20);
        $point->translate(5, -10);  // xを5増やし、yを10減らす
        $this->assertEquals(15, $point->x);
        $this->assertEquals(10, $point->y);

        $point->translate(-15, 0);  // xを15減らす
        $this->assertEquals(0, $point->x);
        $this->assertEquals(10, $point->y);
    }

    /**
     * 2点間の距離を取得できる
     */
    public function testDistance()
    {
        $p1 = new Point(0, 0);
        $p2 = new Point(3, 4);
        $p3 = new Point(0, 5);

        // (0,0) から (3,4) までの距離 (3-4-5の直角三角形)
        $this->assertEquals(5.0, $p1->distance($p2));

        // (3,4) から (0,0) までの距離 (逆でも同じ)
        $this->assertEquals(5.0, $p2->distance($p1));

        // 同じ点同士の距離
        $this->assertEquals(0.0, $p1->distance($p1));

        // (0,0) から (0,5) までの距離 (Y軸上)
        $this->assertEquals(5.0, $p1->distance($p3));
    }

    /**
     * 文字列表現できる
     */
    public function testToString()
    {
        $point = new Point(100, 200);
        $this->assertEquals("Point(x=100, y=200)", (string)$point);

        $pointZero = new Point();
        $this->assertEquals("Point(x=0, y=0)", (string)$pointZero);
    }
}
