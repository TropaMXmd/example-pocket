<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pocket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description'
    ];

    /**
     * Get the contents of the pocket.
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
