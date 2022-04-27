<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    public $fillable = [
        'medocs_en_cours',
        'observations',
        'frais',
        'id_visite',
    ];

    public function visite()
    {
        return $this->belongsTo(Visite::class, 'id_visite');
    }

    public function exams()
    {
        return $this->hasMany(Examen::class, 'id_cons');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'id_cons');
    }
}
