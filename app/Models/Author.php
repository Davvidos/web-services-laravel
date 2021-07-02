<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = ['firstName', 'lastName'];

    protected $table = 'authors';

    use HasFactory;

    public function articles(): HasMany
    {
        return $this->hasMany('\Models\Article','author_id','id');
    }
}
