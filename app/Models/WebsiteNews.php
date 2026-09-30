<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WebsiteNews extends Model
{
    protected $table = 'website_news';

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'category',
        'author_name',
        'tags',
        'views_count',
        'is_featured',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured'  => 'boolean',
        'published_at' => 'date',
        'views_count'  => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = static::generateUniqueSlug($news->title);
            }
            if (empty($news->author_name)) {
                $news->author_name = 'Tim Redaksi YSDS';
            }
        });
    }

    /**
     * Generate unique slug for an article.
     */
    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: 'artikel-' . time();
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Scope for published articles.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for featured articles.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Estimated reading time in minutes.
     */
    public function getReadingTimeAttribute(): string
    {
        $wordCount = str_word_count(strip_tags((string) $this->content) . ' ' . strip_tags((string) $this->summary));
        $minutes = max(1, (int) ceil($wordCount / 200));
        return "{$minutes} menit baca";
    }

    /**
     * Tags as array.
     */
    public function getTagsArrayAttribute(): array
    {
        if (empty($this->tags)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->tags))));
    }

    /**
     * URL for the image or placeholder.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return null;
    }
}
