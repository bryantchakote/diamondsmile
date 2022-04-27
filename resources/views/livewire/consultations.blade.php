<div>
    <div class="sm:px-16 py-2 bg-white rounded-md my-12">
        <div class="my-10">
            <h1 class="mb-8 text-2xl text-center font-semibold">Consultation</h1>
            <div class="flex flex-col text-center">
                <div class="mb-5">
                    <x-jet-input type="date" class="w-2/12" wire:model="date" wire:change="nouvelleDate" max="{{ date('Y-m-d') }}" required />
                    <x-jet-input type="text" class="w-9/12 mx-5" wire:model="medocs_en_cours" placeholder="Médicaments en cours" />
                </div>
                <div>
                    <x-jet-input type="text" class="w-2/12" wire:model="frais" placeholder="Frais" required />
                    <x-jet-input type="text" class="w-9/12 mx-5" wire:model="observations" placeholder="Observations" />
                </div>
            </div>
        </div>
        @if ($confirmer_nouvelle_date)
        <hr>
        <livewire:examens :consId="$id_cons" />
        <hr>
        <livewire:prescriptions :visiteId="App\Models\Consultation::find($id_cons)->visite->id" />
        <hr>
        <livewire:plans :consId="$id_cons" />
        @else
        <hr>
        <livewire:examens :consId="$id_cons" />
        <hr>
        <livewire:prescriptions :visiteId="App\Models\Consultation::find($id_cons)->visite->id" />
        <hr>
        <livewire:plans :consId="$id_cons" />
        @endif
    </div>

    <div class="text-center">
        <x-jet-button wire:click="ajouter_cons">Valider la consultation</x-jet-button>
        @if (session()->has('nouvelle_cons'))
        <span x-data="{ shown: false, timeout: null }"
            x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
            x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 mt-5 ml-5 bg-green-500 text-green-200 text-sm rounded shadow">
            {{ session('nouvelle_cons') }}
        </span>
        @endif
        <x-jet-button class="ml-5" wire:click="annuler">Annuler</x-jet-button>
    </div>
</div>
