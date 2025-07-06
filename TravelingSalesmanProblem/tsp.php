<?php
require_once __DIR__ . '/../Point.php';

/**
 * 座標を並び替えた経路（巡回セールスマン問題の貪欲法：最近傍点法）
 * @param array $points Pointオブジェクトの配列
 * @return array 最短経路（Pointオブジェクトの配列）
 */
function greedyTsp(array $points): array {
    if (count($points) <= 1) {
        return $points;
    }

    $resultRoute = [];
    // 未訪問の点を管理するために、元のPointオブジェクトをコピーして使用
    // キーをリセットして数値インデックスに
    $openPoints = array_values($points);

    // 始点の追加
    $startPoint = array_shift($openPoints);
    $resultRoute[] = $startPoint;

    while (!empty($openPoints)) {
        $currentPoint = $resultRoute[count($resultRoute) - 1];  // 今いる点
        $candidatePoint = null;  // 移動候補の点
        $minDistance = INF;  // 最小距離を無限大で初期化
        $candidateIndex = -1;  // 候補点のインデックスを保持

        // すべての未訪問の点について、現在座標との距離を調べ、最も距離の短い点を移動候補とする
        foreach ($openPoints as $index => $openPoint) {
            $distance = $currentPoint->distance($openPoint);

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $candidatePoint = $openPoint;
                $candidateIndex = $index;  // 候補点のインデックスを保存
            }
        }

        // 最短距離の候補が見つかった場合
        if ($candidatePoint !== null) {
            $resultRoute[] = $candidatePoint;
            unset($openPoints[$candidateIndex]);
            $openPoints = array_values($openPoints);  // インデックスの振り直し
        } else {
            break;  // 念のため無限ループを防ぐための処理
        }
    }
    // 最後に始点に戻る経路を追加（巡回セールスマン問題の定義による）
    // $resultRoute[] = $startPoint;

    return $resultRoute;
}

/**
 * 2点間の距離を求める
 * @param Point p 座標
 * @param Point q 座標
 * @return float 距離
 */
function distancePoint(Point $p, Point $q): float {
    return $p->distance($q);
}

/**
 * 経路の総距離
 * @param array $route
 * @return float 総距離
 */
function distanceRoute(array $route): float {
    $sum = 0;
    for ($i = 0; $i < count($route) - 1; $i++) {
        $sum += distancePoint($route[$i], $route[$i + 1]);
    }
    return $sum;
}

/**
 * 経路の表示
 * @param array $route 
 */
function show(array $route): void {
    foreach ($route as $point) {
        echo $point . PHP_EOL;
    }
    echo distanceRoute($route) . PHP_EOL;
}
