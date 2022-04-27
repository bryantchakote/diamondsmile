<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Traitement;

class Traitements extends Component
{
    public function render()
    {
        return view('livewire.traitements', [
            'traitements' => Traitement::all(),
        ]);
    }
}
