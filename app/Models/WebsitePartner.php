<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;

class WebsitePartner extends Model
{
    protected $table = 'website_partners';

    protected $fillable = [
        'name',
        'logo_path',
        'type',
        'website_url',
        'order_no',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_no'  => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMain($query)
    {
        return $query->where('type', 'main');
    }

    public function scopeSupporting($query)
    {
        return $query->where('type', 'supporting');
    }
}
