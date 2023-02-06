<div class="bg-tranparent">
    <div class="px-16 py-2 bg-white rounded-md shadow-xl">
        @if (count($anniversaires) > 0)
        <div class="my-10">
            <h1 class="mb-8 text-2xl text-center font-semibold">Anniversaires</h1>

            <div class="flex flex-col sm:justify-center items-center">
                <table class="mb-6 overflow-hidden">
                    <tr>
                        <th class="md:px-3 sm:px-1 py-1">#</th>
                        <th class="md:px-3 sm:px-1 py-1">Patient</th>
                        <th class="md:px-3 sm:px-1 py-1">Sexe</th>
                        <th class="md:px-3 sm:px-1 py-1">Date de naissance</th>
                        <th class="md:px-3 sm:px-1 py-1">Age</th>
                        <th class="md:px-3 sm:px-1 py-1">Tél</th>
                    </tr>
                    @php $i = 1 @endphp
                    @foreach($anniversaires as $anniversaire)
                    <tr class="hover:bg-gray-200">
                        <th class="md:px-3 sm:px-1 py-1">{{ $i }}</th> @php $i++ @endphp
                        <td class="md:px-3 sm:px-1 py-1 md:table-cell sm:hidden">{{ $anniversaire->nom }}</td>
                        <td class="md:px-3 sm:px-1 py-1 md:hidden sm:table-cell">{{ str_split($anniversaire->nom, 22)[0] }}</td>
                        <td class="md:px-3 sm:px-1 py-1 text-center">{{ $anniversaire->sexe }}</td>
                        <td class="md:px-3 sm:px-1 py-1 text-center">{{ Carbon\Carbon::createFromDate($anniversaire->date_nais)->locale('fr')->isoFormat('Do MMM YYYY') }}</td>
                        <td class="md:px-3 sm:px-1 py-1 text-right">{{ $anniversaire->age() . ' ans' }}</td>
                        <td class="md:px-3 sm:px-1 py-1 text-right">{{ $anniversaire->tel }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        
        <hr>
        @endif

        <div class="md:inline sm:hidden md:flex">
            <div class="my-10 md:w-6/12">
                <h1 class="mb-8 text-2xl text-center font-semibold">Patients</h1>

                <div class="flex justify-center font-semibold">
                    <div class="ml-3 flex items-center">
                        <p><span class="pr-2">Patients</span>{{ number_format($nbre_patients, 0, ',', ' ') }}</p>
                    </div>
                    <div class="mx-6">
                        <table>
                            <tr>
                                <td class="text-right pr-2">Hommes</td>
                                <td>{{ number_format($hommes, 0, ',', ' ') . ' (' . $freq_hommes . ' %)' }}</td>
                            </tr>
                            <tr>
                                <td class="text-right pr-2">Femmes</td>
                                <td>{{ number_format($femmes, 0, ',', ' ') . ' (' . $freq_femmes . ' %)' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="ml-3">
                        <table>
                            <tr>
                                <td class="text-right pr-2">Assurés</td>
                                <td>{{ number_format($assures, 0, ',', ' ') . ' (' . $freq_assures . ' %)' }}</td>
                            </tr>
                            <tr>
                                <td class="text-right pr-2">Non assurés</td>
                                <td>{{ number_format($non_assures, 0, ',', ' ') . ' (' . $freq_non_assures . ' %)' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-8">
                    <table class="mx-auto">
                        <tr>
                            <th class="py-1 px-2">Age</th>
                            <th class="py-1 px-2 border-l">< 5</th>
                            <th class="py-1 px-2 border-l">5 - 15</th>
                            <th class="py-1 px-2 border-l">15 - 25</th>
                            <th class="py-1 px-2 border-l">25 - 35</th>
                            <th class="py-1 px-2 border-l">35 - 45</th>
                            <th class="py-1 px-2 border-l">45 - 55</th>
                            <th class="py-1 px-2 border-l">> 55</th>
                        </tr>
                        <tr class="text-center border-t">
                            <td class="py-1 px-2 font-bold">Effectif</td>
                            <td class="py-1 px-2 border-l">{{ $ages['5'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['5-15'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['15-25'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['25-35'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['35-45'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['45-55'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['55'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="my-10 md:w-6/12 ml-2 border-l-4">
                <h1 class="mb-8 text-2xl text-center font-semibold">Rendez-vous imminents</h1>

                <table class="mx-auto">
                    <tr>
                        <th class="pr-2 py-1">Patient</th>
                        <th class="px-2 py-1">Tél</th>
                        <th class="px-2 py-1">Date</th>
                        <th class="pl-2 py-1">Motif</th>
                    </tr>
                    @if (count($rdvs) > 0)
                    @foreach($rdvs as $rdv)
                    @php
                    $date = now();
                    @endphp
                    <tr class="hover:bg-gray-200">
                        <td class="pr-2 py-1">{{ str_split($rdv->patient->nom, 22)[0] }}</td>
                        <td class="px-2 py-1 text-right">{{ $rdv->patient->tel }}</td>
                        <td class="px-2 py-1 text-right">{{ Carbon\Carbon::createFromDate($rdv->date)->locale('fr')->isoFormat('Do MMM YYYY') }}</td>
                        <td class="pl-2 py-1">{{ str_split($rdv->motif, 7)[0] . '.' }}</td>
                    </tr>
                    @endforeach
                    @endif
                </table>
            </div>
        </div>

        <div class="md:hidden sm:inline">
            <div class="my-10 sm:w-full">
                <h1 class="mb-8 text-2xl text-center font-semibold">Patients</h1>

                <div class="flex justify-center font-semibold text-lg">
                    <div class="ml-3 flex items-center">
                        <p><span class="pr-2">Patients</span>{{ number_format($nbre_patients, 0, ',', ' ') }}</p>
                    </div>
                    <div class="mx-6">
                        <table>
                            <tr>
                                <td class="text-right pr-2">Hommes</td>
                                <td>{{ number_format($hommes, 0, ',', ' ') . ' (' . $freq_hommes . ' %)' }}</td>
                            </tr>
                            <tr>
                                <td class="text-right pr-2">Femmes</td>
                                <td>{{ number_format($femmes, 0, ',', ' ') . ' (' . $freq_femmes . ' %)' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="ml-3">
                        <table>
                            <tr>
                                <td class="text-right pr-2">Assurés</td>
                                <td>{{ number_format($assures, 0, ',', ' ') . ' (' . $freq_assures . ' %)' }}</td>
                            </tr>
                            <tr>
                                <td class="text-right pr-2">Non assurés</td>
                                <td>{{ number_format($non_assures, 0, ',', ' ') . ' (' . $freq_non_assures . ' %)' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-8">
                    <table class="mx-auto">
                        <tr>
                            <th class="py-1 px-2">Age</th>
                            <th class="py-1 px-2 border-l">< 5</th>
                            <th class="py-1 px-2 border-l">5 - 15</th>
                            <th class="py-1 px-2 border-l">15 - 25</th>
                            <th class="py-1 px-2 border-l">25 - 35</th>
                            <th class="py-1 px-2 border-l">35 - 45</th>
                            <th class="py-1 px-2 border-l">45 - 55</th>
                            <th class="py-1 px-2 border-l">> 55</th>
                        </tr>
                        <tr class="text-center border-t">
                            <td class="py-1 px-2 font-bold">Effectif</td>
                            <td class="py-1 px-2 border-l">{{ $ages['5'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['5-15'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['15-25'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['25-35'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['35-45'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['45-55'] }}</td>
                            <td class="py-1 px-2 border-l">{{ $ages['55'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <div class="my-10 sm:w-full">
                <h1 class="mb-8 text-2xl text-center font-semibold">Rendez-vous imminents</h1>

                <table class="mx-auto">
                    <tr>
                        <th class="pr-2 py-1">Patient</th>
                        <th class="px-2 py-1">Tél</th>
                        <th class="px-2 py-1">Date</th>
                        <th class="pl-2 py-1">Motif</th>
                    </tr>
                    @foreach($rdvs as $rdv)
                    @php
                    $date = now();
                    @endphp
                    <tr class="hover:bg-gray-200">
                        <td class="pr-2 py-1">{{ str_split($rdv->patient->nom, 22)[0] }}</td>
                        <td class="px-2 py-1 text-right">{{ $rdv->patient->tel }}</td>
                        <td class="px-2 py-1 text-right">{{ Carbon\Carbon::createFromDate($rdv->date)->locale('fr')->isoFormat('Do MMM YYYY') }}</td>
                        <td class="pl-2 py-1">{{ str_split($rdv->motif, 7)[0] . '.' }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <hr>

        <div class="md:inline sm:hidden md:flex">
            <div class="my-10 md:w-4/12">
                <h1 class="mb-8 text-2xl text-center font-semibold">Traitements</h1>

                <table class="mx-auto font-semibold text-lg">
                    <tr>
                        <td class="text-right pr-2">Traitements prescrits</td>
                        <td>{{ number_format($nb_plans, 0, ',', ' ') }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">Traitements confirmés</td>
                        <td>{{ number_format($nb_plans_conf, 0, ',', ' ') . ' (' . $freq_plans_conf . ' %)' }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">Traitements terminés</td>
                        <td>{{ number_format($nb_plans_term, 0, ',', ' ') . ' (' . $freq_plans_term . ' %)' }}</td>
                    </tr>
                </table>
            </div>

            <div class="my-10 md:w-8/12 ml-2 border-l-4">
                <h1 class="mb-8 text-2xl text-center font-semibold">Divers</h1>

                <div class="flex flex-col text-lg font-semibold">
                    <div class="flex justify-center items-top">
                        <div class="flex items-center">
                            <p class="mr-2">Période allant du</p>
                            <x-jet-input type="date" wire:model="debut" wire:change="modif" min="{{ App\Models\Visite::oldest('date')->first()->date ?? date('Y-m-d') }}" max="{{ $fin }}" />
                        </div>
                        <div class="ml-4 flex items-center">
                            <p class="mr-2">au</p>
                            <x-jet-input type="date" wire:model="fin" wire:change="modif" min="{{ $debut }}" max="{{ date('Y-m-d') }}" />
                        </div>
                    </div>

                    <table class="mt-6 mx-auto font-semibold text-lg">
                        <tr>
                            <td class="text-right pr-2">Chiffre d'affaires</td>
                            <td>{{ number_format($CA, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td class="text-right pr-2">Factures non reglées</td>
                            <td>{{ number_format($dette, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td class="text-right pr-2">Visites</td>
                            <td>{{ number_format($visites_periode->count(), 0, ',', ' ') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right pr-2">Consultations</td>
                            <td>{{ number_format($visites_periode->where('motif', 'consultation')->count(), 0, ',', ' ') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right pr-2">Traitements</td>
                            <td>{{ number_format($visites_periode->where('motif', 'traitement')->count(), 0, ',', ' ') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="md:hidden sm:inline">
            <div class="my-10 sm:w-full">
                <h1 class="mb-8 text-2xl text-center font-semibold">Traitements</h1>

                <table class="mx-auto font-semibold text-lg">
                    <tr>
                        <td class="text-right pr-2">Traitements prescrits</td>
                        <td>{{ number_format($nb_plans, 0, ',', ' ') }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">Traitements confirmés</td>
                        <td>{{ number_format($nb_plans_conf, 0, ',', ' ') . ' (' . $freq_plans_conf . ' %)' }}</td>
                    </tr>
                    <tr>
                        <td class="text-right pr-2">Traitements terminés</td>
                        <td>{{ number_format($nb_plans_term, 0, ',', ' ') . ' (' . $freq_plans_term . ' %)' }}</td>
                    </tr>
                </table>
            </div>

            <hr>

            <div class="my-10 sm:w-full">
                <h1 class="mb-8 text-2xl text-center font-semibold">Divers</h1>

                <div class="flex flex-col text-lg font-semibold">
                    <div class="flex justify-center items-top">
                        <div class="flex items-center">
                            <p class="mr-2">Période allant du</p>
                            <x-jet-input type="date" wire:model="debut" wire:change="modif" min="{{ App\Models\Visite::oldest('date')->first()->date ?? date('Y-m-d') }}" max="{{ $fin }}" />
                        </div>
                        <div class="ml-4 flex items-center">
                            <p class="mr-2">au</p>
                            <x-jet-input type="date" wire:model="fin" wire:change="modif" min="{{ $debut }}" max="{{ date('Y-m-d') }}" />
                        </div>
                    </div>

                    <table class="mt-6 mx-auto font-semibold text-lg">
                        <tr>
                            <td class="text-right pr-2">Chiffre d'affaires</td>
                            <td>{{ number_format($CA, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td class="text-right pr-2">Factures non reglées</td>
                            <td>{{ number_format($dette, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td class="text-right pr-2">Visites</td>
                            <td>{{ number_format($visites_periode->count(), 0, ',', ' ') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right pr-2">Consultations</td>
                            <td>{{ number_format($visites_periode->where('motif', 'consultation')->count(), 0, ',', ' ') }}</td>
                        </tr>
                        <tr>
                            <td class="text-right pr-2">Traitements</td>
                            <td>{{ number_format($visites_periode->where('motif', 'traitement')->count(), 0, ',', ' ') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <hr>

        <div class="my-10">
            <h1 class="mb-8 text-2xl text-center font-semibold">Antécédents</h1>

            @php $n = $antecedents->count() @endphp
            <div class="md:flex md:justify-between text-sm font-semibold sm:hidden md:block">
                <table>
                    @for ($i = 0; $i < $n / 2; $i++)
                    <tr class="hover:bg-gray-200">
                        <td class="text-right"><label for="etat_{{$i}}">{{ !is_null($antecedents[$i]->categorie) ? $antecedents[$i]->categorie : '' }}</label></td>
                        <td class="px-1"><label for="etat_{{$i}}">{{ !is_null($antecedents[$i]->libelle) ? $antecedents[$i]->libelle : '' }}</label></td>
                        <td class="pl-2">{{ number_format(App\Models\Etat::where('id_antecedent', $antecedents[$i]->id)->count(), 0, ',', ' ') }}</td>
                    </tr>
                    @endfor
                </table>
                <table>
                    @for ($j = $i; $j < $n - 1; $j++)
                    <tr class="hover:bg-gray-200">
                        <td class="text-right"><label for="etat_{{$j}}">{{ !is_null($antecedents[$j]->categorie) ? $antecedents[$j]->categorie : '' }}</label></td>
                        <td class="px-1"><label for="etat_{{$j}}">{{ !is_null($antecedents[$j]->libelle) ? $antecedents[$j]->libelle : '' }}</label></td>
                        <td class="pl-2">{{ number_format(App\Models\Etat::where('id_antecedent', $antecedents[$j]->id)->count(), 0, ',', ' ') }}</td>
                    </tr>
                    @endfor
                </table>
            </div>

            @php $n = $antecedents->count() @endphp
            <div class="sm:flex sm:justify-between text-xs-sm font-semibold sm:block md:hidden">                
                <table>
                    @for ($i = 0; $i < $n / 2; $i++)
                    <tr class="hover:bg-gray-200">
                        <td class="text-right"><label for="etat_{{$i}}">{{ !is_null($antecedents[$i]->categorie) ? $antecedents[$i]->categorie : '' }}</label></td>
                        <td class="px-1"><label for="etat_{{$i}}">{{ !is_null($antecedents[$i]->libelle) ? $antecedents[$i]->libelle : '' }}</label></td>
                        <td class="pl-2">{{ number_format(App\Models\Etat::where('id_antecedent', $antecedents[$i]->id)->count(), 0, ',', ' ') }}</td>
                    </tr>
                    @endfor
                    @for ($j = $i; $j < $n - 1; $j++)
                    <tr class="hover:bg-gray-200">
                        <td class="text-right"><label for="etat_{{$j}}">{{ !is_null($antecedents[$j]->categorie) ? $antecedents[$j]->categorie : '' }}</label></td>
                        <td class="px-1"><label for="etat_{{$j}}">{{ !is_null($antecedents[$j]->libelle) ? $antecedents[$j]->libelle : '' }}</label></td>
                        <td class="pl-2">{{ number_format(App\Models\Etat::where('id_antecedent', $antecedents[$j]->id)->count(), 0, ',', ' ') }}</td>
                    </tr>
                    @endfor
                </table>
            </div>
        </div>
    </div>
</div>
