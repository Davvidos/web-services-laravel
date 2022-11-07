<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticlePostRequest;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Article::all(), 200);
    }

    public function show(Article $article): JsonResponse
    {
        return response()->json($article, 200);
    }

    public function create(ArticlePostRequest $request): JsonResponse
    {
        $article = Article::create($request->all());

        return response()->json($article, 201);
    }

    public function update(ArticlePostRequest $request, Article $article): JsonResponse
    {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Article $article): JsonResponse
    {
        $article->delete();

        return response()->json(null, 204);
    }

    public function getArticlesByAuthor(int $id): JsonResponse
    {
        $articles =  Article::all()->where('author_id', '=', $id);

        return response()->json($articles, 200);
    }

    public function getArticlesByAuthorDetails(int $id): JsonResponse
    {
        $articles = DB::table('articles')
            ->join('authors', 'articles.author_id', '=', 'authors.id')
            ->where('authors.id', '=', $id)
            ->get();

        return response()->json($articles, 200);
    }

    public function addAuthorToArticle(Article $article, int $author_id): JsonResponse
    {
        $article->update(['author_id' => $author_id]);

        return response()->json($article, 200);
    }

    public function removeAuthorFromArticle(Article $article): JsonResponse
    {
        $article->update(['author_id' => null]);

        return response()->json($article, 200);
    }
}
