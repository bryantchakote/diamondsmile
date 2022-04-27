        <div class="my-10">
            <h1 class="my-6 text-2xl text-center font-semibold">Plan de traitement</h1>

            <div class="md:flex text-xs-sm md:text-sm">
                <div class="md:w-5/12 md:mr-10 sm:mr-0 sm:w-full">
                    <table class="w-full">
                        @for ($i = 0; $i < 6; $i++)
                        @php $traitements_type = $traitements[$types[$i]->type] @endphp
                        <tr>
                            <th colspan="3" class="pt-3 text-base">{{ $traitements_type[0]->type . ' (' . $traitements_type->count() . ')' }}</th>
                        </tr>
                        @for ($j = 0; $j < $traitements_type->count(); $j++)
                        <tr class="hover:bg-gray-200">
                            <td><label for="traitement_{{$traitements_type[$j]->id - 1}}">{{ $traitements_type[$j]->designation }}</label></td>
                            <td class="text-right pr-1"><label for="traitement_{{$traitements_type[$j]->id - 1}}">{{ number_format($traitements_type[$j]->prix($id_patient), 0, '', ' ') ?? '' }}</label></td>
                            <td class="w-4"><x-jet-checkbox class="my-1" wire:click="ajout_traitement({{$traitements_type[$j]->id - 1}})" id="traitement_{{$traitements_type[$j]->id - 1}}" /></td>
                        </tr>
                        @endfor
                        @endfor
                    </table>
                </div>
                <div class="md:w-7/12 sm:w-full">
                    <table class="w-full">
                        @for ($i = 6; $i < 10; $i++)
                        @php $traitements_type = $traitements[$types[$i]->type] @endphp
                        <tr>
                            <th colspan="3" class="pt-3 text-base">{{ $traitements_type[0]->type . ' (' . $traitements_type->count() . ')' }}</th>
                        </tr>
                        @for ($j = 0; $j < $traitements_type->count(); $j++)
                        <tr class="hover:bg-gray-200">
                            <td><label for="traitement_{{$traitements_type[$j]->id - 1}}">{{ $traitements_type[$j]->designation }}</label></td>
                            <td class="text-right pr-1"><label for="traitement_{{$traitements_type[$j]->id - 1}}">{{ number_format($traitements_type[$j]->prix($id_patient), 0, '', ' ') ?? '' }}</label></td>
                            <td><x-jet-checkbox class="my-1" wire:click="ajout_traitement({{$traitements_type[$j]->id - 1}})" id="traitement_{{$traitements_type[$j]->id - 1}}" /></td>
                        </tr>
                        @endfor
                        @endfor
                    </table>
                </div>
            </div>

            @if ($mode_editer_traitement == 1)
            <div class="flex flex-col sm:justify-center items-center mt-8 text-sm">
                <table class="mb-8">
                    <tr>
                        <th class="pl-1 py-1">#</th>
                        <th class="px-2 py-1">TRAITEMENT</th>
                        <th class="px-2 py-1 w-20">PRIX</th>
                        <th class="px-2 py-1 w-36">DENTS</th>
                        <th class="px-2 py-1 w-64">DESCRIPTION</th>
                        <th class="px-2 py-1 w-24">DUREE</th>
                        <th class="py-1 w-4">CONF</th>
                    </tr>
                    @php $i = 0 @endphp
                    @foreach ($traits_selectionnes as $trait_selectionne)
                    @php $traitement = App\Models\Traitement::find($trait_selectionne + 1) @endphp
                    <tr class="hover:bg-gray-200">
                        <th class="pl-1">{{ $i + 1 }}</th>
                        <td class="px-2">{{ $traitement->designation }}</td>
                        <td class="px-2"><x-jet-input class="w-full p-1 text-sm" type="text" wire:model="prix.{{$i}}" /></td>
                        <td class="px-2"><x-jet-input class="w-full p-1 text-sm" type="text" wire:model="dents.{{$i}}" /></td>
                        <td class="px-2"><x-jet-input class="w-full p-1 text-sm" type="text" wire:model="desc.{{$i}}" /></td>
                        <td class="px-2"><x-jet-input class="w-full p-1 text-sm" type="text" wire:model="duree.{{$i}}" /></td>
                        <td class="text-center">
                            @if (in_array($traitement->id - 1, $plans_conf))
                            <x-jet-checkbox class="my-1" wire:click="conf_plan({{ $traitement->id }})" checked />
                            @else
                            <x-jet-checkbox class="my-1" wire:click="conf_plan({{ $traitement->id }})" />
                            @endif
                        </td>
                    </tr>
                    @php $i++ @endphp
                    @endforeach
                </table>

                <div class="text-center">
                    <x-jet-button wire:click="ajouterPlan">Confirmer</x-jet-button>
                    @if (session()->has('plan_modifie'))
                    <span x-data="{ shown: false, timeout: null }"
                        x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                        x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 mt-5 ml-5 bg-green-500 text-green-200 text-sm rounded shadow ml-5">
                        {{ session('plan_modifie') }}
                    </span>
                    @endif
                </div>
            </div>
            @endif
        </div>