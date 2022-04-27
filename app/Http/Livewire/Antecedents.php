<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Antecedent;

class Antecedents extends Component
{
    public function render()
    {
        return view('livewire.antecedents', [
            'antecedents' => Antecedent::all(),
        ]);
    }
}
