<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AuthorPostRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Author::all(), 200);
    }

    public function show(Author $author): JsonResponse
    {
        return response()->json($author, 200);
    }

    public function create(AuthorPostRequest $request): JsonResponse
    {
        $author = Author::create($request->all());

        return response()->json($author, 201);
    }

    public function update(AuthorPostRequest $request, Author $author): JsonResponse
    {
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete(Author $author): JsonResponse
    {
        $author->delete();

        return response()->json(null, 204);
    }

    public function getAuthorsByArticle(int $id): JsonResponse
    {
        $authors = DB::table('articles')
            ->join('authors', 'articles.author_id', '=', 'authors.id')
            ->select('authors.*')
            ->where('articles.id', '=', $id)
            ->get();

        return response()->json($authors, 200);
    }

    public function getAuthorsByArticleDetails(int $id): JsonResponse
    {
        $authors = DB::table('articles')
            ->join('authors', 'articles.author_id', '=', 'authors.id')
            ->where('articles.id', '=', $id)
            ->get();

        return response()->json($authors, 200);
    }
}
