<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reglement extends Model
{
    use HasFactory;

    public $fillable = [
        'date',
        'auteur',
        'montant',
        'id_facture',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class, 'id_facture');
    }
}
