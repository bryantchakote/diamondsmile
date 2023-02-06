        <div class="py-12">
            <div class="flex justify-center border-b-2 pb-5">
                <img class="block h-20 w-auto" src="/images/logo.png" alt="logo">
                <div class="text-center ml-2">
                    <p class="font-semibold uppercase text-2xl">CABINET DENTAIRE "THE DIAMOND SMILE"</p>
                    <p>B.P: 19043 Yaoundé. Tél: (+237) 691 267 547 / 675 550 607</p>
                    <p>Email: clementtchouassi@yahoo.fr</p>
                </div>
            </div>

            <div class="flex justify-center">
                <div class="w-1/5 text-center pt-5">
                    <p class="text-xl font-semibold mb-5">DOCTEUR</p>
                    <p class="text-lg font-semibold mb-8">TCHEUGOUE TCHOUASSI Clément</p>
                    <p class="text-sm mb-5 font-medium">Chirurgien - Dentiste</p>
                    <p class="text-xs mb-3">Certificat d'études supérieures des biomatériaux utilisés en arts dentaires</p>
                    <p class="text-xs mb-3">Certificat d'études supérieures de prothèse fixée</p>
                    <p class="text-xs">Diplôme universitaire des bases fondamentales en implantologie orale</p>
                </div>

                <div class="text-center border-l-2 ml-3 pl-3 pt-3">
                    <div>
                        <div class="flex justify-between mb-4">
                            <div>
                                <p class="text-sm text-left"><span class="font-medium">NUMERO ASSURE : </span>{{ $patient->contrats->last()->matricule ?? '' }}</p>
                                <p class="text-sm text-left"><span class="font-medium">TAUX DE COUVERTURE : </span>{{ $patient->contrats->last()->taux_couvert ?? '' }} %</p>
                            </div>
                            <div>
                                <p class="text-sm text-right"><span class="font-medium">DATE : </span>{{ Carbon\Carbon::createFromDate($date)->locale('fr')->isoFormat('Do MMMM YYYY') }}</p>
                            </div>
                        </div>

                        <div class="font-semibold text-xl mb-4">
                            @php $date = Carbon\Carbon::create($date) @endphp
                            <p>{{ 'FACTURE' . ($proforma ? ' PROFORMA' : '') . ' DS-' . substr($date, 8, 2) . substr($date, 5, 2) . substr($date, 2, 2) . '-' . sprintf("%05d", $id_facture + 1)  }}</p>
                        </div>

                        <div class="text-left">
                            <p class="text-sm"><span class="font-medium">NOM ET PRENOM : </span>{{ $patient->nom }}</p>
                            <P class="text-sm"><span class="font-medium">DATE DE NAISSANCE : </span>{{ Carbon\Carbon::createFromDate($patient->date_nais)->locale('fr')->isoFormat('Do MMMM YYYY') }}</P>
                        </div>
                    </div>

                    <div class="flex flex-col mt-8 text-xs">
                        <table class="mb-6 mx-auto">
                            <tr class="border-b uppercase">
                                <th class="p-1">DENTS</th>
                                <th class="p-1">DENOMINATION DES ACTES</th>
                                <th class="p-1 w-6 text-right">CODE</th>
                                <th class="p-1 w-14 text-right">PRIX</th>
                                <th class="p-1 w-14 text-right">ASSUR.</th>
                                <th class="p-1 w-14 text-right">PATIENT</th>
                            </tr>
                            @php
                            $i = 1;
                            $total = 0;
                            $total_assureur = 0;
                            $total_patient = 0;
                            @endphp

                            @if ($plans != '')
                            @foreach ($plans as $plan)
                            @php
                            $prix = $plan->prix;
                            $prix_assureur = $prix * ($patient->contrats->last()->taux_couvert / 100);
                            $prix_patient = $prix - $prix_assureur;

                            $total += $prix;
                            $total_assureur += $prix_assureur;
                            $total_patient += $prix_patient;
                            @endphp
                            <tr class="border-b">
                                <td class="p-1 text-left align-top">{{ $plan->dents }}</td>
                                <td class="p-1 text-left align-top">{{ $plan->traitement->designation }}</td>
                                <td class="p-1 text-center align-top">
                                    @php $code = strval($plan->traitement->code) @endphp
                                    @if (substr($code, 0, 1) == 'D' || substr($code, 0, 1) == 'Z' || substr($code, 0, 2) == 'SC')
                                    {{ $code }}
                                    @endif
                                </td>
                                <td class="p-1 text-right align-top">{{ number_format($prix, 0, '', ' ') }}</td>
                                <td class="p-1 text-right align-top">{{ number_format($prix_assureur, 0, '', ' ') }}</td>
                                <td class="p-1 text-right align-top">{{ number_format($prix_patient, 0, '', ' ') }}</td>
                            </tr>
                            @endforeach
                            @endif
                            <tr class="border-b">
                                <td colspan="6"></td>
                            </tr>
                            <tr class="border-b">
                                <th colspan="3">TOTAL</th>
                                <td class="p-1 text-right">{{ number_format($total, 0, '', ' ') }}</td>
                                <td class="p-1 text-right">{{ number_format($total_assureur, 0, '', ' ') }}</td>
                                <td class="p-1 text-right">{{ number_format($total_patient, 0, '', ' ') }}</td>
                            </tr>
                            <tr class="border-b">
                                <th colspan="3">REMISE <x-jet-input type="text" class="p-0 rounded-none border-0 text-sm w-5 text-right" wire:model="remise" />%</th>
                                @php
                                $valeur_remise = is_numeric($remise) ? $remise : 0;
                                $total_remise = round($total * $valeur_remise / 100);
                                $total_assureur_remise = round($total_assureur * $valeur_remise / 100);
                                $total_patient_remise = $total_remise - $total_assureur_remise;
                                @endphp
                                <td class="p-1 text-right">- {{ number_format($total_remise, 0, '', ' ') }}</td>
                                <td class="p-1 text-right">- {{ number_format($total_assureur_remise, 0, '', ' ') }}</td>
                                <td class="p-1 text-right">- {{ number_format($total_patient_remise, 0, '', ' ') }}</td>
                            </tr>
                            <tr class="border-b">
                                <th colspan="3">NET A PAYER</th>
                                <td class="p-1 text-right">{{ number_format($total - $total_remise, 0, '', ' ') }}</td>
                                <td class="p-1 text-right">{{ number_format($total_assureur - $total_assureur_remise, 0, '', ' ') }}</td>
                                <td class="p-1 text-right">{{ number_format($total_patient - $total_patient_remise, 0, '', ' ') }}</td>
                            </tr>
                            <tr class="border-b">
                                <td colspan="6"></td>
                            </tr>                            
                        </table>

                        <div class="text-left pl-6 text-sm mb-6">
                            @php $f = new NumberFormatter("fr", NumberFormatter::SPELLOUT) @endphp
                            <p>Assureur doit : <span class="uppercase font-semibold">{{ $f->format($total_assureur - $total_assureur_remise) }} FCFA</span></p>
                            <p>Patient doit : <span class="uppercase font-semibold">{{ $f->format($total_patient - $total_patient_remise) }} FCFA</span></p>
                        </div>

                        <div class="flex-col">
                            <x-jet-button class="w-2 mx-20" wire:click="offProforma"></x-jet-button>
                            <x-jet-button class="w-10 mx-20 text-center opacity-25" wire:click="ajouterFacture">T</x-jet-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
