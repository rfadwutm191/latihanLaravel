<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EkycRegistration;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterAlamat;

class EkycController extends Controller
{
    public function step1()
    {
        $ekyc = EkycRegistration::where('user_id', Auth::id())->first();

        if ($ekyc) {
            session(['ekyc_id' => $ekyc->id]);
        }

        return view('ekyc.step1', compact('ekyc'));
    }

    public function storeStep1(Request $request)
    {
        $ekyc = EkycRegistration::where('user_id', Auth::id())->first();

        // SKIP UPDATE jika sudah submitted
        if ($ekyc && $ekyc->status === 'submitted') {
            return redirect()->route('ekyc.step2');
        }

        // Jika belum submitted, baru simpan
        $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
        ]);

        $ekyc = EkycRegistration::updateOrCreate(
            [
                'id' => session('ekyc_id'),
                'user_id' => Auth::id(),
            ],
            [
                'nama' => $request->nama,
                'nik' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'status' => 'draft',
            ]
        );

        session(['ekyc_id' => $ekyc->id]);

        return redirect()->route('ekyc.step2');
    }
    // STEP 2
    public function step2()
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();
        return view('ekyc.step2', compact('data'));
    }

    public function storeStep2(Request $request)
    {
        $ekyc = EkycRegistration::where('user_id', Auth::id())->first();

        // SKIP UPDATE jika sudah submitted
        if ($ekyc && $ekyc->status === 'submitted') {
            return redirect()->route('ekyc.step3');
        }

        // Jika belum submitted, update normal
        $validated = $request->validate([
            'file_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'file_selfie' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_ktp')) {
            $validated['file_ktp'] = $request->file('file_ktp')->store('ekyc', 'public');
        }

        if ($request->hasFile('file_selfie')) {
            $validated['file_selfie'] = $request->file('file_selfie')->store('ekyc', 'public');
        }

        $ekyc->update($validated);

        return redirect()->route('ekyc.step3');
    }
    //STEP 3
    public function showStep3()
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();
        return view('ekyc.step3', compact('data'));
    }

    public function storeStep3(Request $request)
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();

        // SKIP UPDATE jika sudah submitted
        if ($data && $data->status === 'submitted') {
            return redirect()->route('ekyc.step4');
        }

        // Jika belum submitted, update normal
        $request->validate([
            'asal_sd' => 'required|string|max:255',
            'asal_smp' => 'required|string|max:255',
            'asal_sma' => 'required|string|max:255',
            'file_kk' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_ijazah' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data->asal_sd = $request->asal_sd;
        $data->asal_smp = $request->asal_smp;
        $data->asal_sma = $request->asal_sma;

        if ($request->hasFile('file_kk')) {
            $data->file_kk = $request->file('file_kk')->store('ekyc', 'public');
        }

        if ($request->hasFile('file_ijazah')) {
            $data->file_ijazah = $request->file('file_ijazah')->store('ekyc', 'public');
        }

        $data->save();

        return redirect()->route('ekyc.step4');
    }
    //STEP 4
    public function showStep4()
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();

        $alamatList = MasterAlamat::all();
        $provinsiList = MasterAlamat::select('provinsi')->distinct()->pluck('provinsi');
        $kotaList = [];
        $kecamatanList = [];

        if ($data && $data->provinsi) {
            $kotaList = MasterAlamat::where('provinsi', $data->provinsi)
                ->select('kota')->distinct()->pluck('kota');
        }

        if ($data && $data->kota) {
            $kecamatanList = MasterAlamat::where('kota', $data->kota)
                ->select('kecamatan')->distinct()->pluck('kecamatan');
        }

        return view('ekyc.step4', compact(
            'data', 'alamatList', 'provinsiList', 'kotaList', 'kecamatanList'
        ));
    }

   public function storeStep4(Request $request)
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();
        // Langsung ke step5 
        if ($data && $data->status === 'submitted') {
            return redirect()->route('ekyc.step5');
        }

        $request->validate([
            'alamatDomisili' => 'required|string|max:255',
            'provinsi'       => 'required|string|max:100',
            'kota'           => 'required|string|max:100',
            'kecamatan'      => 'required|string|max:100',
            'kode_pos'       => 'required|string|max:10',
            'nama_ibu_kandung' => 'required|string|max:100',
            'referensi_sumber' => 'required|string|max:100',
        ]);

        // Ambil data eKYC milik user login
        $data = \App\Models\EkycRegistration::where('user_id', Auth::id())->first();

        if (!$data) {
            return redirect()->route('ekyc.step4')->with('error', 'Data eKYC tidak ditemukan');
        }

        // Simpan data alamat & informasi pendaftaran
        $data->alamatDomisili   = $request->alamatDomisili;
        $data->provinsi         = $request->provinsi;
        $data->kota             = $request->kota;
        $data->kecamatan        = $request->kecamatan;
        $data->kode_pos         = $request->kode_pos;
        $data->nama_ibu_kandung   = $request->nama_ibu_kandung;
        $data->referensi_sumber      = $request->referensi_sumber;
        // $data->save();

        // return redirect()->route('ekyc.step4')->with('success', 'Data alamat dan informasi berhasil disimpan');

        $data->status = 'submitted';
        $data->save();

        // Arahkan kehalaman sukses step 5
        return redirect()->route('ekyc.step5')->with('success', 'Registrasi eKYC telah selesai!');
    }
    //STEP 5
       public function step5(Request $request)
        {
            $data = \App\Models\EkycRegistration::where('user_id', Auth::id())->first();
            if (!$data) {
                return redirect()->route('ekyc.step1')->with('Error', 'Data eKYC tidak ditemukan!');
            }

            // pastikan hanya user dengan status selesai yang bisa melihat halaman ini
            if ($data->status !== 'submitted') {
                return redirect()->route('ekyc.step4')->with('error', 'Lengkapi data terlebih dahulu sebelum menyelesaikan eKYC');
            }

            return view('ekyc.step5', compact('data'));
        }

     // STATUS 
        public function status()
        {
            $user = Auth::user();
            $ekyc = \App\Models\EkycRegistration::where('user_id', $user->id)->first();
            return view('ekyc.status', compact('ekyc'));
        }
    }
