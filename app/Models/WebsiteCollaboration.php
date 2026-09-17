<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebsiteCollaboration extends Model
{
    protected $table = 'website_collaborations';

    protected $fillable = [
        'institution_name',
        'institution_logo',
        'category',
        'location',
        'handover_date',
        'pic_name',
        'description',
        'order_no',
        'is_active',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'order_no'      => 'integer',
        'handover_date' => 'date',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(WebsiteCollaborationItem::class, 'collaboration_id');
    }

    public function equipments(): HasMany
    {
        return $this->items();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_no', 'asc')->orderBy('handover_date', 'desc');
    }

    public function getTotalItemsCountAttribute(): int
    {
        return $this->items()->count();
    }

    public function getTotalUnitsSumAttribute(): int
    {
        return (int) $this->items()->sum('quantity');
    }
}
