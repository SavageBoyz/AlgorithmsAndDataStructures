<?php

namespace avl_tree\Services;
use avl_tree\Entity;
use ErrorException;

class NodeService {
    public static function recursiveUpdateSubtreeHeights(Entity\Node $node): void
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
        self::recursiveUpdateSubtreeHeights($nodeParent);
    }

    /**
     * @throws ErrorException
     */
    public static function recursiveBalancingTree(Entity\Node $node)
    {
        if ($node->getSubtreeHeightsDiff() >= 2) {
            $leftChild = $node->getLeftChild();

            if ($leftChild->getSubtreeHeightsDiff() === 0) {
                $node->setLeftChild($leftChild->getRightChild());
                $leftChild->setParent($node->getParent());
                $node->setParent($leftChild);
            } if ($leftChild->getSubtreeHeightsDiff() <= -2) {
                $rightChildOfLeftChild = $leftChild->getRightChild();

                if ($rightChildOfLeftChild->getSubtreeHeightsDiff() !== 0) {
                    throw new ErrorException('Something went wrong while balancing the tree.');
                }

                $leftChild->setRightChild($rightChildOfLeftChild->getLeftChild());
                $node->setLeftChild($rightChildOfLeftChild->getRightChild());
                $rightChildOfLeftChild->setParent($node->getParent());
                $leftChild->setParent($rightChildOfLeftChild);
                $node->setParent($rightChildOfLeftChild);
            } else {
//                throw new ErrorException('Something went wrong while balancing the tree.');
                $node->setParent($leftChild);
                $leftChild->setRightChild($node);
                $leftChild->setParent(null);
            }
        } elseif($node->getSubtreeHeightsDiff() <= -2) {

        }

        if (!empty($node->getParent())) {
            self::recursiveBalancingTree($node->getParent());
        }
    }
}