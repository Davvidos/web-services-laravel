<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::all();
    }

    public function show(Article $article): Article
    {
        return $article;
    }

    public function create(Request $request): JsonResponse
    {
        $article = Article::create($request->all());

        return response()->json($article, 201);
    }

    public function update(Request $request, Article $article): JsonResponse
    {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Article $article): JsonResponse
    {
        $article->delete();

        return response()->json(null, 204);
    }

    public function getArticlesByAuthor($id): Collection
    {
       return Article::all()->where('author_id', '=', $id);
    }
}
