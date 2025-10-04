<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form action="{{ route('ruangan.update', $ruang->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Ruangan</label>
                        <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan', $ruang->nama_ruangan) }}"
                            class="border rounded w-full px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Kapasitas</label>
                        <input type="text" name="kapasitas" value="{{ old('kapasitas', $ruang->kapasitas) }}"
                            class="border rounded w-full px-3 py-2">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>