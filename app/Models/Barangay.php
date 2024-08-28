<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'municity_id',
        'name',
    ];

    public function municity()
    {
        return $this->belongsTo(Municity::class);
    }

    public function assistanceEventBeneficiaries()
    {
        return $this->morphMany(AssistanceEventBeneficiary::class, 'beneficiary');
    }
}
