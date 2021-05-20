<?php

declare(strict_types=1);

namespace App\Soap\Article;

use App\Soap\Article\Types\Article;
use SoapFault;
use App\Soap\Article\ArticleProvider as Provider;

class ArticleService
{
    /**
     * Returns an article by id.
     *
     * @param int $articleId
     * @return Article
     * @throws SoapFault
     */
    public function getArticle(int $articleId): Article
    {
        if (!$articleId) {
            header("Status: 400");
            throw new SoapFault('SOAP-ENV:Client', 'Please specify product id.');
        }

        return Provider::findArticle($articleId);
    }

    /**
     * Returns an array of articles.
     *
     * @return Article[]
     */
    public function getArticles(): array
    {
        return Provider::findArticles();
    }

    /**
     * Adds an article.
     *
     * @param string $title
     * @param string $body
     * @return Article
     */
    public function addArticle(string $title, string $body): Article
    {
        return Provider::addArticle($title, $body);
    }

    /**
     * Removes an article.
     *
     * @param int $articleId
     * @return string
     */
    public function removeArticle(int $articleId): string
    {
        return Provider::removeArticle($articleId);
    }

    /**
     * Updates an article by id.
     *
     * @param int $articleId
     * @param string $title
     * @param string $body
     * @return string
     */
    public function updateArticle(int $articleId, string $title, string $body): string
    {
        return Provider::updateArticle($articleId, $title, $body);
    }
}
