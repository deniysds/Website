<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WebsiteVisitation extends Model
{
    protected $table = 'website_visitations';

    protected $fillable = [
        'title',
        'slug',
        'institution_name',
        'city',
        'province',
        'visit_date',
        'delegation_team',
        'summary',
        'description',
        'cover_image',
        'gallery_images',
        'video_url',
        'is_published',
        'order_no',
    ];

    protected $casts = [
        'visit_date'     => 'date',
        'gallery_images' => 'array',
        'is_published'   => 'boolean',
        'order_no'       => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (WebsiteVisitation $model) {
            if (empty($model->slug)) {
                $baseSlug = Str::slug($model->title);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }
                $model->slug = $slug;
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('visit_date', 'desc')->orderBy('id', 'desc');
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image && Storage::disk('public')->exists($this->cover_image)) {
            return Storage::disk('public')->url($this->cover_image);
        }

        return asset('assets/media/misc/hospital-placeholder.jpg');
    }

    public function getLocationLabelAttribute(): string
    {
        $parts = array_filter([$this->city, $this->province]);
        return !empty($parts) ? implode(', ', $parts) : 'Indonesia';
    }
}
