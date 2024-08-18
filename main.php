<?php

require_once __DIR__ . '/CircularLinkedList.php';

$list = new CircularLinkedList();
$list->append(1);
$list->append(2);
$list->append(3);

$list->display(); // 1 2 3
