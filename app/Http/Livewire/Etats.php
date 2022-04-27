<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Etat;

class Etats extends Component
{
    public function render()
    {
        return view('livewire.etats', [
            'etats' => Etat::all(),
        ]);
    }
}
