<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Verifikasi eKYC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-800 text-center">

                    {{-- Bagian Judul --}}
                    <h1 class="text-2xl font-bold mb-6">Status Verifikasi eKYC</h1>

                    {{-- Status --}}
                    @if ($ekyc->status == 'accepted')
                        <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-4">
                            <h3 class="text-lg font-semibold mb-2">✅ Selamat!</h3>
                            <p>Registrasi eKYC kamu telah <strong>DITERIMA</strong> oleh admin.</p>
                            <p class="mt-2 text-sm text-green-600">Akun kamu sudah aktif dan dapat digunakan sepenuhnya.</p>
                        </div>

                    @elseif ($ekyc->status == 'rejected')
                        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-4">
                            <h3 class="text-lg font-semibold mb-2">❌ Maaf!</h3>
                            <p>Registrasi eKYC kamu telah <strong>DITOLAK</strong> oleh admin.</p>
                            <p class="mt-2 text-sm text-red-600">Silakan hubungi admin atau lakukan registrasi ulang.</p>
                        </div>

                    @else
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-6 py-4 rounded-lg mb-4">
                            <h3 class="text-lg font-semibold mb-2">🕓 Sedang Diproses</h3>
                            <p>Registrasi kamu masih dalam proses verifikasi oleh admin.</p>
                        </div>
                    @endif

                    {{-- Tombol --}}
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-5 py-2 bg-blue-600 border border-transparent rounded-md
                            font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700
                            focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500
                            focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>