<?php

declare(strict_types=1);

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::get('articles', [ArticleController::class, 'index']);
Route::get('articles/{article}', [ArticleController::class, 'show']);
Route::post('articles', [ArticleController::class, 'create']);
Route::put('articles/{article}', [ArticleController::class, 'update']);
Route::delete('articles/{article}', [ArticleController::class, 'delete']);

Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/{author}', [AuthorController::class, 'show']);
Route::post('authors', [AuthorController::class, 'create']);
Route::put('authors/{author}', [AuthorController::class, 'update']);
Route::delete('authors/{author}', [AuthorController::class, 'delete']);

Route::get('authors/{author}/articles', [ArticleController::class, 'getArticlesByAuthor']);
Route::get('articles/{article}/authors', [AuthorController::class, 'getAuthorsByArticle']);
