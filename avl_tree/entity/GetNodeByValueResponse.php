<?php

namespace avl_tree\Entity;

require_once('entity/Response.php');

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
