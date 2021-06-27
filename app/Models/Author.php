<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['firstName', 'lastName'];

    protected $table = 'authors';

    use HasFactory;

    public function articles()
    {
        return $this->hasMany('\Models\Article','author_id','id');
    }
}
