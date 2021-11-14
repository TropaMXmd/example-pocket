<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag'
    ];

    /**
     * Get the contents that belong to the keyword.
     */
    public function contents()
    {
        return $this->belongsToMany(Content::class)->using(ContentKeyword::class);
    }
}
