<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceReceived extends Model
{
    use HasFactory;

    protected $fillable = [
        'assistance_event_id',
        'beneficiary_id',
        'amount_received',
        'items_received',
        'received_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount_received' => 'decimal:2',
        'received_at' => 'datetime',
    ];

    public function assistanceEvent()
    {
        return $this->belongsTo(AssistanceEvent::class);
    }

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }
    
}
