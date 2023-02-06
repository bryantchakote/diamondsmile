<div class="bg-tranparent">
    <div class="sm:px-16 py-2 bg-white rounded-md">
        <div class="my-10">
            <h1 class="mb-8 text-2xl text-center font-semibold">{{ $patient->nom }}</h1>
            
            <div class="mb-8 flex flex-col justify-center sm:block md:hidden">
                <table class="mx-auto">
                    <tr>
                        <th rowspan="5" class="text-lg pr-4 border-r">Informations<br>personnelles</th>
                        <td class="font-semibold text-right px-2">Date nais.</td>
                        <td>{{ Carbon\Carbon::createFromDate($patient->date_nais)->locale('fr')->isoFormat('Do MMMM YYYY') . ' (' . $patient->age() . ' ans)' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Lieu</td>
                        <td>{{ ($patient->lieu_nais != '') ? $patient->lieu_nais : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Sexe</td>
                        <td>{{ $patient->sexe == 'M' ? 'Masculin' : 'Féminin' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Téléphone</td>
                        <td>{{ ($patient->tel != '') ? $patient->tel : '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 font-semibold text-right px-2">Mail</td>
                        <td class="pb-2">{{ ($patient->email != '') ? $patient->email : '-' }}</td>
                    </tr>
                    
                    <tr>
                        <th rowspan="5" class="text-lg pr-4 border-r">Assurance</th>
                        <td class="font-semibold text-right px-2">Compagnie</td>
                        <td>{{ ($patient->contrats->last()->assurance != '') ? $patient->contrats->last()->assurance : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Matricule</td>
                        <td>{{ ($patient->contrats->last()->matricule != '') ? $patient->contrats->last()->matricule : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Employeur</td>
                        <td>{{ ($patient->contrats->last()->emplyeur != '') ? $patient->contrats->last()->emplyeur : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Profession</td>
                        <td>{{ ($patient->profession != '') ? $patient->profession : '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 font-semibold text-right px-2">couverture</td>
                        <td class="pb-2">{{ ($patient->contrats->last()->taux_couvert != 0) ? $patient->contrats->last()->taux_couvert . ' %' : '-' }}</td>
                    </tr>

                    <tr>
                        <th rowspan="5" class="text-lg pr-4 border-r">Relation cabinet</th>
                        <td class="font-semibold text-right px-2">Visites</td>
                        <td>{{ $patient->visites->count() }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Dernière</td>
                        <td>{{ ($patient->visites->count() > 0) ? Carbon\Carbon::createFromDate($patient->visites->sortByDesc('date')->values()->all()[0]->date)->locale('fr')->isoFormat('Do MMMM YYYY') : 'RAS' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Prochain rdv</td>
                        <td>{{ ($patient->rdvs->count() > 0) ? Carbon\Carbon::createFromDate($patient->rdvs->sortByDesc('date')->values()->all()[0]->date)->locale('fr')->isoFormat('Do MMMM YYYY') : 'RAS' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Dépense</td>
                        <td>{{ $patient->depense() }} FCFA</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-right px-2">Dette</td>
                        <td>{{ $patient->dette() }} FCFA</td>
                    </tr>
                </table>
            </div>

            <div class="mb-8 flex items-center sm:hidden md:block">
                <table class="mx-auto w-full">
                    <tr class="text-lg">
                        <th colspan="2">Informations personnelles</th>
                        <th class="text-left pl-4">.</th>
                        <th colspan="2">Assurance</th>
                        <th class="text-left pl-4">.</th>
                        <th colspan="2">Relation cabinet</th>
                    </tr>
                    <tr>
                        <td class="w-1-8/12 pr-1 text-right font-semibold">Date de naissance</td>
                        <td class="w-1-8/12 pl-1 text-left">{{ Carbon\Carbon::createFromDate($patient->date_nais)->locale('fr')->isoFormat('Do MMM YYYY') . ' (' . $patient->age() . ' ans)' }}</td>
                        <td class="px-4">.</td>
                        <td class="w-1-8/12 pr-1 text-right font-semibold">Compagnie</td>
                        <td class="w-1-8/12 pl-1 text-left">{{ ($patient->contrats->last()->assurance != '') ? $patient->contrats->last()->assurance : '-' }}</td>
                        <td class="px-4">.</td>
                        <td class="w-1-8/12 pr-1 text-right font-semibold">Nombre de visites</td>
                        <td class="w-1-8/12 pl-1 text-left">{{ $patient->visites->count() }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1 text-right font-semibold">Lieu</td>
                        <td class="pl-1 text-left">{{ ($patient->lieu_nais != '') ? $patient->lieu_nais : '-' }}</td>
                        <td class="px-4">.</td>
                        <td class="pr-1 text-right font-semibold">Matricule</td>
                        <td class="pl-1 text-left">{{ ($patient->contrats->last()->matricule != '') ? $patient->contrats->last()->matricule : '-' }}</td>
                        <td class="px-4">.</td>
                        <td class="pr-1 text-right font-semibold">Dernière visite</td>
                        <td class="pl-1 text-left">{{ ($patient->visites->count() > 0) ? Carbon\Carbon::createFromDate($patient->visites->sortByDesc('date')->values()->all()[0]->date)->locale('fr')->isoFormat('Do MMMM YYYY') : 'RAS' }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1 text-right font-semibold">Sexe</td>
                        <td class="pl-1 text-left">{{ $patient->sexe == 'M' ? 'Masculin' : 'Féminin' }}</td>
                        <td class="px-4">.</td>
                        <td class="pr-1 text-right font-semibold">Employeur</td>
                        <td class="pl-1 text-left">{{ ($patient->contrats->last()->employeur != '') ? $patient->contrats->last()->employeur : '-' }}</td>
                        <td class="px-4">.</td>
                        <td class="pr-1 text-right font-semibold">Prochain rdv</td>
                        <td class="pl-1 text-left">{{ ($patient->rdvs->count() > 0) ? Carbon\Carbon::createFromDate($patient->rdvs->sortByDesc('date')->values()->all()[0]->date)->locale('fr')->isoFormat('Do MMMM YYYY') : 'RAS' }}</td>
                    </tr>
                    <tr>
                        <td class="pr-1 text-right font-semibold">Téléphone</td>
                        <td class="pl-1 text-left">{{ ($patient->tel != '') ? $patient->tel : '-' }}</td>
                        <td class="px-4">.</td>
                        <td class="pr-1 text-right font-semibold">Profession</td>
                        <td class="pl-1 text-left">{{ ($patient->profession != '') ? $patient->profession : '-' }}</td>
                        <td class="px-4">.</td>
                        <td class="pr-1 text-right font-semibold">Dépense</td>
                        <td class="pl-1 text-left">{{ $patient->depense() }} FCFA</td>
                    </tr>
                    <tr>
                        <td class="pr-1 text-right font-semibold">Mail</td>
                        <td class="pl-1 text-left">{{ ($patient->email != '') ? $patient->email : '-' }}</td>
                        <td class="px-4">.</td>
                        <td class="pr-1 text-right font-semibold">Taux de couverture</td>
                        <td class="pl-1 text-left">{{ ($patient->contrats->last()->taux_couvert != 0) ? $patient->contrats->last()->taux_couvert . ' %' : '-' }}</td>
                        <td class="px-4">.</td>
                        <td class="pr-1 text-right font-semibold">Dette</td>
                        <td class="pl-1 text-left">{{ $patient->dette() }} FCFA</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <hr>

        <div class="my-10">
            <h1 class="mb-8 text-2xl text-center font-semibold">Etat général</h1>
            
            @php $n = $antecedents->count() @endphp
            <div class="md:text-sm sm:text-xs-sm font-medium md:flex md:justify-between">
                <div class="">
                    <table class="sm:w-full md:w-auto">
                        @for ($i = 0; $i < $n / 2; $i++)
                        <tr class="hover:bg-gray-200">
                            <td class="text-right sm:w-7/12 md:w-auto"><label for="etat_{{$i}}">{{ $antecedents[$i]->categorie ?? '' }}</label></td>
                            <td class="px-1 sm:w-5/12 md:w-auto"><label for="etat_{{$i}}">{{ $antecedents[$i]->libelle ?? '' }}</label></td>
                            @if ($etats->where('id_antecedent', $i+1)->count() == 0)
                            <td><x-jet-checkbox class="my-1" wire:click="modif_etat({{$i}})" id="etat_{{$i}}" /></td>
                            @else
                            <td><x-jet-checkbox class="my-1" wire:click="modif_etat({{$i}})" id="etat_{{$i}}" checked /></td>
                            @endif
                        </tr>
                        @endfor
                    </table>
                </div>
                <div class="">
                    <table class="sm:w-full md:w-auto">
                        @for ($j = $i; $j < $n - 1; $j++)
                        <tr class="hover:bg-gray-200">
                            <td class="text-right sm:w-7/12 md:w-auto"><label for="etat_{{$j}}">{{ $antecedents[$j]->categorie ?? '' }}</label></td>
                            <td class="px-1 sm:w-5/12 md:w-auto"><label for="etat_{{$j}}">{{ $antecedents[$j]->libelle ?? '' }}</label></td>
                            @if ($etats->where('id_antecedent', $j+1)->count() == 0)
                            <td><x-jet-checkbox class="my-1" wire:click="modif_etat({{$j}})" id="etat_{{$j}}" /></td>
                            @else
                            <td><x-jet-checkbox class="my-1" wire:click="modif_etat({{$j}})" id="etat_{{$j}}" checked /></td>
                            @endif
                        </tr>
                        @endfor
                    </table>
                </div>
            </div>

            <div class="flex flex-col items-center text-sm">
                <textarea class="w-8/12 mt-6 rounded shadow" wire:model="commentaire" placeholder="Commentaires"></textarea>
                
                <div class="mt-8">
                    <x-jet-button wire:click="modifierEtat">Mettre à jour</x-jet-button>

                    @if (session()->has('etat_maj'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 mt-5 ml-5 bg-green-500 text-green-200 text-sm rounded shadow">
                        {{ session('etat_maj') }}
                    </span>
                    @endif
                    @if (session()->has('etat_non_maj'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 mt-5 ml-5 bg-red-500 text-white text-sm rounded shadow">
                        {{ session('etat_non_maj') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @if ($choix_action == 'dossier')
    <div class="sm:px-16 my-12">
        <select class="bg-white border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="choix_action">
            <option class="bg-white" value="dossier">Dossier</option>
            <option class="bg-white" value="consultation">Consultation</option>
            <option class="bg-white" value="operation">Traitement</option>
            <option class="bg-white" value="reglement">Règlement</option>
        </select>
    </div>
    @endif

    @if ($choix_action == 'dossier')
    <livewire:visites :patientId="$patient->id" />
    @endif

    @if ($choix_action == 'consultation')
    <livewire:consultations :patientId="$patient->id" />
    @endif

    @if ($choix_action == 'operation')
    @livewire('operations', ['patientId' => $patient->id, 'date' => date('Y-m-d')])
    @endif

    @if ($choix_action == 'reglement')
    <livewire:reglements :patientId="$patient->id" />
    @endif

</div>
