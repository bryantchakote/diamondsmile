<div class="bg-tranparent">
    <div class="sm:px-16 py-2 bg-white rounded-md shadow-xl">
        <div class="my-10">
            <h1 class="mb-8 text-2xl text-center font-semibold">{{ $mode == 'ajout' ? 'Nouveau patient' : 'Modifier patient' }}</h1>
            
            <form wire:submit.prevent="{{ $mode == 'ajout' ? 'nouveauPatient' : 'modifierPatient' }}">
                <div class="md:grid md:grid-cols-3">
                    <div class="md:col-span-1 md:mr-5">
                        <x-jet-input class="block w-full" type="text" placeholder="Nom" wire:model="{{ $mode == 'ajout' ? 'n_nom' : 'm_nom' }}" required />

                        <div class="mt-5 flex justify-between">
                            <x-jet-label for="sexe" value="Sexe" class="pt-3 inline-block" />
                            <select class="w-full ml-5 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="sexe" wire:model="{{ $mode == 'ajout' ? 'n_sexe' : 'm_sexe' }}">
                                <option value="M">Homme</option>
                                <option value="F">Femme</option>
                            </select>
                        </div>
                        
                        <div class="mt-5 flex justify-between">
                            <x-jet-label for="date_nais" value="Date de naissance" class="pt-3 inline-block" />
                            <x-jet-input class="md:w-7/12 sm:w-9/12" type="date" placeholder="Date de naissance" id="date_nais" wire:model="{{ $mode == 'ajout' ? 'n_date_nais' : 'm_date_nais' }}" max="{{ date('Y-m-d') }}" />
                        </div>

                        <x-jet-input class="block w-full mt-5" type="text" placeholder="Lieu de naissance" wire:model="{{ $mode == 'ajout' ? 'n_lieu_nais' : 'm_lieu_nais' }}" />
                        <x-jet-input class="block w-full mt-5" type="text" placeholder="Adresse" wire:model="{{ $mode == 'ajout' ? 'n_adresse' : 'm_adresse' }}" />
                    </div>

                    <div class="md:col-span-1 md:pl-5 md:pr-5 sm:pt-5 md:pt-0 md:border-l md:border-dashed">
                        <x-jet-input class="block w-full" type="text" placeholder="Numéro de téléphone" wire:model="{{ $mode == 'ajout' ? 'n_tel' : 'm_tel' }}" />
                        <x-jet-input class="block w-full mt-5" type="email" placeholder="Adresse email" wire:model="{{ $mode == 'ajout' ? 'n_email' : 'm_email' }}" />
                        <x-jet-input class="block w-full mt-5" type="text" placeholder="Profession" wire:model="{{ $mode == 'ajout' ? 'n_profession' : 'm_profession' }}" />
                        <x-jet-input class="block w-full mt-5" type="text" placeholder="Nom du référant" wire:model="{{ $mode == 'ajout' ? 'n_referant' : 'm_referant' }}" />
                        <x-jet-input class="block w-full mt-5" type="text" placeholder="Numéro de téléphone du référant" wire:model="{{ $mode == 'ajout' ? 'n_tel_referant' : 'm_tel_referant' }}" />
                    </div>

                    <div class="md:col-span-1 md:pl-5 sm:pt-5 md:pt-0 md:border-l md:border-dashed">
                        <x-jet-input class="block w-full" type="text" placeholder="Compagnie d'assurance" wire:model="{{ $mode == 'ajout' ? 'n_assurance' : 'm_assurance' }}" />
                        <x-jet-input class="block w-full mt-5" type="text" placeholder="Matricule assuré" wire:model="{{ $mode == 'ajout' ? 'n_matricule' : 'm_matricule' }}" />
                        <x-jet-input class="block w-full mt-5" type="text" placeholder="Employeur" wire:model="{{ $mode == 'ajout' ? 'n_employeur' : 'm_employeur' }}" />

                        <div class="mt-5 flex justify-between">
                            <div class="flex w-6-5/12">
                                <x-jet-input class="w-11/12 mr-1 pl-2 pr-1" type="number" min="0" max="100" id="taux_couvert" placeholder="Taux de couverture" wire:model="{{ $mode == 'ajout' ? 'n_taux_couvert' : 'm_taux_couvert' }}" />
                                <x-jet-label for="taux_couvert" value="%" class="pt-3 inline-block" />
                            </div>

                            <div class="flex w-4-5/12">
                                <x-jet-input class="w-11/12 mr-1 pl-2 pr-1" type="number" id="valeur_D" placeholder="Valeur_D" wire:model="{{ $mode == 'ajout' ? 'n_valeur_D' : 'm_valeur_D' }}" />
                                <x-jet-label for="valeur_D" value="FCFA" class="pt-3 inline-block" />
                            </div>
                        </div>

                        <div class="flex items-center md:justify-end sm:justify-center sm:mt-12 md:mt-6">
                            <x-jet-button class="sm:mx-auto">{{ $mode == 'ajout' ? 'Enregistrer' : 'Modifier' }}</x-jet-button>
                            @if ($mode == 'modif')
                            <x-jet-button class="sm:mx-auto hover:bg-red-500 bg-red-900" wire:click="supprimerPatient">Supprimer</x-jet-button>
                            <x-jet-button class="sm:mx-auto" wire:click="modeAjout">Annuler</x-jet-button>
                            @endif
                            @if (session()->has('patient_cree'))
                            <span x-data="{ shown: false, timeout: null }"
                                x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                                x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="ml-5 p-2 bg-green-500 text-green-200 text-sm rounded shadow">
                                {{ session('patient_cree') }}
                            </span>
                            @endif
                            @if (session()->has('patient_modifie'))
                            <span x-data="{ shown: false, timeout: null }"
                                x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                                x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="ml-5 p-2 bg-green-500 text-green-200 text-sm rounded shadow">
                                {{ session('patient_modifie') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>                    
            </form>
        </div>

        @if (count($patients) > 0)
        <hr>

        <div class="my-10">
            <h1 class="mb-8 text-2xl text-center font-semibold">Liste des patients</h1>

            <div class="flex flex-col sm:justify-center items-center">
                <table class="mb-6 overflow-hidden">
                    <tr>
                        <th class="md:px-3 sm:px-1 py-1">#</th>
                        <th class="md:px-3 sm:px-1 py-1">Patient</th>
                        <th class="md:px-3 sm:px-1 py-1">Sexe</th>
                        <th class="md:px-3 sm:pl-4 py-1 table-cell sm:text-right md:text-center">Age</th>
                        <th class="md:px-3 sm:px-1 py-1">Tél</th>
                        <th class="md:px-3 sm:px-1 py-1 sm:hidden md:table-cell">Assuré</th>
                        <th class="md:px-3 sm:px-1 py-1 md:hidden sm:table-cell">Ass.</th>
                        <th class="px-3 py-1 sm:hidden md:table-cell">Dépense</th>
                        <th class="px-3 py-1 sm:hidden md:table-cell">Dette</th>
                        <th class="md:px-3 sm:pl-3 sm:pr-1 py-1"></th>
                    </tr>
                    @php $i = 1 @endphp
                    @foreach($patients as $patient)
                    <tr class="hover:bg-gray-200">
                        @if (substr($patient->date_nais, 5, 5) == substr(now(), 5, 5))
                        <th class="md:px-3 sm:px-1 text-green-500">A</th>
                        @else
                        <th class="md:px-3 sm:px-1">{{ $i }}</th>
                        @endif
                        @php $i++ @endphp
                        <td class="px-3 flex sm:hidden md:table-cell">{{ $patient->nom }}</td>
                        <td class="px-1 flex md:hidden sm:table-cell">{{ str_split($patient->nom, 22)[0] }}</td>
                        <td class="md:px-3 sm:px-1 py-1 text-center">{{ $patient->sexe }}</td>
                        <td class="px-3 py-1 sm:hidden md:block text-right">{{ $patient->age() . ' ans' }}</td>
                        <td class="pl-1 pr-2 py-1 sm:block md:hidden text-right">{{ $patient->age() }}</td>
                        <td class="md:px-3 sm:px-1 py-1 text-right">{{ $patient->tel }}</td>
                        <td class="md:px-3 sm:px-1 py-1 text-center">
                            @if ($patient->assure())
                            <p title="Assuré">O</p>
                            @else
                            <p title="Non assuré">N</p>
                            @endif
                        </td>
                        <td class="px-3 py-1 sm:hidden md:table-cell text-right">{{ $patient->depense() }}</td>
                        <td class="px-3 py-1 sm:hidden md:table-cell text-right">{{ $patient->dette() }}</td>
                        <td class="md:px-3 sm:pl-3 sm:pr-1 py-1 text-center">
                            <button class="hover:text-green-500 font-semibold" wire:click="modeModif({{ $patient->id }})" title="Modifier">M</button> &nbsp;
                            <button class="hover:text-green-500 font-semibold" title="Voir dossier"><a href="patient/{{ $patient->id }}">D</a></button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            {{ $patients->links() }}
        </div>
        @endif
    </div>
</div>
