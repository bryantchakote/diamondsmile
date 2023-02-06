<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traitement extends Model
{
    use HasFactory;

    public $fillable = [
        'type',
        'code',
        'designation',
    ];

    public function plans()
    {
        return $this->hasMany(Plan::class, 'id_trait');
    }

    public function prix($patientId)
    {
        $patient = Patient::find($patientId);
        $contrat = $patient->contrats->last();
        $valeur_D = $contrat->valeur_D;
        $valeur_SC = $contrat->valeur_SC;

        $prix = 0;

        if (!is_null($this->code)) {
            if (substr($this->code, 0, 1) == 'D' || substr($this->code, 0, 1) == 'Z') {
                $prix = intval(substr($this->code, 1, 2)) * $valeur_D;
            }

            elseif (substr($this->code, 0, 2) == 'SC') {
                $prix = intval(substr($this->code, 2, 2)) * $valeur_SC;
            }

            elseif (substr($this->code, 0, 1) != 'D' && substr($this->code, 0, 1) != 'Z' && substr($this->code, 0, 2) != 'SC') {
                $prix = intval($this->code);
            }

            if ($this->type != "RADIO" && $patient->age() < 5) {
                return round($prix *= 1.4);
            }
        }

        return round($prix);
    }
}
