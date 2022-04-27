<div>
    @php $a = $i = 0 @endphp
    @foreach ($visites as $visite)
    @if (!is_null($visite->consultation))
    @php
        $consultation = $visite->consultation;
        $exams = App\Models\Examen::where('id_cons', $consultation->id);
        $prescs = App\Models\Prescription::where('id_visite', App\Models\Consultation::find($consultation->id)->visite->id);
        $plans = App\Models\Plan::where('id_cons', $consultation->id);
    @endphp

    @if (!(is_null($consultation->medocs_en_cours) && is_null($consultation->observations) && $exams->count() == 0 && $prescs->count() == 0 && $plans->count() == 0))
    <div class="px-8 py-2 bg-white rounded-md my-12">
        <div class="my-4">
            <div>
                <div class="flex mb-4 text-sm cursor-pointer" wire:click="openDiv({{ $visite->id }})">
                    <table class="md:w-2/12 sm:w-3/12 flex flex-col sm:mr-0 md:mr-0">
                        <tr class="align-top">
                            <td class="font-semibold px-1 text-right">Date</td>
                            <td class="px-1">{{ Carbon\Carbon::createFromDate($visite->date)->locale('fr')->isoFormat('Do MMM YYYY') }}</td>
                        </tr>
                        <tr class="align-top">
                            <td class="font-semibold px-1 text-right">Motif</td>
                            <td class="px-1">Consultation</td>
                        </tr>
                    </table>

                    <table class="md:w-10/12 sm:w-9/12 flex flex-col">
                        <tr class="">
                            <td class="font-semibold px-1 text-right align-top w-40">Médicaments en cours</td>
                            @if (!is_null($consultation->medocs_en_cours))
                            <td class="px-1">{{ $consultation->medocs_en_cours }}</td>
                            @endif
                        </tr>
                        <tr class="">
                            <td class="font-semibold px-1 text-right align-top w-40">Observations</td>
                            @if (!is_null($consultation->observations))
                            <td class="px-1">{{ $consultation->observations }}</td>
                            @endif
                        </tr>
                        
                    </table>
                </div>

                @if ($showDiv[$visite->id])
                @php
                $exam_denture = 0;
                $adulte = 1;

                for ($o = 0; $o < 8; $o++) {
                    for ($p = 0; $p < 8; $p++) {
                        for ($q = 0; $q < 6; $q++) {
                            if ($denture[$a][$o][$p][$q]) {
                                $exam_denture = 1;
                                if ($o >= 4) $adulte = 0;
                                break(3);
                            }
                        }
                    }
                }

                $exam_paradontal = 0;

                for ($o = 0; $o < 4; $o++) {
                    for ($p = 0; $p < 8; $p++) {
                        for ($q = 0; $q < 4; $q++) {
                            if ($paradontal[$a][$o][$p][$q]) {
                                $exam_paradontal = 1;
                                break(3);
                            }
                        }
                    }
                }
                @endphp

                @if ($exam_denture || $exam_paradontal)
                <hr>

                <div class="mt-4 mb-6">
                    <h1 class="mb-2 text-xl text-center font-semibold">Examens</h1>

                    @if ($exam_denture)
                    <div class="mb-4">
                        <h2 class="my-2 text-lg font-semibold">Examen de la denture</h2>

                        <div class="flex-col">
                            @if ($adulte)
                            @for ($i = 1; $i <= 2; $i++)
                            <div class="md:flex justify-between mb-2">
                                @for ($j = 1; $j <= 2; $j++)
                                <div class="flex justify-between">
                                    @for ($k = 1; $k <= 8; $k++)
                                    <table class="mx-2">
                                        @php
                                        if ($i == 1)
                                            if ($j == 1) $bloc = 1;
                                            else $bloc = 2;
                                        else
                                            if ($j == 1) $bloc = 4;
                                            else $bloc = 3;
                                        $dent = ($j == 1) ? (9 - $k) : $k;
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <td class="h-3 w-4 p-0 text-center">@php echo $bloc . $dent @endphp</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            @if ($denture[$a][$bloc-1][$dent-1][0] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            @if ($denture[$a][$bloc-1][$dent-1][1] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            <td></td>
                                        </tr>
                                        <tr>
                                            @if ($denture[$a][$bloc-1][$dent-1][2] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            @if ($denture[$a][$bloc-1][$dent-1][3] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            @if ($denture[$a][$bloc-1][$dent-1][4] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td></td>
                                            @if ($denture[$a][$bloc-1][$dent-1][5] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            <td></td>
                                        </tr>
                                    </table>
                                    @endfor
                                </div>
                                @endfor
                            </div>
                            @endfor

                            @else
                            
                            @for ($i = 3; $i <= 4; $i++)
                            <div class="md:flex justify-between mb-2">
                                @for ($j = 1; $j <= 2; $j++)
                                <div class="flex justify-between">
                                    @for ($k = 1; $k <= 8; $k++)
                                    <table class="mx-2">
                                        @php
                                        if ($i == 3)
                                            if ($j == 1) $bloc = 5;
                                            else $bloc = 6;
                                        else
                                            if ($j == 1) $bloc = 8;
                                            else $bloc = 7;
                                        $dent = ($j == 1) ? (9 - $k) : $k;
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <td class="h-3 w-4 p-0 text-center">@php echo $bloc . $dent @endphp</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            @if ($denture[$a][$bloc-1][$dent-1][0] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            @if ($denture[$a][$bloc-1][$dent-1][1] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            <td></td>
                                        </tr>
                                        <tr>
                                            @if ($denture[$a][$bloc-1][$dent-1][2] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            @if ($denture[$a][$bloc-1][$dent-1][3] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            @if ($denture[$a][$bloc-1][$dent-1][4] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td></td>
                                            @if ($denture[$a][$bloc-1][$dent-1][5] == 0)
                                            <td class="border h-3 w-4 p-0"></td>
                                            @else
                                            <td class="border h-3 w-4 p-0 bg-blue-500"></td>
                                            @endif
                                            <td></td>
                                        </tr>
                                    </table>
                                    @endfor
                                </div>
                                @endfor
                            </div>
                            @endfor
                            @endif
                        </div>
                    </div>
                    @endif

                    @if ($exam_paradontal)
                    <div class="mb-4">
                        <h2 class="my-2 text-lg font-semibold">Examen paradontal</h2>

                        <div class="flex-col">
                            @for ($i = 1; $i <= 2; $i++)
                            <div class="md:flex justify-between mb-2">
                                @for ($j = 1; $j <= 2; $j++)
                                <div class="flex justify-between">
                                    @for ($k = 1; $k <= 8; $k++)
                                    <table class="mx-1">
                                        @php
                                        if ($i == 1)
                                            if ($j == 1) $bloc = 1;
                                            else $bloc = 2;
                                        else
                                            if ($j == 1) $bloc = 4;
                                            else $bloc = 3;
                                        $dent = ($j == 1) ? (9 - $k) : $k;
                                        @endphp
                                        <tr class="flex justify-center">
                                            <td></td>
                                            <td class="mb-3 h-3 w-4 p-0">@php echo $bloc . $dent @endphp</td>
                                            <td></td>
                                        </tr>
                                        <tr class="flex items-center">
                                            <td class="flex m-0 w-5 p-0"></td>
                                            <td class="flex m-0 border w-5 p-0"><input type="text" class="p-0 text-xs w-full h-3 border-0 focus:border-0 text-blue-500 font-semibold" wire:model="paradontal.{{ $a }}.{{ $bloc - 1}}.{{ $dent -1 }}.0" disabled /></td>
                                            <td class="flex m-0 w-5 p-0"></td>
                                        </tr>
                                        <tr class="flex items-center">
                                            <td class="flex m-0 border w-5 p-0"><input type="text" class="p-0 text-xs w-full h-3 border-0 focus:border-0 text-blue-500 font-semibold" wire:model="paradontal.{{ $a }}.{{ $bloc - 1}}.{{ $dent -1 }}.1" disabled /></td>
                                            <td class="flex m-0 w-5 p-0"></td>
                                            <td class="flex m-0 border w-5 p-0"><input type="text" class="p-0 text-xs w-full h-3 border-0 focus:border-0 text-blue-500 font-semibold" wire:model="paradontal.{{ $a }}.{{ $bloc - 1}}.{{ $dent -1 }}.2" disabled /></td>
                                        </tr>
                                        <tr class="flex items-center">
                                            <td class="flex m-0 w-5 p-0"></td>
                                            <td class="flex m-0 border w-5 p-0"><input type="text" class="p-0 text-xs w-full h-3 border-0 focus:border-0 text-blue-500 font-semibold" wire:model="paradontal.{{ $a }}.{{ $bloc - 1}}.{{ $dent -1 }}.3" disabled /></td>
                                            <td class="flex m-0 w-5 p-0"></td>
                                        </tr>
                                    </table>
                                    @endfor
                                </div>
                                @endfor
                            </div>
                            @endfor
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                @php $prescs = $visite->prescriptions @endphp
                @php $plans = $visite->consultation->plans @endphp
                @if (count($prescs) > 0 || count($plans) > 0)
                <hr>

                <div class="flex text-sm mb-8 justify-between"> 
                    @if (count($prescs) > 0)

                    @if (count($plans) > 0)
                    <div class="w-1/3 pr-5 mr-5 border-r pt-4">
                    @else
                    <div class="w-full pt-4">
                    @endif
                        
                        <h1 class="mb-2 text-xl text-center font-semibold">Prescriptions</h1>
                        
                        <table class="w-full">
                            <tr class="border-b">
                                <th class="p-1 w-5/12 align-top">PRODUIT</th>
                                <th class="p-1 w-7/12 align-top">MODE D'EMPLOI</th>
                            </tr>
                            @foreach ($prescs as $presc)
                            <tr class="border-b">
                                <td class="p-1 w-5/12 align-top break-all">{{ $presc->produit }}</td>
                                <td class="p-1 w-7/12 align-top break-all">{{ $presc->mode_emploi }}</td>
                            </tr>
                            @endforeach
                        </table>
                        
                    </div>
                    @endif

                    @if (count($plans) > 0)

                    @if (count($prescs) > 0)
                    <div class="w-2/3 pt-4">
                    @else
                    <div class="w-full pt-4">
                    @endif
                    
                        <h1 class="mb-2 text-xl text-center font-semibold">Plan de traitement</h1>
                        
                        <table class="w-full">
                            <tr class="border-b">
                                <th class="p-1 w-60">TRAITEMENT</th>
                                <th class="p-1">DENTS</th>
                                <th class="p-1 w-64">DESCRIPTION</th>
                                <th class="p-1 w-20">DUREE</th>
                                <th class="p-1 w-6">C</th>
                                <th class="p-1 w-6">T</th>
                            </tr>
                            @foreach ($plans as $plan)
                            <tr class="border-b">
                                <td class="p-1 align-top break-all">{{ $plan->traitement->designation }}</td>
                                <td class="p-1 align-top">{{ $plan->dents }}</td>
                                <td class="p-1 align-top break-all">{{ $plan->desc }}</td>
                                <td class="p-1 align-top">{{ $plan->duree }}</td>
                                <td class="p-1 align-top text-center">
                                    @if ($plan->confirme)
                                    <x-jet-checkbox class="my-1" checked disabled />
                                    @else
                                    <x-jet-checkbox class="my-1" disabled />
                                    @endif
                                </td>
                                <td class="p-1 align-top text-center">
                                    @if ($plan->confirme)
                                    @if ($plan->termine)
                                    <x-jet-checkbox class="my-1" checked disabled />
                                    @else
                                    <x-jet-checkbox class="my-1" disabled />
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        
                    </div>
                    @endif
                </div>
                @endif
                @endif
            </div>
            
        </div>
    </div>
    @endif
    @php $a++ @endphp
    @endif

    @php $prescs = (App\Models\Visite::find($visite->id)->motif == 'traitement') ? App\Models\Prescription::where('id_visite', $visite->id)->get() : null @endphp
    @if ((count($visite->operations) > 0) || (!is_null($prescs) && count($prescs) > 0))
    <div class="px-8 py-2 bg-white rounded-md my-12">
        <div class="my-4">            
            <div class="mb-4 text-sm cursor-pointer" wire:click="openDiv({{ $visite->id }})">
                <table class="w-1/4 flex flex-col items-top">
                    <tr>
                        <td class="font-semibold px-1 text-right">Date</td>
                        <td class="px-1">{{ Carbon\Carbon::createFromDate($visite->date)->locale('fr')->isoFormat('Do MMM YYYY') }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold px-1 text-right">Motif</td>
                        <td class="px-1">Traitement</td>
                    </tr>
                </table>
            </div>

            @if ($showDiv[$visite->id])
            <hr>
            <div class="flex">
                @if (!is_null($prescs) && count($prescs) > 0)

                @if (count($visite->operations) > 0)
                <div class="w-1/3 pr-5 mr-5 border-r">
                @else
                <div class="w-full">
                @endif
                    <div class="text-sm my-8 text-center">
                        <h1 class="mb-2 text-xl text-center font-semibold">Prescriptions</h1>
                                
                        <table class="mx-auto mt-4">
                            <tr class="border-b">
                                <th class="p-1 w-5/12 align-top">PRODUIT</th>
                                <th class="p-1 w-7/12 align-top">MODE D'EMPLOI</th>
                            </tr>
                            @foreach ($prescs as $presc)
                            <tr class="border-b">
                                <td class="p-1 w-5/12 align-top break-all">{{ $presc->produit }}</td>
                                <td class="p-1 w-7/12 align-top break-all">{{ $presc->mode_emploi }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @endif

                @if (count($visite->operations) > 0)

                @if (!is_null($prescs) && count($prescs) > 0)
                <div class="w-2/3">
                @else
                <div class="w-full">
                @endif
                    @php $operations = $visite->operations @endphp
                    <div class="text-sm mt-8">
                        <h1 class="mb-2 text-xl text-center font-semibold">Opérations</h1>

                        <table class="w-full">
                            <tr class="border-b">
                                <th class="p-1 w-80">TRAITEMENT</th>
                                <th class="p-1">DENTS</th>
                                <th class="p-1 w-80">DESCRIPTION</th>
                                <th class="p-1 w-80">COMMENTAIRE</th>
                                <th class="p-1 w-6">T</th>
                            </tr>
                            @foreach ($operations as $operation)
                            <tr class="border-b">
                                <td class="p-1 align-top break-all">{{ $operation->plan->traitement->designation }}</td>
                                <td class="p-1 align-top">{{ $operation->plan->dents }}</td>
                                <td class="p-1 align-top break-all">{{ $operation->plan->desc }}</td>
                                <td class="p-1 align-top break-all">{{ $operation->commentaire }}</td>
                                <td class="p-1 align-top text-center">
                                    @if ($operation->plan->termine)
                                    <x-jet-checkbox class="my-1" checked disabled />
                                    @else
                                    <x-jet-checkbox class="my-1" disabled />
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
    @endif
    @endforeach
</div>
