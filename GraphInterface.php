<?php

/**
 * グラフインターフェース
 */
interface GraphInterface {
    function isEmpty(): bool;
    function hasVertex(string $vertex): bool;
    function getAdjacentVertices(string $vertex): array;
}
