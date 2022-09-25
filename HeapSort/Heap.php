<?php

class Heap
{
    private array $_heap = [];

    public function __construct(array $heap)
    {
        $this->_heap = $heap;

        for ($i = (int)(count($heap) / 2); $i >= 0; $i--) {
            $this->siftDown($i);
        }
    }

    public function getHeap(): array
    {
        return $this->_heap;
    }

    public function insert($el)
    {
        $this->_heap[] = $el;
        $this->siftUp(count($this->_heap) - 1);
    }

    public function extractMax()
    {
        $result = $this->_heap[0];
        $this->_heap[0] = array_pop($this->_heap);
        $this->siftDown(0);
        return $result;
    }

    public function remove($i)
    {
        $this->_heap[$i] = INF;
        $this->siftUp($i);
        $this->extractMax();
    }

    public function changePriority($priority, $i)
    {
        $oldPriority = $this->_heap[$i];
        $this->_heap[$i] = $priority;

        if ($priority > $oldPriority) {
            $this->siftUp($i);
        } else {
            $this->siftDown($i);
        }
    }

    public function siftDown($i, $range = null)
    {
        if ($range === null) {
            $range = count($this->_heap) - 1;
        }

        $elemMaxIndex = $i;
        $leftChildIndex = $this->leftChild($i);
        $rightChildIndex = $this->rightChild($i);

        if (array_key_exists($leftChildIndex, $this->_heap) &&
            $leftChildIndex <= $range &&
            $this->_heap[$leftChildIndex] > $this->_heap[$elemMaxIndex]) {
            $elemMaxIndex = $leftChildIndex;
        }

        if (array_key_exists($rightChildIndex, $this->_heap) &&
            $rightChildIndex <= $range &&
            $this->_heap[$rightChildIndex] > $this->_heap[$elemMaxIndex]) {
            $elemMaxIndex = $rightChildIndex;
        }

        if ($i !== $elemMaxIndex) {
            $this->swap($i, $elemMaxIndex);
            $this->siftDown($elemMaxIndex, $range);
        }
    }

    public function siftUp($i)
    {
        while ($i > 0 && $this->_heap[$this->parent($i)] < $this->_heap[$i]) {
            $this->swap($this->parent($i), $i);
            $i = $this->parent($i);
        }
    }

    private function parent($i)
    {
        return (int)(($i - 1) / 2);
    }

    private function leftChild($i)
    {
        return 2 * $i + 1;
    }

    private function rightChild($i)
    {
        return 2 * $i + 2;
    }

    public function swap($i1, $i2)
    {
        [$this->_heap[$i1], $this->_heap[$i2]] = [$this->_heap[$i2], $this->_heap[$i1]];
    }
}

class sort
{
    /* SORT ON-PLACE */
    public function sortHeap(array $array)
    {
        $heap = new Heap($array);
        $heapSize = count($array) - 1;

        for ($i = 0; $i < count($array); $i++) {
            $heap->swap(0, $heapSize);
            $heapSize--;
            $heap->siftDown(0, $heapSize);
        }

        return $heap->getHeap();
    }
}

$arr = [4, 10, 3, 5, 1];
$sort = new Sort();
var_dump($sort->sortHeap($arr));
