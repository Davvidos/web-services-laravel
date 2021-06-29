<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'body', 'author_id'];

    protected $table = 'articles';

    use HasFactory;

    public function author()
    {
        $this->belongsTo('\Models\Author','author_id','id');
    }
}
