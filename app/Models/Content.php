<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 
        'description', 
        'url', 
        'media_url', 
        'pocket_id'
    ];

    /**
     * Get the pocket that own the content.
     */
    public function pocket()
    {
        return $this->belongsTo(Pocket::class);
    }

    /**
     * Get the keywords that belong to the content.
     */
    public function keywords()
    {
        return $this->belongsToMany(Keyword::class)->using(ContentKeyword::class);
    }
}
