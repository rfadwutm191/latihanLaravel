<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Dosen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form action="{{ route('dosen.update', $dsn->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $dsn->nama) }}"
                               class="border rounded w-full px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">NID</label>
                        <input type="text" name="nid" value="{{ old('nid', $dsn->nid) }}"
                               class="border rounded w-full px-3 py-2">
                    </div>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
