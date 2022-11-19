<?php
namespace avl_tree\Entity;

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