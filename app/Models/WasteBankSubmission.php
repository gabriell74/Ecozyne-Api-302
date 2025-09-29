<?php

namespace App\Models;

use App\Models\Community;
use App\Models\WasteBank;
use Illuminate\Database\Eloquent\Model;

class WasteBankSubmission extends Model
{
    protected $table = 'waste_bank_submission';

    protected $fillable = [
        'community_id',
        'waste_bank_name',
        'waste_bank_location',
        'latitude',
        'longitude',
        'file_document',
        'notes',
        'status',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function wasteBank(): HasOne
    {
        return $this->hasOne(WasteBank::class);
    }
}