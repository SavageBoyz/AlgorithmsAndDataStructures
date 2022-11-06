<?php

class Node
{
    private int $value;
    private ?Node $parent;
    private ?Node $leftChild;
    private ?Node $rightChild;

    public function __construct($value, $parent = null, $leftChild = null, $rightChild = null)
    {
        $this->value = $value;
        $this->parent = $parent;
        $this->leftChild = $leftChild;
        $this->rightChild = $rightChild;
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

abstract class Result
{
    private bool $isError;
    private string $messageText;

    public function __construct($isError = false, $messageText = '')
    {
        $this->isError = $isError;
        $this->messageText = $messageText;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->isError;
    }

    /**
     * @param bool $isError
     */
    public function setIsError(bool $isError): void
    {
        $this->isError = $isError;
    }

    /**
     * @return string
     */
    public function getMessageText(): string
    {
        return $this->messageText;
    }

    /**
     * @param string $messageText
     */
    public function setMessageText(string $messageText): void
    {
        $this->messageText = $messageText;
    }

}

class GetNodeByValueResult extends Result
{
    private Node $result;

    public function __construct(Node $result, $isError = false, $messageText = '')
    {
        $this->result = $result;
        parent::__construct($isError, $messageText);
    }
    /**
     * @return mixed
     */
    public function getResult(): Node
    {
        return $this->result;
    }

    /**
     * @param Node $result
     */
    public function setResult(Node $result): void
    {
        $this->result = $result;
    }
}

class AVLTree
{
    private ?Node $rootNode = null;

    /**
     * @throws ErrorException
     */
    public function find(int $value): ?Node
    {
        $nodeSearchResult = $this->getNodeByValue($value, $this->rootNode);

        return $nodeSearchResult->isError() ? null : $nodeSearchResult->getResult();
    }

    /**
     * @throws ErrorException
     */
    public function insert(int $value): void
    {
        if ($this->rootNode === null) {
            $this->rootNode = new Node($value, null);
            return;
        }
        $nodeSearchResult = $this->getNodeByValue($value, $this->rootNode);
        if (!$nodeSearchResult->isError()) {
            throw new ErrorException('Node with a given value is exist already.');
        }

        $foundNode = $nodeSearchResult->getResult();
        $newNode = new Node($value, $foundNode);

        if ($foundNode->getValue() > $value) {
            $foundNode->setLeftChild($newNode);
        } else {
            $foundNode->setRightChild($newNode);
        }
    }

    /**
     * @throws ErrorException
     */
    private function getNodeByValue(int $value, Node $currentNode): GetNodeByValueResult
    {
        if ($currentNode->getValue() === $value) {
            return new GetNodeByValueResult($currentNode);
        }

        if ($currentNode->getValue() > $value) {
            if ($currentNode->getLeftChild() === null) {
                return new GetNodeByValueResult($currentNode, true, 'Node is not exist.');
            }
            return $this->getNodeByValue($value, $currentNode->getLeftChild());
        }

        if ($currentNode->getValue() < $value) {
            if ($currentNode->getRightChild() === null) {
                return new GetNodeByValueResult($currentNode, true, 'Node is not exist.');
            }
            return $this->getNodeByValue($value, $currentNode->getRightChild());
        }

        throw new ErrorException('Something went wrong while looking up a node.');
    }
}

$AVLTree = new AVLTree();
$AVLTree->insert(5);
$AVLTree->insert(2);
$AVLTree->insert(8);
$AVLTree->insert(3);
$AVLTree->insert(15);
$foo;
