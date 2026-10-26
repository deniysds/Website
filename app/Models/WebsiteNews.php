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
        'title_en',
        'slug',
        'summary',
        'summary_en',
        'content',
        'content_en',
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
     * Localized title according to active application locale.
     */
    public function getTitleLocalizedAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->title_en))
            ? $this->title_en
            : (string) $this->title;
    }

    /**
     * Localized summary according to active application locale.
     */
    public function getSummaryLocalizedAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->summary_en))
            ? $this->summary_en
            : $this->summary;
    }

    /**
     * Localized full content according to active application locale.
     */
    public function getContentLocalizedAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->content_en))
            ? $this->content_en
            : (string) $this->content;
    }

    /**
     * Whether this article has an English translation.
     */
    public function getHasEnglishTranslationAttribute(): bool
    {
        return !empty($this->title_en) || !empty($this->content_en);
    }

    /**
     * Estimated reading time in minutes.
     */
    public function getReadingTimeAttribute(): string
    {
        $content = $this->content_localized;
        $summary = $this->summary_localized;
        $wordCount = str_word_count(strip_tags((string) $content) . ' ' . strip_tags((string) $summary));
        $minutes = max(1, (int) ceil($wordCount / 200));

        return app()->getLocale() === 'en'
            ? "{$minutes} min read"
            : "{$minutes} menit baca";
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
