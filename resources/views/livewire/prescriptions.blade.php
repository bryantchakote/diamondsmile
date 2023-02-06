        <div class="my-10">
            <h1 class="my-6 text-2xl text-center font-semibold">Prescriptions</h1>

            <div class="grid grid-cols-3 pb-4">
                <div class="col-span-1 flex justify-end md:mr-5 sm:mr-2">
                    <x-jet-input class="sm:w-11/12 md:w-6/12" type="text" wire:model="{{ ($mode_presc == 'ajout') ? 'n_produit' : 'm_produit' }}" placeholder="Produit" required />
                </div>

                <div class="col-span-1 flex md:justify-center sm:justify-start">
                    <x-jet-input class="sm:w-10/12 md:w-full" type="text" wire:model="{{ ($mode_presc == 'ajout') ? 'n_mode_emploi' : 'm_mode_emploi' }}" placeholder="Mode d'emploi" />
                </div>

                <div class="col-span-1 flex md:justify-start sm:justify-end md:ml-5">
                    @if ($mode_presc == 'ajout')
                    <x-jet-button wire:click="ajouterPresc">Ajouter</x-jet-button>
                    @else
                    <x-jet-button class="md:mr-5 sm:mr-1" wire:click="modifierPresc">Modifier</x-jet-button>
                    <x-jet-button wire:click="modeAjoutPresc">Annuler</x-jet-button>
                    @endif
                </div>
            </div>

            @if (count($prescs) != 0)
            <div class="flex flex-col sm:justify-center items-center my-6">
                <table>
                    <tr>
                        <th class="px-3 py-1">#</th>
                        <th class="px-3 py-1">PRODUITS PRESCRITS</th>
                        <th class="px-3 py-1">MODE D'EMPLOI</th>
                        <th class="px-3 py-1"></th>
                    </tr>
                    @php $i = 1 @endphp
                    @foreach ($prescs as $presc)
                    <tr class="hover:bg-gray-200">
                        <th class="px-3 py-1">{{ $i++ }}</th>
                        <td class="px-3 py-1">{{ $presc->produit }}</td>
                        <td class="px-3 py-1">{{ $presc->mode_emploi }}</td>
                        <td class="px-3 py-1 text-center">
                            <button wire:click="modeModifPresc({{ $presc->id }})" class="font-semibold hover:text-green-500" title="Modifier">M</button> &nbsp;
                            <button wire:click="supprimerPresc({{ $presc->id }})" class="font-semibold hover:text-red-500" title="Supprimer">S</button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        </div>