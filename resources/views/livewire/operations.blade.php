@php
$visites = App\Models\Visite::orderByDesc('date')->where('id_patient', $id_patient)->get('id');
$consultations = App\Models\Consultation::whereIn('id_visite', $visites)->get('id');
$plans = App\Models\Plan::whereIn('id_cons', $consultations)->get('id');
$plans_conf = App\Models\Plan::whereIn('id', $plans)->where('confirme', 1)->where('termine', 0)->get();
$autres_plans = App\Models\Plan::whereIn('id', $plans)->where('confirme', 0)->get();
@endphp

@if ($plans->count() > 0)
<div class="sm:px-16 py-8 bg-white rounded-md my-12 flex flex-col justify-center">
    <div class="flex justify-start mb-8 items-center">
        <x-jet-label for="date" value="Date" class="inline-block mr-5" />
        <x-jet-input type="date" id="date" wire:change="nouvelleDate()" wire:model="date" />
    </div>

    <hr>

    <h1 class="text-2xl text-center font-semibold my-8">Traitements à réaliser</h1>

    <table class="mb-4">
        <tr class="border-b">
            <th class="p-1 align-top w-40">DATE</th>
            <th class="p-1 align-top">TRAITEMENT</th>
            <th class="p-1 align-top">DENTS</th>
            <th class="p-1 align-top">DESCRIPTION</th>
            <th></th>
        </tr>
        @if (count($plans_conf) > 0)
        <tr class="border-b">
            <th colspan="5" class="py-3">CONFIRMES</th>
        </tr>
        @foreach ($plans_conf as $plan_conf)
        <tr class="border-b hover:bg-gray-200 cursor-pointer" wire:click="ajouterOperation({{ $plan_conf->id }})">
            <td class="p-1 align-top">{{ Carbon\Carbon::createFromDate($plan_conf->consultation->visite->date)->locale('fr')->isoFormat('Do MMM YYYY') }}</td>
            <td class="p-1 align-top">{{ $plan_conf->traitement->designation }}</td>
            <td class="p-1 align-top">{{ $plan_conf->dents }}</td>
            <td class="p-1 align-top" colspan="2">{{ $plan_conf->desc }}</td>
        </tr>
        @endforeach
        @endif

        @if (count($autres_plans) > 0)
        <tr class="border-b">
            <th colspan="5" class="py-3">NON CONFIRMES</th>
        </tr>
        @foreach ($autres_plans as $autre_plan)
        <tr class="border-b hover:bg-gray-200 cursor-pointer">
            <td class="p-1 align-top" wire:click="confirmerPlan({{ $autre_plan->id }})">{{ Carbon\Carbon::createFromDate($autre_plan->consultation->visite->date)->locale('fr')->isoFormat('Do MMM YYYY') }}</td>
            <td class="p-1 align-top" wire:click="confirmerPlan({{ $autre_plan->id }})">{{ $autre_plan->traitement->designation }}</td>
            <td class="p-1 align-top" wire:click="confirmerPlan({{ $autre_plan->id }})">{{ $autre_plan->dents }}</td>
            <td class="p-1 align-top" wire:click="confirmerPlan({{ $autre_plan->id }})">{{ $autre_plan->desc }}</td>
            <td class="p-1 align-top"><i class="fas fa-times hover:text-red-500" wire:click="supprimerPlan({{ $autre_plan->id }})"></i></td>
        </tr>
        @endforeach
        @endif
    </table>
    
    @if (count($operations) > 0)
    <h2 class="my-6 text-xl text-center font-semibold">Opérations</h2>

    <table class="text-sm mb-6">
        <tr>
            <th class="md:w-72 sm:w-32">TRAITEMENT</th>
            <th class="w-32">DENTS</th>
            <th class="sm:hidden md:table-cell">OBSERVATIONS - OPERATIONS</th>
            <th class="md:hidden sm:table-cell">OBSERVATIONS - OPERATIONS</th>
            <th class="w-4">TERM</th>
            <th class="w-4">
                @if (session()->has('operation_validee'))
                <span x-data="{ shown: false, timeout: null }"
                    x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                    x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="text-green-500">
                    {{ session('operation_validee') }}
                </span>
                @endif
                @if (session()->has('operation_existante'))
                <span x-data="{ shown: false, timeout: null }"
                    x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                    x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="text-red-500">
                    {{ session('operation_existante') }}
                </span>
                @endif
            </th>
        </tr>
        @php $i = 0 @endphp
        @foreach ($operations as $operation)
        @php $plan = App\Models\Plan::find($operation) @endphp
        <tr class="hover:bg-gray-200">
            <td class="p-1 align-top">{{ $plan->traitement->designation }}</td>
            <td class="p-1 align-top">{{ $plan->dents }}</td>
            <td class="p-1 align-top"><x-jet-input type="text" class="p-1 text-xs w-full" wire:model="commentaire.{{$i}}" /></td>
            <td class="p-1 align-top text-center">
                @if ($plans_termines[$i])
                <x-jet-checkbox class="mt-1" wire:click="plan_termine({{$i}})" checked />
                @else
                <x-jet-checkbox class="mt-1" wire:click="plan_termine({{$i}})" />
                @endif
            </td>
            <td class="p-1 align-top"><button type="submit" class="inline-flex items-center p-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition" wire:click="validerOperation({{$plan->id}})">VALIDER</button></td>
        </tr>
        @php $i++ @endphp
        @endforeach
    </table>
    <hr>
    @endif

    @if (count($nouveaux_plans) > 0)
    <div class="flex flex-col sm:justify-center items-center my-8 text-sm">
        <h2 class="my-6 text-xl text-center font-semibold">Traitements prescrits non confirmés</h2>

        <table class="mb-8">
            <tr>
                <th class="px-2 py-1">TRAITEMENT</th>
                <th class="px-2 py-1 w-20">PRIX</th>
                <th class="px-2 py-1 w-36">DENTS</th>
                <th class="px-2 py-1 w-40">DESCRIPTION</th>
                <th class="py-1 w-4">CONF</th>
            </tr>
            @php $i = 0 @endphp
            @foreach ($nouveaux_plans as $nouveau_plan)
            @php $plan = App\Models\Plan::find($nouveau_plan) @endphp
            <tr class="hover:bg-gray-200">
                <td class="px-2">{{ $plan->traitement->designation }}</td>
                <td class="px-2"><x-jet-input class="w-full p-1 text-sm" type="text" wire:model="prix.{{$i}}" /></td>
                <td class="px-2">{{ $plan->dents }}</td>
                <td class="px-2">{{ $plan->desc }}</td>
                <td class="text-center"><x-jet-checkbox class="my-1" wire:click="deconf_plan({{$plan->id}})" checked /></td>
            </tr>
            @php $i++ @endphp
            @endforeach
        </table>

        <div class="text-center">
            <x-jet-button wire:click="ajouterPlan">Confirmer</x-jet-button>
        </div>
    </div>

    <hr>
    @endif

    @if ($presc)
    <livewire:prescriptions :visiteId="$this->visite_actuelle->id">
    @endif

    <div class="my-6 text-center">
        @if ($bouton_terminer)
        <x-jet-button wire:click="terminer" class="mr-8">Terminer</x-jet-button>
        @endif
        <x-jet-button wire:click="annuler">Annuler</x-jet-button>
    </div>
</div>
@else
<div class="sm:px-16 py-8 bg-white rounded-md my-12 flex justify-center">
    <h1 class="text-2xl font-semibold mr-10">Aucun traitement à réaliser</h1>
    <x-jet-button><a href="">Retour</a></x-jet-button>
</div>
@endif