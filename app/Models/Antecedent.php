<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedent extends Model
{
    use HasFactory;

    public $fillable = [
        'categorie',
        'libelle',
    ];

    public function etats()
    {
        return $this->hasMany(Etat::class, 'id_antecedent');
    }
}
