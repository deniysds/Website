<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WebsiteDonation extends Model
{
    protected $table = 'website_donations';

    protected $fillable = [
        'donation_code',
        'donor_name',
        'donor_type',
        'email',
        'phone',
        'program_target',
        'amount',
        'transfer_date',
        'payment_method',
        'bank_name',
        'proof_path',
        'is_anonymous',
        'message',
        'status',
        'admin_notes',
        'verified_at',
    ];

    protected $casts = [
        'amount'        => 'integer',
        'transfer_date' => 'date',
        'is_anonymous'  => 'boolean',
        'verified_at'   => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (WebsiteDonation $model) {
            if (empty($model->donation_code)) {
                do {
                    $code = 'DON-' . date('ym') . '-' . strtoupper(Str::random(5));
                } while (static::where('donation_code', $code)->exists());

                $model->donation_code = $code;
            }
        });
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'Hamba Allah (Anonim)';
        }

        return $this->donor_name;
    }

    public function getProgramTargetLabelAttribute(): string
    {
        return match ($this->program_target) {
            'alkes_pcr_3t'              => 'Bantuan Alkes & PCR Faskes 3T',
            'beasiswa_smk_fensensius'   => 'Beasiswa Siswa SMK Fensensius',
            'rumah_baca_halmahera'      => 'Rumah Baca & Pendidikan Halmahera',
            'umum'                      => 'Dana Kemanusiaan & Operasional YSDS',
            default                     => ucwords(str_replace('_', ' ', $this->program_target)),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default    => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'bg-amber-100 text-amber-800 border-amber-200',
            'verified' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'rejected' => 'bg-red-100 text-red-800 border-red-200',
            default    => 'bg-slate-100 text-slate-800 border-slate-200',
        };
    }
}
