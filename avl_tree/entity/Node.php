<?php

namespace avl_tree\Entity;

class Node
{
    private int $value;
    private int $leftSubtreeHeight;
    private int $rightSubtreeHeight;
    private ?Node $parent;
    private ?Node $leftChild;
    private ?Node $rightChild;

    public function __construct($value, $parent = null, $leftChild = null, $rightChild = null, $leftSubtreeHeight = 0, $rightSubtreeHeight = 0)
    {
        $this->value = $value;
        $this->parent = $parent;
        $this->leftChild = $leftChild;
        $this->rightChild = $rightChild;
        $this->leftSubtreeHeight = $leftSubtreeHeight;
        $this->rightSubtreeHeight = $rightSubtreeHeight;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getLeftSubtreeHeight(): int
    {
        return $this->leftSubtreeHeight;
    }

    /**
     * @param int $leftSubtreeHeight
     */
    public function setLeftSubtreeHeight(int $leftSubtreeHeight): void
    {
        $this->leftSubtreeHeight = $leftSubtreeHeight;
    }

    /**
     * @return int
     */
    public function getRightSubtreeHeight(): int
    {
        return $this->rightSubtreeHeight;
    }

    /**
     * @param int $rightSubtreeHeight
     */
    public function setRightSubtreeHeight(int $rightSubtreeHeight): void
    {
        $this->rightSubtreeHeight = $rightSubtreeHeight;
    }

    public function getSubtreeHeightsDiff(): int
    {
        return $this->leftSubtreeHeight - $this->rightSubtreeHeight;
    }

    /**
     * @return Node|null
     */
    public function getParent(): ?Node
    {
        return $this->parent;
    }

    /**
     * @param Node|null $parent
     */
    public function setParent(?Node $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return Node|null
     */
    public function getLeftChild(): ?Node
    {
        return $this->leftChild;
    }

    /**
     * @param Node|null $leftChild
     */
    public function setLeftChild(?Node $leftChild): void
    {
        $this->leftChild = $leftChild;
    }

    /**
     * @return Node|null
     */
    public function getRightChild(): ?Node
    {
        return $this->rightChild;
    }

    /**
     * @param Node|null $rightChild
     */
    public function setRightChild(?Node $rightChild): void
    {
        $this->rightChild = $rightChild;
    }
}