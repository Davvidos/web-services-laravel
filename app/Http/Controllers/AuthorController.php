<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function index()
    {
        return Author::all();
    }

    public function show(Author $author): Author
    {
        return $author;
    }

    public function create(Request $request): JsonResponse
    {
        $author = Author::create($request->all());

        return response()->json($author, 201);
    }

    public function update(Request $request, Author $author)
    {
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete(Author $author)
    {
        $author->delete();

        return response()->json(null, 204);
    }

    public function getAuthorsByArticle($id): Collection
    {
        return DB::table('articles')
            ->join('authors', 'articles.author_id', '=', 'authors.id')
            ->select('authors.*')
            ->where('articles.id', '=', $id)
            ->get();
    }
}
