<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_id',
        'code',
        'beneficiary_id',
        'is_redeemed',
        'redeemed_at',
        'redemption_location',
    ];

    protected $casts = [
        'is_redeemed' => 'boolean',
        'redeemed_at' => 'datetime',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }
    
}
