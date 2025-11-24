<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoEnzymeTracking extends Model
{
    protected $table = 'eco_enzyme_trackings';

    protected $fillable = [
        'waste_bank_id',
        'batch_name',
        'start_date',
        'end_date',
        'notes',
    ];

    public function wasteBank()
    {
        return $this->belongsTo(WasteBank::class, 'waste_bank_id');
    }
}
