<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        @php
        $patient = App\Models\Visite::find($id_visite)->patient;
        $prescs = App\Models\Prescription::where('id_visite', $id_visite)->get();
        @endphp

        <div class="py-12">
            <div class="flex justify-center pb-5">
                <img class="block h-20 w-auto" src="/images/logo.png" alt="logo">
                <div class="text-center ml-5">
                    <p class="font-semibold">TCHEUGOUE TCHOUASSI Clément</p>
                    <p class="text-xs">Docteur en Chirurgie Dentaire (Université Cheikh Anta Diop de Dakar)</p>
                    <p class="text-xs">Certificat d'études supérieures de prothèse fixée (Universite de Nancy I)</p>
                    <p class="text-xs">Diplôme universitaire des bases fondamentales en implantologie orale (Université de Strasbourg)</p>
                    <p class="text-xs">N d'inscription a l'ONCDC : 248</p>
                </div>
            </div>

            <div class="m-auto w-full flex flex-col pt-5 border-t">
            	<div class="flex justify-between pb-6 mx-16">
            	    <p><span class="font-medium">Nom du patient : </span>{{ $patient->nom }}</p>
            	    <p><span class="font-medium">Date : </span>{{ (count($prescs) > 0) ? Carbon\Carbon::createFromDate($prescs[0]->visite->date)->locale('fr')->isoFormat('Do MMMM YYYY') : Carbon\Carbon::now()->locale('fr')->isoFormat('Do MMMM YYYY') }}</p>
            	</div>

                <div class="text-center w-full m-auto">
                    <div class="mb-4">
                        @php $date = Carbon\Carbon::create($prescs[0]->visite->date) @endphp
                        <p class="font-semibold text-xl border-b-2 border-black pb-0 inline-block leading-7">{{ 'ORDONNANCE DS-' . substr($date, 8, 2) . substr($date, 5, 2) . substr($date, 2, 2) . '-' . sprintf("%05d", $id_visite)  }}</p>
                    </div>
                    
                    @if(count($prescs) > 0)
				    <table class="mb-8 m-auto">
				        @foreach ($prescs as $presc)
				        <tr class="border-b text-lg">
				            <td class="px-3 py-1 text-left align-top">{{ $presc->produit }}</td>
				            <td class="px-3 py-1 text-left align-top">{{ $presc->mode_emploi }}</td>
				        </tr>
				        @endforeach
				    </table>
                    @endif

                    <x-jet-button onclick="location.replace('../../patient/{{$patient->id}}')"></x-jet-button>
                </div>
            </div>
    	</div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
