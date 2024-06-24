<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Website extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];

    protected $fillable = [
        'name',
        'url',
        'category_id'
    ];

    public function categories(): BelongsToMany
    {
        // return $this->belongsToMany(Category::class, 'category_website');
        return $this->belongsToMany(Category::class, 'category_website')->withPivot('category_id', 'website_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
