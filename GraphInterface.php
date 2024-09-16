<?php

/**
 * グラフインターフェース
 */
interface GraphInterface {
    public function isEmpty(): bool;
    public function hasVertex(string $vertex): bool;
    public function getAdjacentVertices(string $vertex): array;
}
