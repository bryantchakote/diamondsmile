<div class="bg-tranparent">
    <div class="sm:px-16 py-2 bg-white rounded-md shadow-xl">
        <div class="my-10">
            <h1 class="mb-8 text-2xl text-center font-semibold">{{ $mode == 'ajout' ? 'Nouveau rendez-vous' : 'Modifier le rendez-vous' }}</h1>

            <div class="md:block sm:hidden">
                <div class="md:grid md:grid-cols-4">
                    <div class="md:col-span-1">
                        @if ($mode == 'ajout')
                        <x-jet-input wire:model="n_nom_patient" type="text" placeholder="Nom du patient" required />

                        <ul class="pl-3">
                            @foreach($patients as $patient)
                            @if($n_nom_patient != '')
                                <li>
                                    <button wire:click="selectionner({{ $patient->id }})">{{ $patient->nom }}</button>
                                </li>
                            @endif
                            @endforeach
                        </ul>
                        @else
                        <x-jet-input type="text" wire:model="m_nom_patient" disabled />
                        @endif
                    </div>

                    <div class="md:col-span-1">
                        <x-jet-input type="date" wire:model="{{ $mode == 'ajout' ? 'n_date' : 'm_date' }}" min="{{ date('Y-m-d') }}" required />
                    </div>

                    <div class="md:col-span-1">
                        <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="{{ $mode == 'ajout' ? 'n_motif' : 'm_motif' }}">
                            <option value="consultation" disabled>Motif</option>
                            <option value="consultation">Consultation</option>
                            <option value="traitement">Traitement</option>
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        @if ($mode == 'ajout')
                        <x-jet-button class="block mt-1 mb-1" wire:click="nouveauRdv">Ajouter</x-jet-button>
                        @else
                        <x-jet-button class="mt-1 mb-1" wire:click="modifierRdv({{ $m_rdv->id }})">Modifier</x-jet-button>
                        <x-jet-button class="mt-1 mb-1" wire:click="modeAjout">Annuler</x-jet-button>
                        @endif
                    </div>
                </div>

                <div class="mt-6 h-2">
                    @if ($mode == 'ajout')
                        @error('n_nom_patient')
                        <span class="pl-4 text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                        @error('n_date')
                        <span class="pl-4 text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    @endif

                    @if (session()->has('nom_invalide'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-red-500 text-red-200 text-sm rounded shadow">
                        {{ session('nom_invalide') }}
                    </span>
                    @endif
                    @if (session()->has('rdv_ajoute'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-green-500 text-green-200 text-sm rounded shadow">
                        {{ session('rdv_ajoute') }}
                    </span>
                    @endif
                    @if (session()->has('rdv_existant'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-red-500 text-red-200 text-sm rounded shadow">
                        {{ session('rdv_existant') }}
                    </span>
                    @endif
                    @if (session()->has('rdv_modifie'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-green-500 text-green-200 text-sm rounded shadow">
                        {{ session('rdv_modifie') }}
                    </span>
                    @endif
                    @if (session()->has('rdv_non_modifie'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-red-500 text-red-200 text-sm rounded shadow">
                        {{ session('rdv_non_modifie') }}
                    </span>
                    @endif
                </div>
            </div>

            <div class="md:hidden sm:block">
                <div>
                    @if ($mode == 'ajout')
                    <x-jet-input wire:model="n_nom_patient" type="text" placeholder="Nom du patient" required />

                    <ul class="pl-3">
                        @foreach($patients as $patient)
                        @if($n_nom_patient != '')
                            <li>
                                <button wire:click="selectionner({{ $patient->id }})">{{ $patient->nom }}</button>
                            </li>
                        @endif
                        @endforeach
                    </ul>
                    @else
                    <x-jet-input type="text" wire:model="m_nom_patient" disabled />
                    @endif
                </div>

                <div class="flex justify-between mt-8">
                    <div class="md:col-span-1">
                        <x-jet-input type="date" wire:model="{{ $mode == 'ajout' ? 'n_date' : 'm_date' }}" min="{{ date('Y-m-d') }}" required />
                    </div>

                    <div class="md:col-span-1">
                        <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="{{ $mode == 'ajout' ? 'n_motif' : 'm_motif' }}">
                            <option value="consultation" disabled>Motif</option>
                            <option value="consultation">Consultation</option>
                            <option value="traitement">Traitement</option>
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        @if ($mode == 'ajout')
                        <x-jet-button class="block mt-1 mb-1" wire:click="nouveauRdv">Ajouter</x-jet-button>
                        @else
                        <x-jet-button class="mt-1 mb-1" wire:click="modifierRdv({{ $m_rdv->id }})">Modifier</x-jet-button>
                        <x-jet-button class="mt-1 mb-1" wire:click="modeAjout">Annuler</x-jet-button>
                        @endif
                    </div>
                </div>

                <div class="mt-6 h-2">
                    @if ($mode == 'ajout')
                        @error('n_nom_patient')
                        <span class="pl-4 text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                        @error('n_date')
                        <span class="pl-4 text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    @endif

                    @if (session()->has('nom_invalide'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-red-500 text-red-200 text-sm rounded shadow">
                        {{ session('nom_invalide') }}
                    </span>
                    @endif
                    @if (session()->has('rdv_ajoute'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-green-500 text-green-200 text-sm rounded shadow">
                        {{ session('rdv_ajoute') }}
                    </span>
                    @endif
                    @if (session()->has('rdv_existant'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-red-500 text-red-200 text-sm rounded shadow">
                        {{ session('rdv_existant') }}
                    </span>
                    @endif
                    @if (session()->has('rdv_modifie'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-green-500 text-green-200 text-sm rounded shadow">
                        {{ session('rdv_modifie') }}
                    </span>
                    @endif
                    @if (session()->has('rdv_non_modifie'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 bg-red-500 text-red-200 text-sm rounded shadow">
                        {{ session('rdv_non_modifie') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        @if (count($rdvs) > 0) 
        <hr>

        <div class="my-10">
            <h1 class="mb-8 text-2xl text-center font-semibold">Rendez-vous au programme</h1>

            <div class="flex flex-col sm:justify-center items-center">
                <table class="mb-6 overflow-hidden">
                    <tr>
                        <th class="md:px-3 sm:px-1 py-1">#</th>
                        <th class="md:px-3 sm:px-1 py-1">Patient</th>
                        <th class="md:px-3 sm:px-1 py-1">Tél</th>
                        <th class="md:px-3 sm:px-1 py-1">Date</th>
                        <th class="md:px-3 sm:px-1 sm:hidden md:inline py-1">Motif</th>
                        <th class="md:px-3 sm:pl-3 sm:pr-1 py-1"></th>
                    </tr>
                    @php $i = 1 @endphp
                    @foreach($rdvs as $rdv)
                    <tr class="hover:bg-gray-200">
                        <th class="md:px-3 sm:px-1 py-1">{{ $i }}</th> @php $i++ @endphp
                        <td class="px-3 sm:hidden md:table-cell py-1">{{ $rdv->patient->nom }}</td>
                        <td class="px-1 md:hidden sm:table-cell py-1">{{ str_split($rdv->patient->nom, 22)[0] }}</td>
                        <td class="md:px-3 sm:px-1 py-1 text-right">{{ $rdv->patient->tel }}</td>
                        <td class="md:px-3 sm:px-1 py-1 text-right">{{ Carbon\Carbon::createFromDate($rdv->date)->locale('fr')->isoFormat('Do MMM YYYY') }}</td>
                        <td class="md:px-3 sm:px-1 sm:hidden md:inline py-1">{{ $rdv->motif }}</td>
                        <td class="md:px-3 sm:px-1 sm:pl-3 sm:pr-1 py-1 text-center">
                            <button wire:click="modeModif({{ $rdv->id }})"><i class="fas fa-pen hover:text-green-500"></i></button> &nbsp;
                            <button wire:click="supprimerRdv({{ $rdv->id }})"><i class="fas fa-times hover:text-red-500"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>

            {{ $rdvs->links() }}
            @endif
        </div>
    </div>
</div>
