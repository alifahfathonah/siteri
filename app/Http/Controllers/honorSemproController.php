<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\sk_akademik;
use App\detail_sk;
use App\sk_honor;
use Carbon\Carbon;

class honorSemproController extends Controller
{
    public function index()
    {
        $sk_honor = sk_honor::orderBy('created_at', 'desc')
            ->with(['status_sk_honor', 'tipe_sk'])
            ->whereHas('tipe_sk', function (Builder $query) {
                $query->where('id', 2);
            })
            ->get();

        return view('keuangan.honor_sk.index', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Sempro'
        ]);
    }

    public function pilih_sk()
    {
        $sk_akademik = sk_akademik::with(['tipe_sk', 'status_sk_akademik', 'detail_sk'])
            ->whereHas('tipe_sk', function (Builder $query) {
                $query->where('id', 2);
            })
            ->whereHas('detail_sk', function (Builder $query) {
                $query->whereNull('id_sk_honor');
            })
            ->where('verif_dekan', 1)
            ->orderBy('created_at', 'desc')->get();
            // dd($sk_akademik);
        return view('keuangan.honor_sk.pilih_sk', [
            'sk_akademik' => $sk_akademik,
            'tipe' => 'SK Sempro'
        ]);
    }

    public function create($id)
    {
        $sk_akademik = sk_akademik::find($id);
        $detail_sk = detail_sk::where('id_sk_akademik', $id)->with([
            'pembimbing_utama:no_pegawai,nama,npwp,id_golongan', 'pembimbing_utama.golongan',
            'pembimbing_pendamping:no_pegawai,nama,npwp,id_golongan', 'pembimbing_pendamping.golongan',
            'penguji_utama:no_pegawai,nama,npwp,id_golongan', 'penguji_utama.golongan',
            'penguji_pendamping:no_pegawai,nama,npwp,id_golongan', 'penguji_pendamping.golongan',
        ])->get();
        // dd($detail_sk);
        return view('keuangan.honor_sk.create', [
            'sk_akademik' => $sk_akademik,
            'detail_sk' => $detail_sk,
            'tipe' => 'SK Sempro'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'honor_pembimbing1' => 'required',
            'honor_pembimbing2' => 'required',
            'honor_penguji' => 'required'
        ]);

        try {
            $sk_honor = sk_honor::create([
                'id_tipe_sk' => 2, //tipe SK Sempro
                'id_status_sk_honor' => $request->status,
                'no_surat' => $request->no_surat,
                'honor_pembimbing1' => $request->honor_pembimbing1,
                'honor_pembimbing2' => $request->honor_pembimbing2,
                'honor_penguji' => $request->honor_penguji
            ]);
            detail_sk::where('id_sk_akademik', $request->id_sk_akademik)
                ->update([
                    'id_sk_honor' => $sk_honor->id
                ]);
            return redirect()->route('keuangan.honor-sempro.show', $sk_honor->id)->with('success', 'Data Berhasil Dibuat');
        } catch (Exception $e) {
            return redirect()->route('keuangan.honor-sempro.index')->with('error', $e->getMessage());
        }
    }

    public function show($id_sk_honor)
    {
        $sk_honor = sk_honor::where('id', $id_sk_honor)
            ->with([
                'tipe_sk',
                'status_sk_honor',
                'detail_sk.pembimbing_utama:no_pegawai,nama,id_golongan',
                'detail_sk.pembimbing_utama.golongan',

                'detail_sk.pembimbing_pendamping:no_pegawai,nama,id_golongan',
                'detail_sk.pembimbing_pendamping.golongan',

                'detail_sk.penguji_utama:no_pegawai,nama,id_golongan',
                'detail_sk.penguji_utama.golongan',

                'detail_sk.penguji_pendamping:no_pegawai,nama,id_golongan',
                'detail_sk.penguji_pendamping.golongan',
            ])
            ->first();
        // dd($sk_honor);
        return  view('keuangan.honor_sk.show', [
            'sk_honor' => $sk_honor
        ]);
    }

    public function edit($id_sk_honor)
    {
        $sk_honor = sk_honor::where('id', $id_sk_honor)
            ->with([
                'tipe_sk',
                'status_sk_honor',
                'detail_sk.pembimbing_utama:no_pegawai,nama,id_golongan',
                'detail_sk.pembimbing_utama.golongan',

                'detail_sk.pembimbing_pendamping:no_pegawai,nama,id_golongan',
                'detail_sk.pembimbing_pendamping.golongan',

                'detail_sk.penguji_utama:no_pegawai,nama,id_golongan',
                'detail_sk.penguji_utama.golongan',

                'detail_sk.penguji_pendamping:no_pegawai,nama,id_golongan',
                'detail_sk.penguji_pendamping.golongan',

                'detail_sk.sk_akademik'
            ])
            ->first();
        // dd($sk_honor);
        return  view('keuangan.honor_sk.edit', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Sempro'
        ]);
    }

    public function update(Request $request, $id_sk_honor)
    {
        $this->validate($request, [
            'honor_pembimbing1' => 'required',
            'honor_pembimbing2' => 'required',
            'honor_penguji' => 'required'
        ]);

        try {
            $sk_honor = sk_honor::find($id_sk_honor);
            $verif_bpp = $sk_honor->verif_kebag_keuangan;
            $verif_ktu = $sk_honor->verif_ktu;
            $verif_wadek2 = $sk_honor->verif_wadek2;
            $verif_dekan = $sk_honor->verif_dekan;
            if ($request->status == 2) {
                $verif_bpp = 0;
                $verif_ktu = 0;
                $verif_wadek2 = 0;
                $verif_dekan = 0;
            }

            sk_honor::where('id', $id_sk_honor)->update([
                'id_status_sk_honor' => $request->status,
                'honor_pembimbing1' => $request->honor_pembimbing1,
                'honor_pembimbing2' => $request->honor_pembimbing2,
                'honor_penguji' => $request->honor_penguji,
                'verif_kebag_keuangan' => $verif_bpp,
                'verif_ktu' => $verif_ktu,
                'verif_wadek2' => $verif_wadek2,
                'verif_dekan' => $verif_dekan
            ]);

            return redirect()->route('keuangan.honor-sempro.show', $id_sk_honor)->with('success', 'Data Berhasil Dirubah');
        } catch (Exception $e) {
            return redirect()->route('keuangan.honor-sempro.edit', $id_sk_honor)->with('error', $e->getMessage());
        }
    }

    public function destroy($id = null)
    {
        if (!is_null($id)) {
            sk_honor::find($id)->delete();
            echo 'Daftar Honor Berhasil Dihapus'; 
        }
    }

    public function bpp_index()
    {
        $sk_honor = sk_honor::where('id_tipe_sk', 2)
        ->orderBy('updated_at', 'desc')
        ->with(['tipe_sk', 'status_sk_honor'])
        ->whereHas('status_sk_honor', function(Builder $query){ 
            $query->whereIn('id', [2,3,4,5,6]); 
        })->get();

        // dd($sk_honor);
        return view('bpp.honor_sk.honor_index', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Sempro'
        ]);
    }

    public function bpp_show($id_sk_honor)
    {
        $sk_honor = sk_honor::where('id', $id_sk_honor)
        ->with([
            'tipe_sk',
            'status_sk_honor',
            'detail_sk.pembimbing_utama:no_pegawai,nama,id_golongan',
            'detail_sk.pembimbing_utama.golongan',

            'detail_sk.pembimbing_pendamping:no_pegawai,nama,id_golongan', 
            'detail_sk.pembimbing_pendamping.golongan',

            'detail_sk.penguji_utama:no_pegawai,nama,id_golongan',
            'detail_sk.penguji_utama.golongan',

            'detail_sk.penguji_pendamping:no_pegawai,nama,id_golongan',
            'detail_sk.penguji_pendamping.golongan',
        ])
        ->first();
        // dd($sk_honor);

        if($sk_honor->id_status_sk_honor == 1){
            return redirect()->route('bpp.honor-sempro.index');
        }
        else{
            return  view('bpp.honor_sk.honor_show', [
                'sk_honor' => $sk_honor
            ]);    
        }
    }

    public function bpp_verif(Request $request, $id)
    {
        // dd($request);
        $sk_honor = sk_honor::find($id);
        $sk_honor->verif_kebag_keuangan = $request->verif_bpp;
        if ($request->verif_bpp == 2) {
            $request->validate([
                'pesan_revisi' => 'required|string'
            ]);

            $sk_honor->id_status_sk_honor = 1;
            $sk_honor->pesan_revisi = $request->pesan_revisi;
            $sk_honor->save();
            return redirect()->route('bpp.honor-sempro.index')->with("verif_bpp", 'Honorarium berhasil ditarik, status kembali menjadi "Draft"');
        } else if ($request->verif_bpp == 1) {
            $sk_honor->id_status_sk_honor = 3;
            $sk_honor->pesan_revisi = null;
            $sk_honor->save();
            return redirect()->route('bpp.honor-sempro.index')->with('verif_bpp', 'Verifikasi honorarium berhasil, status SK saat ini "Disetujui BPP"');
        }
    }

    public function ktu_index()
    {
        $sk_honor = sk_honor::where('id_tipe_sk', 2)
        ->orderBy('updated_at', 'desc')
        ->with(['tipe_sk', 'status_sk_honor'])
        ->whereHas('status_sk_honor', function(Builder $query){ 
            $query->whereIn('id', [3,4,5,6]); 
        })->get();

        // dd($sk_honor);
        return view('ktu.honor_sk.honor_index', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Sempro'
        ]);
    }

    public function ktu_show($id_sk_honor)
    {
        $sk_honor = sk_honor::where('id', $id_sk_honor)
        ->with([
            'tipe_sk',
            'status_sk_honor',
            'detail_sk.pembimbing_utama:no_pegawai,nama,id_golongan',
            'detail_sk.pembimbing_utama.golongan',

            'detail_sk.pembimbing_pendamping:no_pegawai,nama,id_golongan', 
            'detail_sk.pembimbing_pendamping.golongan',

            'detail_sk.penguji_utama:no_pegawai,nama,id_golongan',
            'detail_sk.penguji_utama.golongan',

            'detail_sk.penguji_pendamping:no_pegawai,nama,id_golongan',
            'detail_sk.penguji_pendamping.golongan',
        ])
        ->first();
        // dd($sk_honor);

        if($sk_honor->verif_kebag_keuangan != 1){
            return redirect()->route('ktu.honor-sempro.index');
        }
        else{
            return  view('ktu.honor_sk.honor_show', [
                'sk_honor' => $sk_honor
            ]);    
        }
    }

    public function ktu_verif(Request $request, $id)
    {
        // dd($request);
        $sk_honor = sk_honor::find($id);
        $sk_honor->verif_ktu = $request->verif_ktu;
        if ($request->verif_ktu == 2) {
            $request->validate([
                'pesan_revisi' => 'required|string'
            ]);

            $sk_honor->id_status_sk_honor = 1;
            $sk_honor->pesan_revisi = $request->pesan_revisi;
            $sk_honor->save();
            return redirect()->route('ktu.honor-sempro.index')->with("verif_ktu", 'Honorarium berhasil ditarik, status kembali menjadi "Draft"');
        } else if ($request->verif_ktu == 1) {
            $sk_honor->id_status_sk_honor = 4;
            $sk_honor->pesan_revisi = null;
            $sk_honor->save();
            return redirect()->route('ktu.honor-sempro.index')->with('verif_ktu', 'Verifikasi honorarium berhasil, status SK saat ini "Disetujui KTU"');
        }
    }

    public function wadek2_index()
    {
        $sk_honor = sk_honor::where('id_tipe_sk', 2)
        ->orderBy('updated_at', 'desc')
        ->with(['tipe_sk', 'status_sk_honor'])
        ->whereHas('status_sk_honor', function(Builder $query){ 
            $query->whereIn('id', [4,5,6]); 
        })->get();

        // dd($sk_honor);
        return view('wadek2.honor_sk.honor_index', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Sempro'
        ]);
    }

    public function wadek2_show($id_sk_honor)
    {
        $sk_honor = sk_honor::where('id', $id_sk_honor)
        ->with([
            'tipe_sk',
            'status_sk_honor',
            'detail_sk.pembimbing_utama:no_pegawai,nama,id_golongan',
            'detail_sk.pembimbing_utama.golongan',

            'detail_sk.pembimbing_pendamping:no_pegawai,nama,id_golongan', 
            'detail_sk.pembimbing_pendamping.golongan',

            'detail_sk.penguji_utama:no_pegawai,nama,id_golongan',
            'detail_sk.penguji_utama.golongan',

            'detail_sk.penguji_pendamping:no_pegawai,nama,id_golongan',
            'detail_sk.penguji_pendamping.golongan',
        ])
        ->first();
        // dd($sk_honor);

        if($sk_honor->verif_ktu != 1){
            return redirect()->route('wadek2.honor-sempro.index');
        }
        else{
            return  view('wadek2.honor_sk.honor_show', [
                'sk_honor' => $sk_honor
            ]);    
        }
    }

    public function wadek2_verif(Request $request, $id)
    {
        // dd($request);
        $sk_honor = sk_honor::find($id);
        $sk_honor->verif_wadek2 = $request->verif_wadek2;
        if ($request->verif_wadek2 == 2) {
            $request->validate([
                'pesan_revisi' => 'required|string'
            ]);

            $sk_honor->id_status_sk_honor = 1;
            $sk_honor->pesan_revisi = $request->pesan_revisi;
            $sk_honor->save();
            return redirect()->route('wadek2.honor-sempro.index')->with("verif_wadek2", 'Honorarium berhasil ditarik, status kembali menjadi "Draft"');
        } else if ($request->verif_wadek2 == 1) {
            $sk_honor->id_status_sk_honor = 5;
            $sk_honor->pesan_revisi = null;
            $sk_honor->save();
            return redirect()->route('wadek2.honor-sempro.index')->with('verif_wadek2', 'Verifikasi honorarium berhasil, status SK saat ini "Disetujui Wakil Dekan 2"');
        }
    }

    public function dekan_index()
    {
        $sk_honor = sk_honor::where('id_tipe_sk', 2)
        ->orderBy('updated_at', 'desc')
        ->with(['tipe_sk', 'status_sk_honor'])
        ->whereHas('status_sk_honor', function(Builder $query){ 
            $query->whereIn('id', [4,5,6]); 
        })->get();

        // dd($sk_honor);
        return view('dekan.honor_sk.honor_index', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Sempro'
        ]);
    }

    public function dekan_show($id_sk_honor)
    {
        $sk_honor = sk_honor::where('id', $id_sk_honor)
        ->with([
            'tipe_sk',
            'status_sk_honor',
            'detail_sk.pembimbing_utama:no_pegawai,nama,id_golongan',
            'detail_sk.pembimbing_utama.golongan',

            'detail_sk.pembimbing_pendamping:no_pegawai,nama,id_golongan', 
            'detail_sk.pembimbing_pendamping.golongan',

            'detail_sk.penguji_utama:no_pegawai,nama,id_golongan',
            'detail_sk.penguji_utama.golongan',

            'detail_sk.penguji_pendamping:no_pegawai,nama,id_golongan',
            'detail_sk.penguji_pendamping.golongan',
        ])
        ->first();
        // dd($sk_honor);

        if($sk_honor->verif_wadek2 != 1){
            return redirect()->route('dekan.honor-sempro.index');
        }
        else{
            return  view('dekan.honor_sk.honor_show', [
                'sk_honor' => $sk_honor
            ]);    
        }
    }

    public function dekan_verif(Request $request, $id)
    {
        // dd($request);
        $sk_honor = sk_honor::find($id);
        $sk_honor->verif_dekan = $request->verif_dekan;
        if ($request->verif_dekan == 2) {
            $request->validate([
                'pesan_revisi' => 'required|string'
            ]);

            $sk_honor->id_status_sk_honor = 1;
            $sk_honor->pesan_revisi = $request->pesan_revisi;
            $sk_honor->save();
            return redirect()->route('dekan.honor-sempro.index')->with("verif_dekan", 'Honorarium berhasil ditarik, status kembali menjadi "Draft"');
        } else if ($request->verif_dekan == 1) {
            $sk_honor->id_status_sk_honor = 6;
            $sk_honor->pesan_revisi = null;
            $sk_honor->save();
            return redirect()->route('dekan.honor-sempro.index')->with('verif_dekan', 'verifikasi honorarium berhasil, status SK saat ini "Disetujui Dekan"');
        }
    }
}