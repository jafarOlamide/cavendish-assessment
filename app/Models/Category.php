<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];


    public function websites(): BelongsToMany
    {
        // return $this->belongsToMany(Website::class, 'category_website');
        return $this->belongsToMany(Website::class, 'category_website')->withPivot('category_id', 'website_id');
    }
}
