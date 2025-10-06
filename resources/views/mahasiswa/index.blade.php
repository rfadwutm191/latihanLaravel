<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            @php
            $isDelete = str_contains(session('success'), 'hapus');
            @endphp

            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                x-transition
                class="mb-4 p-4 text-center text-white-200 rounded-2xl border border-white/20
                    shadow-md backdrop-blur-lg 
                    {{ $isDelete ? 'bg-green-400/50' : 'bg-green-400/40' }}">
                <p class="font-semibold text-base tracking-wide drop-shadow-md">
                    {{ session('success') }}
                </p>
            </div>
            @endif

            @if ($errors->any())
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                x-transition
                class="mb-4 p-4 text-center text-white rounded-2xl border border-white/20
                    shadow-md backdrop-blur-lg bg-red-400/40">
                <ul class="list-disc list-inside inline-block text-left text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Form Tambah Mahasiswa --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">Tambah Mahasiswa</h3>
                    <form method="POST" action="{{ route('mahasiswa.store') }}" class="space-y-4">
                        @csrf
                        <input type="text" name="nama" placeholder="Nama"
                            class="border-gray-300 rounded-md w-full text-black">
                        <input type="number" name="nim" placeholder="NIM"
                            class="border-gray-300 rounded-md w-full text-black">
                        <select name="kelas_id" class="border-gray-300 rounded-md w-full text-black">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $kls)
                            <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>

            {{-- List Mahasiswa --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">List Mahasiswa</h3>
                    <table class="table-auto w-full border">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 w-16 text-center">No</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">NIM</th>
                                <th class="px-4 py-2 border">Kelas</th>
                                <th class="px-4 py-2 w-40 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $mhs)
                            <tr>
                                <td class="border px-4 text-center">{{ $loop->iteration }} </td>
                                <td class="border px-4 py-2">{{ $mhs->nama }}</td>
                                <td class="border px-4 py-2">{{ $mhs->nim }}</td>
                                <td class="border px-4 py-2">{{ $mhs->kelas->nama_kelas ?? '-' }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('mahasiswa.edit', $mhs->id) }}"
                                        class="inline-block px-3 py-1 bg-blue-600 text-white rounded">Edit</a>
                                    <form action="{{ route('mahasiswa.destroy', $mhs->id) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Hapus data ini?')"
                                            class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>