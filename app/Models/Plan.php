<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public $fillable = [
        'dents',
        'desc',
        'duree',
        'prix',
        'confirme',
        'termine',
        'id_cons',
        'id_trait',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'id_cons');
    }

    public function traitement()
    {
        return $this->belongsTo(Traitement::class, 'id_trait');
    }

    public function operations()
    {
        return $this->hasMany(Operation::class, 'id_plan');
    }
}
