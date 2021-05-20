<?php

declare(strict_types=1);

namespace App\Soap\Article;

use App\Soap\Article\Types\Article;
use Illuminate\Support\Facades\DB;

class ArticleProvider
{
    /**
     * Returns article by id.
     *
     * @param int $articleId
     * @return Types\Article
     */
    public static function findArticle(int $articleId): Article
    {
        $article =  DB::table('articles')->where('id', $articleId)->first();

        return new Article($article->id, $article->title, $article->body);
    }

    /**
     * Returns all articles.
     *
     * @return Types\Article[]
     */
    public static function findArticles(): array
    {
        $collection =  DB::table('articles')->get();
        $data = [];
        foreach ($collection as $item) {
            $data[] = new Article($item->id, $item->title, $item->body);
        }

        return $data;
    }

    /**
     * Returns all articles.
     *
     * @param string $title
     * @param string $body
     * @return Types\Article
     */
    public static function addArticle(string $title, string $body): Article
    {
        $articleId = DB::table('articles')->insertGetId(
            ['title' => $title, 'body' => $body]
        );

        return ArticleProvider::findArticle($articleId);
    }

    /**
     * Removes an article.
     *
     * @param int $articleId
     * @return string
     */
    public static function removeArticle(int $articleId): string
    {
        $res = DB::table('articles')->where('id', '=', $articleId)->delete();

        return ($res) ? 'removed': 'not removed';
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
        $res = DB::table('articles')
            ->where('id', $articleId)
            ->update( ['title' => $title, 'body' => $body]);

        return ($res) ? 'updated': 'not updated';
    }
}
