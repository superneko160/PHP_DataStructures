<?php

/**
 * 座標
 * Javaのawt.Pointクラス参考
 */
class Point {

    public float $x;
    public float $y;

    /**
     * @param float $x X座標
     * @param float $y Y座標
     */
    public function __construct(float $x = 0, float $y = 0) {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * X座標の取得
     * @param float X座標
     */
    public function getX(): float {
        return $this->x;
    }

    /*
     * Y座標の取得
     * @param float Y座標
     */
    public function getY(): float {
        return $this->y;
    }

    /**
     * 座標の設定
     * @param float $x X座標
     * @param float $y Y座標
     */
    public function setLocation(float $x, float $y): void {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * 座標の移動
     * @param float $dx X座標の移動距離
     * @param float $dy Y座標の移動距離
     */
    public function translate(float $dx, float $dy): void {
        $this->x += $dx;
        $this->y += $dy;
    }

    /**
     * 2点間の距離を取得
     * @param Point $otherPoint
     * @return float 距離
     */
    public function distance(Point $otherPoint): float {
        $dx = $otherPoint->getX() - $this->x;
        $dy = $otherPoint->getY() - $this->y;
        return sqrt($dx * $dx + $dy * $dy);
    }

    /**
     * 座標の表示
     * @return string 座標
     */
    public function __toString(): string {
        return "Point(x={$this->x}, y={$this->y})";
    }
}
