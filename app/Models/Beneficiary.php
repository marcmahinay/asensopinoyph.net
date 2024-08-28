<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'asenso_id',
        'first_name',
        'last_name',
        'middle_name',
        'sex',
        'civil_status',
        'status',
        'image_path',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function assistanceReceived()
    {
        return $this->hasMany(AssistanceReceived::class);
    }

    public function assistanceEventBeneficiaries()
    {
        return $this->morphMany(AssistanceEventBeneficiary::class, 'beneficiary');
    }

    public function voucherCodes()
    {
        return $this->hasMany(VoucherCode::class);
    }
}

