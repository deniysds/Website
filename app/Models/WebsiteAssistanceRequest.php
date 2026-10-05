<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WebsiteAssistanceRequest extends Model
{
    protected $table = 'website_assistance_requests';

    protected $fillable = [
        'ticket_code',
        'institution_name',
        'institution_type',
        'pic_name',
        'pic_position',
        'pic_phone',
        'pic_email',
        'province',
        'city',
        'address',
        'assistance_type',
        'equipment_needed',
        'urgency_reason',
        'attachment_path',
        'status',
        'admin_notes',
        'reviewed_at',
        'approved_at',
        'distributed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'distributed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (WebsiteAssistanceRequest $model) {
            if (empty($model->ticket_code)) {
                $model->ticket_code = static::generateTicketCode();
            }
        });
    }

    public static function generateTicketCode(): string
    {
        do {
            $code = 'REQ-' . date('ym') . '-' . strtoupper(Str::random(5));
        } while (static::where('ticket_code', $code)->exists());

        return $code;
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeDistributed($query)
    {
        return $query->where('status', 'distributed');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'reviewed' => 'Sedang Ditinjau',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'distributed' => 'Bantuan Disalurkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
            'reviewed' => 'bg-blue-100 text-blue-800 border-blue-200',
            'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'rejected' => 'bg-red-100 text-red-800 border-red-200',
            'distributed' => 'bg-purple-100 text-purple-800 border-purple-200',
            default => 'bg-slate-100 text-slate-800 border-slate-200',
        };
    }
}
