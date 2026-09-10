<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteOfficer extends Model
{
    protected $table = 'website_officers';

    protected $fillable = [
        'name',
        'title_prefix',
        'title_suffix',
        'position',
        'category',
        'hierarchy_level',
        'affiliation',
        'bio',
        'photo_path',
        'email',
        'linkedin_url',
        'order_no',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'hierarchy_level' => 'integer',
        'order_no' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByHierarchy($query, int $level)
    {
        return $query->where('hierarchy_level', $level);
    }

    /**
     * Get full name formatted with prefix and suffix.
     */
    public function getFullNameWithTitleAttribute(): string
    {
        $prefix = $this->title_prefix ? trim($this->title_prefix) . ' ' : '';
        $suffix = $this->title_suffix ? ', ' . trim($this->title_suffix) : '';
        return $prefix . trim($this->name) . $suffix;
    }

    /**
     * Get label for hierarchy level.
     */
    public function getHierarchyLabelAttribute(): string
    {
        return match ($this->hierarchy_level) {
            1 => 'Tingkat 1: Dewan Pembina & Pengawas',
            2 => 'Tingkat 2: Pimpinan Harian / Ketua',
            3 => 'Tingkat 3: Sekretaris & Manajemen Eksekutif',
            4 => 'Tingkat 4: Dewan Redaksi Jurnal & Tim Ahli',
            default => 'Lainnya',
        };
    }

    /**
     * Get label for category.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'pembina' => 'Dewan Pembina',
            'pengawas' => 'Dewan Pengawas',
            'pengurus_harian' => 'Pengurus Harian',
            'dewan_redaksi' => 'Dewan Redaksi Jurnal',
            'tim_ahli' => 'Komite Ilmiah & Tim Ahli',
            default => ucfirst(str_replace('_', ' ', $this->category)),
        };
    }
}
