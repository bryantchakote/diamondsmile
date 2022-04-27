<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    public $fillable = [
        'produit',
        'mode_emploi',
        'id_visite',
    ];

    public function visite()
    {
        return $this->belongsTo(Visite::class, 'id_visite');
    }
}
