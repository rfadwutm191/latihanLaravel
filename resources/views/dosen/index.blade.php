<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Form Tambah Dosen --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">Tambah Dosen</h3>
                    <form method="POST" action="{{ route('dosen.store') }}" class="space-y-4">
                        @csrf
                       <input type="text" name="nama" placeholder="Dosen"
                            class="border-gray-300 rounded-md w-full text-black">
                        <input type="number" name="nid" placeholder="NID"
                            class="border-gray-300 rounded-md w-full text-black">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>

            {{-- List Dosen --}}
             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">List Dosen</h3>
                    <table class="table-auto w-full border">
                        <thead class="bg-gray-200 text-gray-700">

                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">NID</th>
                                <th class="px-4 py-2 w-40 text-center">Aksi</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $dsn)
                                <tr>
                                    <td class="border px-4 py-2">{{ $dsn->nama }}</td>
                                    <td class="border px-4 py-2">{{ $dsn->nid }}</td>
                                    <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('dosen.edit', $dsn->id) }}"
                                        class="inline-block px-3 py-1 bg-blue-600 text-white rounded">Edit</a>
                                    <form action="{{ route('dosen.destroy', $dsn->id) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Hapus data ini?')"
                                            class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                                    </form>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
