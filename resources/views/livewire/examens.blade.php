        <div class="my-10">
            <h1 class="my-6 text-2xl text-center font-semibold">Examens</h1>
            
            <div class="mb-12">
                <h2 class="my-6 text-xl font-semibold">Examen de la denture</h2>

                <div class="flex-col my-6">
                    @for ($i = 1; $i <= 4; $i++)
                    <div class="md:flex justify-between mb-6">
                        @for ($j = 1; $j <= 2; $j++)
                        <div class="flex justify-between">
                            @for ($k = 1; $k <= 8; $k++)
                            <table class="mx-2">
                                @php
                                if ($i == 1)
                                    if ($j == 1) $bloc = 1;
                                    else $bloc = 2;
                                elseif ($i == 2)
                                    if ($j == 1) $bloc = 4;
                                    else $bloc = 3;
                                elseif ($i == 3)
                                    if ($j == 1) $bloc = 5;
                                    else $bloc = 6;
                                elseif ($i == 4)
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
                                    @if ($denture[$bloc-1][$dent-1][0] == 0)
                                    <td class="border-2 h-3 w-4 p-0" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 0)"></td>
                                    @else
                                    <td class="border-2 h-3 w-4 p-0 bg-blue-500" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 0)"></td>
                                    @endif
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    @if ($denture[$bloc-1][$dent-1][1] == 0)
                                    <td class="border-2 h-3 w-4 p-0" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 1)"></td>
                                    @else
                                    <td class="border-2 h-3 w-4 p-0 bg-blue-500" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 1)"></td>
                                    @endif
                                    <td></td>
                                </tr>
                                <tr>
                                    @if ($denture[$bloc-1][$dent-1][2] == 0)
                                    <td class="border-2 h-3 w-4 p-0" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 2)"></td>
                                    @else
                                    <td class="border-2 h-3 w-4 p-0 bg-blue-500" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 2)"></td>
                                    @endif
                                    @if ($denture[$bloc-1][$dent-1][3] == 0)
                                    <td class="border-2 h-3 w-4 p-0" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 3)"></td>
                                    @else
                                    <td class="border-2 h-3 w-4 p-0 bg-blue-500" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 3)"></td>
                                    @endif
                                    @if ($denture[$bloc-1][$dent-1][4] == 0)
                                    <td class="border-2 h-3 w-4 p-0" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 4)"></td>
                                    @else
                                    <td class="border-2 h-3 w-4 p-0 bg-blue-500" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 4)"></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td></td>
                                    @if ($denture[$bloc-1][$dent-1][5] == 0)
                                    <td class="border-2 h-3 w-4 p-0" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 5)"></td>
                                    @else
                                    <td class="border-2 h-3 w-4 p-0 bg-blue-500" wire:click="denture({{ $bloc - 1 }}, {{ $dent - 1 }}, 5)"></td>
                                    @endif
                                    <td></td>
                                </tr>
                            </table>
                            @endfor
                        </div>
                        @endfor
                    </div>
                    @if ($i == 2)
                    <div class="border-t"></div>
                    <h3 class="my-4 text-lg font-semibold">Dents de lait</h3>
                    @endif
                    @endfor

                    <div class="mt-8 text-right">
                        @if (session()->has('ex_denture'))
                        <span x-data="{ shown: false, timeout: null }"
                            x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                            x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 mt-5 ml-5 bg-green-500 text-green-200 text-sm rounded shadow mr-5">
                            {{ session('ex_denture') }}
                        </span>
                        @endif
                        @if (session()->has('non_ex_denture'))
                        <span x-data="{ shown: false, timeout: null }"
                            x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                            x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 mt-5 ml-5 bg-red-500 text-red-200 text-sm rounded shadow mr-5">
                            {{ session('non_ex_denture') }}
                        </span>
                        @endif
                        <x-jet-button wire:click="examenDenture">Valider</x-jet-button>
                    </div>
                </div>
            </div>

            <div class="mb-12">
                <h2 class="my-6 text-xl font-semibold">Examen paradontal</h2>

                <div class="flex-col my-6">
                    @for ($i = 1; $i <= 2; $i++)
                    <div class="md:flex justify-between mb-6">
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
                                    <td class="flex m-0 border w-5 p-0"><input type="text" class="p-0 text-xs w-full h-3 border-0 focus:border-0 font-semibold text-blue-500" wire:model="paradontal.{{ $bloc - 1}}.{{ $dent -1 }}.0" /></td>
                                    <td class="flex m-0 w-5 p-0"></td>
                                </tr>
                                <tr class="flex items-center">
                                    <td class="flex m-0 border w-5 p-0"><input type="text" class="p-0 text-xs w-full h-3 border-0 focus:border-0 font-semibold text-blue-500" wire:model="paradontal.{{ $bloc - 1}}.{{ $dent -1 }}.1" /></td>
                                    <td class="flex m-0 w-5 p-0"></td>
                                    <td class="flex m-0 border w-5 p-0"><input type="text" class="p-0 text-xs w-full h-3 border-0 focus:border-0 font-semibold text-blue-500" wire:model="paradontal.{{ $bloc - 1}}.{{ $dent -1 }}.2" /></td>
                                </tr>
                                <tr class="flex items-center">
                                    <td class="flex m-0 w-5 p-0"></td>
                                    <td class="flex m-0 border w-5 p-0"><input type="text" class="p-0 text-xs w-full h-3 border-0 focus:border-0 font-semibold text-blue-500" wire:model="paradontal.{{ $bloc - 1}}.{{ $dent -1 }}.3" /></td>
                                    <td class="flex m-0 w-5 p-0"></td>
                                </tr>
                            </table>
                            @endfor
                        </div>
                        @endfor
                    </div>
                    @endfor
                    <div class="mt-8 text-right">
                        @if (session()->has('ex_paradontal'))
                        <span x-data="{ shown: false, timeout: null }"
                            x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                            x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 mt-5 ml-5 bg-green-500 text-green-200 text-sm rounded shadow mr-5">
                            {{ session('ex_paradontal') }}
                        </span>
                        @endif
                        @if (session()->has('non_ex_paradontal'))
                        <span x-data="{ shown: false, timeout: null }"
                            x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 1500)"
                            x-show="shown" x-transition:leave.opacity.duration.1500ms style="display: none;" class="p-2 mt-5 ml-5 bg-red-500 text-red-200 text-sm rounded shadow mr-5">
                            {{ session('non_ex_paradontal') }}
                        </span>
                        @endif
                    <x-jet-button wire:click="examenParadontal">Valider</x-jet-button>
                    </div>
                </div>
            </div>
        </div>