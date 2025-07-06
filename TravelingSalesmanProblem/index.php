<?php

require_once __DIR__ . '/../Point.php';
require_once __DIR__ . '/tsp.php';

// 貪欲法を利用すると距離が長くなってしまうパターンをわざと利用
$points = [];
$points[] = new Point(0, 0);
$points[] = new Point(2, 0);
$points[] = new Point(0, 1);
$points[] = new Point(0, 2);
$points[] = new Point(0, 3);

$resultRoute = [];

// 座標を並び替えない（貪欲法を利用しない）
// $resultRoute = $points;  // 6.23
// 座標を並び替えた経路を作成（貪欲法を利用する）
$resultRoute = greedyTsp($points);  // 6.60

// 経路を表示する
show($resultRoute);
