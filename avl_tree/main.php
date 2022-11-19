<?php

class Node
{
    private int $value;
    private int $leftSubtreeHeight = 0;
    private int $rightSubtreeHeight = 0;
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

abstract class Response
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

class GetNodeByValueResponse extends Response
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
            $foundNode->setLeftSubtreeHeight($foundNode->getLeftSubtreeHeight() + 1);
        } else {
            $foundNode->setRightChild($newNode);
            $foundNode->setRightSubtreeHeight($foundNode->getRightSubtreeHeight() + 1);
        }
        $this->recursiveUpdateSubtreeHeight($foundNode);
    }

    /**
     * @throws ErrorException
     */
    private function getNodeByValue(int $value, Node $currentNode): GetNodeByValueResponse
    {
        if ($currentNode->getValue() === $value) {
            return new GetNodeByValueResponse($currentNode);
        }

        if ($currentNode->getValue() > $value) {
            if ($currentNode->getLeftChild() === null) {
                return new GetNodeByValueResponse($currentNode, true, 'Node is not exist.');
            }
            return $this->getNodeByValue($value, $currentNode->getLeftChild());
        }

        if ($currentNode->getValue() < $value) {
            if ($currentNode->getRightChild() === null) {
                return new GetNodeByValueResponse($currentNode, true, 'Node is not exist.');
            }
            return $this->getNodeByValue($value, $currentNode->getRightChild());
        }

        throw new ErrorException('Something went wrong while looking up a node.');
    }

    private function recursiveUpdateSubtreeHeight(Node $node): void
    {
        $nodeParent = $node->getParent();

        if ($nodeParent === null) {
            return;
        }

        //TODO: учесть, что при удалении будет $nodeParent->getLeftSubtreeHeight() - 1 и $nodeParent->getRightSubtreeHeight() - 1
        if ($nodeParent->getValue() > $node->getValue()) {
            $nodeParent->setLeftSubtreeHeight($nodeParent->getLeftSubtreeHeight() + 1);
        } else {
            $nodeParent->setRightSubtreeHeight($nodeParent->getRightSubtreeHeight() + 1);
        }
        $this->recursiveUpdateSubtreeHeight($nodeParent);
    }
}

try {
    $AVLTree = new AVLTree();
    $AVLTree->insert(5);
    $AVLTree->insert(2);
    $AVLTree->insert(8);
    $AVLTree->insert(3);
    $AVLTree->insert(15);
    $foo;
} catch(ErrorException $e) {
    var_dump($e);
}
