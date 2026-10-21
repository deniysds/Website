<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WebsiteEvent extends Model
{
    protected $table = 'website_events';

    protected $fillable = [
        'title',
        'slug',
        'tag',
        'year',
        'partner_name',
        'sponsor_name',
        'banner_image',
        'summary',
        'description',
        'event_date',
        'event_time',
        'location',
        'registration_url',
        'is_featured',
        'is_published',
        'order_no',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'order_no'     => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (WebsiteEvent $model) {
            if (empty($model->slug)) {
                $base = Str::slug($model->title);
                $slug = $base;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$counter}";
                    $counter++;
                }
                $model->slug = $slug;
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getBannerUrlAttribute(): ?string
    {
        if (empty($this->banner_image)) {
            return null;
        }

        if (Str::startsWith($this->banner_image, ['http://', 'https://', '/assets/'])) {
            return $this->banner_image;
        }

        return Storage::disk('public')->url($this->banner_image);
    }
}
