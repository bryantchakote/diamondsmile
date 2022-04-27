<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rdv extends Model
{
    use HasFactory;

    public $fillable = [
        'date',
        'motif',
        'id_patient',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_patient');
    }
}
