<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    use HasFactory;

    public $fillable = [
        'id_patient',
        'id_antecedent',
        'commentaire',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_patient');
    }

    public function antecedent()
    {
        return $this->belongsTo(Antecedent::class, 'id_antecedent');
    }
}
