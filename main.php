<?php

require_once __DIR__ . '/DirectedGraph.php';
require_once __DIR__ . '/searches/GraphTraversal.php';

$graph = new DirectedGraph();
$graph->addEdge('A', 'B');
$graph->addEdge('A', 'C');
$graph->addEdge('B', 'D');
// echo $graph->__toString();

// 有向グラフDFS（Aは探索開始地点）
print_r(GraphTraversal::depthFirstSearch($graph, 'A'));

// 有向グラフBFS（Aは探索開始地点）
print_r(GraphTraversal::breadthFirstSearch($graph, 'A'));
