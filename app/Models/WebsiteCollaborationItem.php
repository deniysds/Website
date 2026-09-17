<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteCollaborationItem extends Model
{
    protected $table = 'website_collaboration_items';

    protected $fillable = [
        'collaboration_id',
        'item_number',
        'name',
        'unit',
        'quantity',
        'specifications',
        'order_no',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'order_no' => 'integer',
    ];

    public function collaboration(): BelongsTo
    {
        return $this->belongsTo(WebsiteCollaboration::class, 'collaboration_id');
    }
}
