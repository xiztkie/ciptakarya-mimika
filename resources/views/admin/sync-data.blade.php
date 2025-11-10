<x-app-layout :title="$title" :subtitle="$subtitle ?? ''" :active="$active">

    <div
        class="bg-gradient-to-br from-sky-400 to-cyan-400 text-white py-6 md:py-8 mb-6 rounded-b-2xl shadow-lg overflow-hidden relative">
        <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/20 rounded-full filter blur-lg hidden sm:block"></div>
        <div class="absolute -bottom-12 -left-8 w-48 h-48 bg-white/20 rounded-full filter blur-lg hidden sm:block">
        </div>

        <div class="absolute -bottom-2 -right-2 text-white/20 transform rotate-12 hidden md:block">
            <img src="{{ asset('assets/images/sync.png') }}" alt="Sync Icon" class="h-32 w-32 opacity-20">
        </div>

        <div class="container mx-auto px-4 sm:px-6 relative">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-center md:text-left mb-4 md:mb-0 z-10">
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight mb-1"
                        style="text-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        Sinkronisasi Data
                    </h1>
                    <p class="text-sm sm:text-base text-sky-100 max-w-md">
                        Jaga agar data Anda selalu terbarui dengan menyinkronkan dari sistem eksternal.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sync
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Last Update
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $icons = [
                                        'syncpenyedia' =>
                                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
                                        'synclokasipenyedia' =>
                                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                                        'synctender' =>
                                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>',
                                        'syncnontender' =>
                                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>',
                                        'synckontraktender' =>
                                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z" /></svg>',
                                        'synckontraknontender' =>
                                            '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>',
                                    ];
                                @endphp

                                @foreach ($syncdata as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="shrink-0 h-10 w-10 text-sky-500">
                                                    {!! $icons[$item->route_sync] ?? '' !!}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 sync-label">
                                                        {{ $item->nama_api }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                {{ $item->last_synced_at ? \Carbon\Carbon::parse($item->last_synced_at)->format('d M Y, H:i') : 'Belum pernah' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button data-modal-target="sync-modal-{{ $item->id }}"
                                                data-modal-toggle="sync-modal-{{ $item->id }}"
                                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors duration-150 ease-in-out"
                                                type="button">
                                                <i class="fa-solid fa-rotate mr-2"></i>
                                                Sync
                                            </button>

                                            <div id="sync-modal-{{ $item->id }}" tabindex="-1" aria-hidden="true"
                                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full bg-gray-900/80">
                                                <div
                                                    class="relative w-full max-w-md h-full md:h-auto mx-auto mt-10 md:mt-24">
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                        <div
                                                            class="flex justify-between items-center p-5 rounded-t dark:border-gray-600">
                                                            <h3
                                                                class="text-xl font-medium text-gray-900 dark:text-white text-left">
                                                                Sinkronisasi {{ $item->nama_api }}
                                                            </h3>
                                                            <button type="button"
                                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                data-modal-hide="sync-modal-{{ $item->id }}">
                                                                <svg class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd"
                                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route($item->route_sync) }}" method="POST"
                                                            class="p-4 text-left sync-form">
                                                            @csrf
                                                            <div class="mb-4">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id }}">
                                                                <label for="tahun_anggaran_{{ $item->id }}"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                                    Pilih Tahun Anggaran
                                                                </label>
                                                                <select name="tahun"
                                                                    id="tahun_anggaran_{{ $item->id }}" required
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                                    @for ($year = date('Y'); $year >= date('Y') - 10; $year--)
                                                                        <option value="{{ $year }}">
                                                                            {{ $year }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="flex justify-end">
                                                                <button type="submit"
                                                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors duration-150 ease-in-out group">
                                                                    <i class="fa-solid fa-rotate"></i>
                                                                    <span class="sync-text ml-2">Sync</span>
                                                                    <svg class="sync-spinner hidden animate-spin ml-2 h-5 w-5 text-white"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24">
                                                                        <circle class="opacity-25" cx="12"
                                                                            cy="12" r="10" stroke="currentColor"
                                                                            stroke-width="4">
                                                                        </circle>
                                                                        <path class="opacity-75" fill="currentColor"
                                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
