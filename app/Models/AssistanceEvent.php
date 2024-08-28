<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'assistance_type_id',
        'event_name',
        'event_date',
        'venue',
        'amount',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function assistanceType()
    {
        return $this->belongsTo(AssistanceType::class);
    }
}
