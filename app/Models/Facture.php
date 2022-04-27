<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    public $fillable = [
        'total',
        'remise',
        'reglee_assureur',
        'reglee_assure',
        'id_visite',
    ];

    public function visite()
    {
        return $this->belongsTo(Visite::class, 'id_visite');
    }

    public function reglements()
    {
        return $this->hasMany(Reglement::class, 'id_facture');
    }
}
