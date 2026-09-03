<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteContact extends Model
{
    protected $table = 'website_contacts';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'message',
        'status',
        'admin_notes',
        'read_at',
        'replied_at',
    ];

    protected $casts = [
        'read_at'    => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }
}
