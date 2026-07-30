<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteNews extends Model
{
    protected $table = 'website_news';

    protected $fillable = ['title', 'summary', 'content', 'image', 'category', 'is_published', 'published_at'];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'date',
    ];
}
