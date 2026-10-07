<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WebsiteDocument extends Model
{
    protected $table = 'website_documents';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'file_path',
        'file_size',
        'file_extension',
        'published_year',
        'download_count',
        'order_no',
        'is_active',
    ];

    protected $casts = [
        'file_size'      => 'integer',
        'download_count' => 'integer',
        'order_no'       => 'integer',
        'is_active'      => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (WebsiteDocument $model) {
            if (empty($model->slug)) {
                $slug = Str::slug($model->title);
                $originalSlug = $slug;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }
                $model->slug = $slug;
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }

        return $bytes . ' B';
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'laporan_tahunan'   => 'Laporan Tahunan (Annual Report)',
            'laporan_keuangan'  => 'Laporan Keuangan Teraudit',
            'legalitas_sk'      => 'Legalitas & SK Kemenkumham',
            'panduan_sop'       => 'SOP & Panduan Program',
            'brosur_profil'     => 'Brosur & Profil Yayasan',
            default             => ucwords(str_replace('_', ' ', $this->category)),
        };
    }

    public function getCategoryBadgeClassAttribute(): string
    {
        return match ($this->category) {
            'laporan_tahunan'   => 'bg-blue-100 text-blue-800 border-blue-200',
            'laporan_keuangan'  => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'legalitas_sk'      => 'bg-purple-100 text-purple-800 border-purple-200',
            'panduan_sop'       => 'bg-amber-100 text-amber-800 border-amber-200',
            'brosur_profil'     => 'bg-red-100 text-red-800 border-red-200',
            default             => 'bg-slate-100 text-slate-800 border-slate-200',
        };
    }
}
