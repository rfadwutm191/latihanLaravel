<x-app-layout>
    <div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4 text-center">
            Step 3 | Data Pendidikan & Upload Dokumen
        </h2>

        @if (session('success'))
            <div class="mb-4 text-green-600 text-center bg-green-100 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

         @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc ml-4 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('ekyc.step3.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Asal SD --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Asal Sekolah SD</label>
                <input type="text" name="asal_sd" value="{{ old('asal_sd', $data->asal_sd) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Asal SMP --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Asal Sekolah SMP</label>
                <input type="text" name="asal_smp" value="{{ old('asal_smp', $data->asal_smp) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Asal SMA --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Asal Sekolah SMA</label>
                <input type="text" name="asal_sma" value="{{ old('asal_sma', $data->asal_sma) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Upload KK --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Kartu Keluarga (KK)</label>
                <input type="file" name="file_kk" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @if ($data && $data->file_kk)
                    <a href="{{ asset('storage/'.$data->file_kk) }}" target="_blank"
                        class="text-blue-600 underline text-sm">Lihat KK</a>
                @endif
            </div>

            {{-- Upload Ijazah --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Ijazah Terakhir</label>
                <input type="file" name="file_ijazah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @if ($data && $data->file_ijazah)
                    <a href="{{ asset('storage/'.$data->file_ijazah) }}" target="_blank"
                        class="text-blue-600 underline text-sm">Lihat Ijazah</a>
                @endif
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('ekyc.step2') }}" class="text-sm text-gray-600 hover:text-gray-800">← Kembali ke Step 2</a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Simpan & Lanjut
                    <
                </button>
            </div>
        </form>
    </div>
</x-app-layout>