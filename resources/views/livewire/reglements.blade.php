@if ($factures->count() > 0)
<div>
    <div class="px-8 py-2 bg-white rounded-md my-12">
        <div class="my-8 flex flex-col justify-center">
            <h1 class="text-2xl text-center font-semibold mb-8">Règlements</h1>

            <table class="text-sm mb-8 mx-auto">
                <tr>
                    <th class="md:table-cell sm:hidden py-1 pr-2">DATE</th>
                    <th class="md:table-cell sm:hidden w-18 py-1 px-2">TOTAL</th>
                    <th class="md:table-cell sm:hidden w-18 py-1 pl-2 pr-3">REMISE</th>
                    <th class="md:table-cell sm:hidden w-18 py-1 pl-3 py-1 pr-2 bg-gray-200">NAP</th>
                    <th class="md:table-cell sm:hidden w-18 py-1 px-2 bg-gray-200">ASSUR</th>
                    <th class="md:table-cell sm:hidden w-18 py-1 pl-2 pr-3 bg-gray-200">PATIENT</th>
                    <th class="md:table-cell sm:hidden w-18 py-1 pl-3 py-1 pr-2">REGLE</th>
                    <th class="md:table-cell sm:hidden w-18 py-1 px-2">ASSUR</th>
                    <th class="md:table-cell sm:hidden w-18 py-1 pl-2 pr-3">PATIENT</th>
                    <th class="w-18 py-1 pl-3 py-1 pr-2 bg-gray-200">RAP</th>
                    <th class="w-18 py-1 px-2 bg-gray-200">ASSUR</th>
                    <th class="w-18 py-1 pl-2 pr-3 bg-gray-200">PATIENT</th>
                    <th class="w-18 py-1 pl-3 py-1 pr-2">ASSUR</th>
                    <th class="w-18 py-1 px-2">PATIENT</th>
                    <th></th>
                </tr>
                @php
                $i = 0;

                foreach ($factures as $facture) {                
                    $NAP = round($facture->total * (1 - $facture->remise / 100));
                    $NAP_assureur = round($NAP * $patient->contrats->last()->taux_couvert / 100);
                    $NAP_patient = $NAP - $NAP_assureur;
                    $regle = 0;
                    $regle_assureur = 0;
                    $regle_patient = 0;
                    $reglements = $facture->reglements;
                

                    if ($reglements->count() > 0) {
                        foreach ($reglements as $reglement) {
                            $regle += $reglement->montant;
                            
                            if ($reglement->auteur == 'assureur') {
                                $regle_assureur += $reglement->montant;
                            } elseif ($reglement->auteur == 'assure') {
                                $regle_patient += $reglement->montant;
                            }
                        }
                    }
                @endphp
                <tr class="hover:bg-gray-200">
                    <td class="md:table-cell sm:hidden py-1 pr-2 text-center">{{ $facture->visite->date }}</td>
                    <td class="md:table-cell sm:hidden w-18 py-1 px-2 text-right">{{ number_format($facture->total, 0, '', ' ') }}</td>
                    <td class="md:table-cell sm:hidden w-18 py-1 pl-2 pr-3 text-right">{{ $facture->remise }} %</td>
                    <td class="md:table-cell sm:hidden w-18 py-1 pr-2 py-1 pl-3 bg-gray-200 text-right">{{ number_format($NAP, 0, '', ' ') }}</td>
                    <td class="md:table-cell sm:hidden w-18 py-1 px-2 bg-gray-200 text-right">{{ number_format($NAP_assureur, 0, '', ' ') }}</td>
                    <td class="md:table-cell sm:hidden w-18 py-1 pl-2 pr-3 bg-gray-200 text-right">{{ number_format($NAP_patient, 0, '', ' ') }}</td>
                    <td class="md:table-cell sm:hidden w-18 py-1 pl-3 py-1 pr-2 text-right">{{ number_format($regle, 0, '', ' ') }}</td>
                    <td class="md:table-cell sm:hidden w-18 py-1 px-2 text-right">{{ number_format($regle_assureur, 0, '', ' ') }}</td>
                    <td class="md:table-cell sm:hidden w-18 py-1 pl-2 pr-3 text-right">{{ number_format($regle_patient, 0, '', ' ') }}</td>
                    <td class="w-18 py-1 pl-3 py-1 pr-2 bg-gray-200 text-right">{{ number_format($NAP - $regle, 0, '', ' ') }}</td>
                    <td class="w-18 py-1 px-2 bg-gray-200 text-right">{{ number_format($NAP_assureur - $regle_assureur, 0, '', ' ') }}</td>
                    <td class="w-18 py-1 pl-2 pr-3 bg-gray-200 text-right">{{ number_format($NAP_patient - $regle_patient, 0, '', ' ') }}</td>
                    <td class="w-18 py-1 pl-3 py-1 pr-2">
                        <x-jet-input class="w-18 p-1 text-xs" type="number" wire:model="reglements.assur.{{$i}}" min="0" max="{{ $NAP_assureur - $regle_assureur }}" />
                    </td>
                    <td class="w-18 py-1 px-2">
                        <x-jet-input class="w-18 p-1 text-xs" type="number" wire:model="reglements.patient.{{$i}}" min="0" max="{{ $NAP_patient - $regle_patient }}" />
                    </td>
                    <td class="py-1 pl-2">
                        <button type="submit" class="inline-flex items-center p-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" wire:click="validerReglement({{$facture->id}})">VALIDER</button>
                    </td>
                </tr>
                @php
                $i++;
                }
                @endphp
            </table>

            <x-jet-button class="mx-auto"><a href="">Terminer</a></x-jet-button>
        </div>
    </div>
</div>
@else
<div class="sm:px-16 py-8 bg-white rounded-md my-12 flex justify-center">
    <h1 class="text-2xl font-semibold mr-10">Aucune facture non réglée</h1>
    <x-jet-button><a href="">Retour</a></x-jet-button>
</div>
@endif