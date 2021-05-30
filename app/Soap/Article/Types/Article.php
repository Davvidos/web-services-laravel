<?php

declare(strict_types=1);

namespace App\Soap\Article\Types;

class Article
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $body;

    /**
     * Article constructor.
     *
     * @param int $id
     * @param string $title
     * @param string $body
     */
    public function __construct(int $id, string $title = '', string $body = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
    }
}
