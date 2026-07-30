<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteProgram extends Model
{
    protected $table = 'website_programs';

    protected $fillable = ['title', 'description', 'icon', 'badge_text', 'link_url', 'order_no', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'order_no'  => 'integer',
    ];
}
