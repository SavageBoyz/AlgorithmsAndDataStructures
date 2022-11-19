<?php

namespace avl_tree;
use avl_tree\Entity;
use avl_tree\Services;
use ErrorException;

require_once('entity/Node.php');
require_once('entity/GetNodeByValueResponse.php');
require_once('services/NodeService.php');

class AVLTree
{
    private ?Entity\Node $rootNode = null;

    /**
     * @throws ErrorException
     */
    public function find(int $value): ?Entity\Node
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
            $this->rootNode = new Entity\Node($value, null);
            return;
        }

        $nodeSearchResult = $this->getNodeByValue($value, $this->rootNode);
        if (!$nodeSearchResult->isError()) {
            throw new ErrorException('Node with a given value is exist already.');
        }

        $foundNode = $nodeSearchResult->getResult();
        $newNode = new Entity\Node($value, $foundNode);

        if ($foundNode->getValue() > $value) {
            $foundNode->setLeftChild($newNode);
            $foundNode->setLeftSubtreeHeight($foundNode->getLeftSubtreeHeight() + 1);
        } else {
            $foundNode->setRightChild($newNode);
            $foundNode->setRightSubtreeHeight($foundNode->getRightSubtreeHeight() + 1);
        }

        Services\NodeService::recursiveUpdateSubtreeHeights($foundNode);
        Services\NodeService::recursiveBalancingTree($foundNode);
    }

    /**
     * @throws ErrorException
     */
    private function getNodeByValue(int $value, Entity\Node $currentNode): Entity\GetNodeByValueResponse
    {
        if ($currentNode->getValue() === $value) {
            return new Entity\GetNodeByValueResponse($currentNode);
        }

        if ($currentNode->getValue() > $value) {
            if ($currentNode->getLeftChild() === null) {
                return new Entity\GetNodeByValueResponse($currentNode, true, 'Node is not exist.');
            }
            return $this->getNodeByValue($value, $currentNode->getLeftChild());
        }

        if ($currentNode->getValue() < $value) {
            if ($currentNode->getRightChild() === null) {
                return new Entity\GetNodeByValueResponse($currentNode, true, 'Node is not exist.');
            }
            return $this->getNodeByValue($value, $currentNode->getRightChild());
        }

        throw new ErrorException('Something went wrong while looking up a node.');
    }
}

try {
    $AVLTree = new AVLTree();
    $AVLTree->insert(8);
    $AVLTree->insert(7);
    $AVLTree->insert(6);
    $AVLTree->insert(5);
    $AVLTree->insert(4);
    $foo;
} catch(ErrorException $e) {
    var_dump($e);
}
