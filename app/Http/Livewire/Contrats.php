<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contrat;

class Contrats extends Component
{
    public function render()
    {
        return view('livewire.contrats', [
            'contrats' => Contral::all(),
        ]);
    }
}
