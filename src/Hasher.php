<?php

namespace Gallib\ShortUrl;

class Hasher
{
    /**
     * @var int
     */
    protected $length = 6;

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Generate a random hash.
     *
     * @return string
     */
    public function generate(): string
    {
        $characters = str_repeat('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', $this->length);

        return substr(str_shuffle($characters), 0, $this->length);
    }
}
