<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    public $fillable = [
        'commentaire',
        'id_plan',
        'id_visite',
    ];

    public function visite()
    {
        return $this->belongsTo(Visite::class, 'id_visite');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'id_plan');
    }
}
