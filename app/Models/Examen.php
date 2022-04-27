<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    public $fillable = [
        'nom',
        'bloc',
        'dent',
        'zone',
        'commentaire',
        'id_cons',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'id_cons');
    }
}
