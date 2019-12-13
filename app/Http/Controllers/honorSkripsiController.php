<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\sk_skripsi;
use App\detail_skripsi;
use App\histori_besaran_honor;
use App\nama_honor;
use App\sk_honor;
use App\User;
use App\detail_honor;
use PDF;
use Exception;
use Carbon\Carbon;

class honorSkripsiController extends Controller
{
    public function index()
    {
        $sk = sk_skripsi::where('verif_ktu', 1)
        ->orderBy('created_at', 'desc')
        ->with(['status_sk', 'sk_honor', 'sk_honor.status_sk_honor'])
        ->get();

        // dd($sk_sempro);
        return view('keuangan.honor_sk.index', [
            'sk' => $sk,
            'tipe' => 'SK Skripsi'
        ]);
    }

    // public function pilih_sk()
    // {
    //     $sk_akademik = sk_akademik::with(['tipe_sk', 'status_sk_akademik', 'detail_sk'])
    //     ->whereHas('tipe_sk', function(Builder $query)
    //     {
    //         $query->where('id', 1);
    //     })
    //     ->whereHas('detail_sk',function(Builder $query)
    //     {
    //         $query->whereNull('id_sk_honor');
    //     })
    //     ->where('verif_dekan',1)
    //     ->orderBy('created_at', 'desc')->get();
    //     // dd($sk_akademik);
    // 	return view('keuangan.honor_sk.pilih_sk', [
    //         'sk_akademik' => $sk_akademik,
    //         'tipe' => 'SK Skripsi'
    //     ]);
    // }

    public function store($id_sk_skripsi)
    {
        try {
        $sk_honor = sk_honor::create();
        sk_skripsi::where('id',$id_sk_skripsi)->update(['id_sk_honor' => $sk_honor->id]);
        $besaran_honor = nama_honor::with('besaran_honor_terbaru')
                ->where('nama_honor', 'Honor Pembimbing Utama Dengan Jabatan Fungsional')
                ->orWhere('nama_honor', 'Honor Pembimbing Utama Tanpa Jabatan Fungsional')
                ->orWhere('nama_honor', 'Honor Pembimbing Pendamping Dengan Jabatan Fungsional')
                ->orWhere('nama_honor', 'Honor Pembimbing Pendamping Tanpa Jabatan Fungsional')
                ->orWhere('nama_honor', 'Honor Penguji Utama Skripsi')
                ->orWhere('nama_honor', 'Honor Penguji Pendamping Skripsi')
                ->get();
        foreach($besaran_honor as $bh){
            detail_honor::create([
                'id_sk_honor' => $sk_honor->id,
                'id_histori_besaran_honor' => $bh->besaran_honor_terbaru->id
            ]);
        }
            return redirect()->route('keuangan.honor-skripsi.show', $sk_honor->id)->with('success', 'Data Berhasil Dibuat');
        }catch(Exception $e){
            dd($e->getMessage());
            return redirect()->route('keuangan.honor-skripsi.pilih-sk')->with('error', $e->getMessage());
        }
    }


    //pudj = Pembimbing Utama Dengan Jabatan
    //putj = Pembimbing Utama Tanpa Jabatan
    //ppdj = Pembimbing Pendamping Dengan Jabatan
    //pptj = Pembimbing Pendamping Tanpa Jabatan
    //pus = Penguji Utama Skripsi
    //pps = Penguji Pendamping Skripsi
    private function cari_honor (int $pudj, int $putj, int $ppdj, int $pptj, int $pus, int $pps, $id_sk_skripsi)
    {

        $detail_skripsi = detail_skripsi::where('id_sk_skripsi', $id_sk_skripsi)
            ->with([
                'sk_skripsi',
                'skripsi',
                'skripsi.mahasiswa',
                'surat_tugas' => function ($query) {
                    $query->where(
                        'id_tipe_surat_tugas', 1

                    )
                    ->orWhere('id_tipe_surat_tugas', 3)
                    ->where('id_status_surat_tugas', 3)
                    ->orderBy('created_at', 'desc');
                },
                'surat_tugas.dosen1:no_pegawai,nama,npwp,id_golongan,id_fungsional',
                'surat_tugas.dosen1.golongan',
                'surat_tugas.dosen1.fungsional',
                'surat_tugas.dosen2:no_pegawai,nama,npwp,id_golongan,id_fungsional',
                'surat_tugas.dosen2.golongan',
                'surat_tugas.dosen2.fungsional',
            ])->get();
        foreach($detail_skripsi as $dk){
            foreach($dk->surat_tugas as $st){
                if($st->id_tipe_surat_tugas == 3){
                    $st->dosen1->honorarium = $pus;
                    $st->dosen1->pph = $this->hitung_pph($pus, $st->dosen1->golongan->pph);
                    $st->dosen2->honorarium = $pps;
                    $st->dosen2->pph = $this->hitung_pph($pps, $st->dosen2->golongan->pph);
                }else{
                    if ($st->dosen1->fungsional->jab_fungsional == "Tenaga Pengajar"){
                        $st->dosen1->honorarium = $putj;
                        $st->dosen1->pph = $this->hitung_pph($putj, $st->dosen1->golongan->pph);
                    }else{
                        $st->dosen1->honorarium = $pudj;
                        $st->dosen1->pph = $this->hitung_pph($pudj, $st->dosen1->golongan->pph);
                    }
                    if ($st->dosen2->fungsional->jab_fungsional == "Tenaga Pengajar") {
                        $st->dosen1->honorarium = $pptj;
                        $st->dosen1->pph = $this->hitung_pph($pptj, $st->dosen1->golongan->pph);
                    } else {
                        $st->dosen2->honorarium = $ppdj;
                        $st->dosen1->pph = $this->hitung_pph($ppdj, $st->dosen1->golongan->pph);
                    }
                }
            }

        }
        return $detail_skripsi;
    }

    private function hitung_pph($honor,$pph){
        $jumlah_pph = $honor * ($pph/100);
        return $jumlah_pph;
    }

    public function show($id_sk_honor)
    {
        $sk_honor = sk_honor::where('id', $id_sk_honor)
        ->with([
            'sk_sempro',
            'status_sk_honor',
            'detail_honor',
            'detail_honor.histori_besaran_honor',
            'detail_honor.histori_besaran_honor.nama_honor'
        ])
        ->first();

        $honor_pembimbing1 = 0;
        $honor_pembimbing2 = 0;
        $honor_penguji1 = 0;
        $honor_penguji2 = 0;

        $detail_skripsi = detail_skripsi::where('id_sk_skripsi', $sk_honor->sk_skripsi->no_surat)
        ->with([
            'sk_skripsi',
            'skripsi',
            'skripsi.mahasiswa',
            'surat_tugas' => function($query)
            {
                $query->where('id_tipe_surat_tugas', 1)
                ->orWhere('id_tipe_surat_tugas', 3)
                ->orderBy('created_at', 'desc');
            },
            'surat_tugas.tipe_surat_tugas',
            'surat_tugas.dosen1:no_pegawai,nama,npwp,id_golongan',
            'surat_tugas.dosen1.golongan',
            'surat_tugas.dosen2:no_pegawai,nama,npwp,id_golongan',
            'surat_tugas.dosen2.golongan'
        ])->get();
        // dd($sk_honor);
        return  view('keuangan.honor_sk.show', [
            'sk_honor' => $sk_honor,
            'detail_skripsi' => $detail_skripsi
        ]);
    }

    public function status_dibayarkan($id_sk_honor)
    {
        sk_honor::where('id', $id_sk_honor)->update([
            'id_status_sk_honor' => 6
        ]);
        return redirect()->route('keuangan.honor-skripsi.show', $id_sk_honor)->with('success', 'Status berhasil diubah menjadi "Telah Dibayarkan"');
    }

    public function cetak_pdf($id_sk_honor)
    {
        $sk_honor = sk_honor::where('id', $id_sk_honor)
            ->with([
                'tipe_sk',
                'detail_sk.sk_akademik',
                'detail_sk.pembimbing_utama:no_pegawai,nama,npwp,id_golongan',
                'detail_sk.pembimbing_utama.golongan',

                'detail_sk.pembimbing_pendamping:no_pegawai,nama,npwp,id_golongan',
                'detail_sk.pembimbing_pendamping.golongan',

                'detail_sk.penguji_utama:no_pegawai,nama,npwp,id_golongan',
                'detail_sk.penguji_utama.golongan',

                'detail_sk.penguji_pendamping:no_pegawai,nama,npwp,id_golongan',
                'detail_sk.penguji_pendamping.golongan',
            ])
            ->first();
        // return view('keuangan.honor_sk.pdf', ['sk_honor' => $sk_honor]);
        $tipe = $sk_honor->tipe_sk->tipe;
        $tgl = Carbon::parse($sk_honor->created_at)->locale('id_ID')->isoFormat('D MMMM Y');
        $tanggal = new Carbon($sk_honor->detail_sk[0]->sk_akademik->created_at);
        $tahun = $tanggal->year;

        $awalSemester = Carbon::create($tahun, 1, 15);
        $akhirSemester = Carbon::create($tahun, 7, 31);
        if ($tanggal->isBetween($awalSemester, $akhirSemester)) {
            $tahun2 = $tanggal->subYear();
            $tahun2 = $tahun2->year;
            $pdf = PDF::loadview('keuangan.honor_sk.pdf', ['sk_honor' => $sk_honor,'tahun' => $tahun2,'tahun2' => $tahun,'thn_asli' => $tahun]);
        }else{
            $tahun2 = $tanggal->addYear();
            $tahun2 = $tahun2->year;
            $pdf = PDF::loadview('keuangan.honor_sk.pdf', ['sk_honor' => $sk_honor, 'tahun' => $tahun2, 'tahun2' => $tahun, 'thn_asli' => $tahun]);
        }
        return $pdf->download("Honor ".$tipe." ".$tgl);
    }

    public function edit($id_sk_honor)
    {
        $sk_honor = sk_honor::where('id', $id_sk_honor)
        ->with([
            'tipe_sk',
            'status_sk_honor',
            'detail_sk.pembimbing_utama:no_pegawai,nama,npwp,id_golongan',
            'detail_sk.pembimbing_utama.golongan',

            'detail_sk.pembimbing_pendamping:no_pegawai,nama,npwp,id_golongan',
            'detail_sk.pembimbing_pendamping.golongan',

            'detail_sk.penguji_utama:no_pegawai,nama,npwp,id_golongan',
            'detail_sk.penguji_utama.golongan',

            'detail_sk.penguji_pendamping:no_pegawai,npwp,nama,id_golongan',
            'detail_sk.penguji_pendamping.golongan',

            'detail_sk.sk_akademik'
        ])
        ->first();
        // dd($sk_honor);
        return  view('keuangan.honor_sk.edit', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Skripsi'
        ]);
    }

    public function update(Request $request, $id_sk_honor)
    {
        $this->validate($request, [
            'honor_pembimbing1' => 'required',
            'honor_pembimbing2' => 'required',
            'honor_penguji' => 'required',
        ]);

        try{
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

            sk_honor::where('id',$id_sk_honor)->update([
                'id_status_sk_honor' => $request->status,
                'honor_pembimbing1' => $request->honor_pembimbing1,
                'honor_pembimbing2' => $request->honor_pembimbing2,
                'honor_penguji' => $request->honor_penguji,
                'verif_kebag_keuangan' => $verif_bpp,
                'verif_ktu' => $verif_ktu,
                'verif_wadek2' => $verif_wadek2,
                'verif_dekan' => $verif_dekan
            ]);

            return redirect()->route('keuangan.honor-skripsi.show',$id_sk_honor)->with('success','Data Berhasil Dirubah');
        }catch(Exception $e){
            return redirect()->route('keuangan.honor-skripsi.edit', $id_sk_honor)->with('error', $e->getMessage());
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
        $sk_honor = sk_honor::where('id_tipe_sk', 1)
        ->orderBy('updated_at', 'desc')
        ->with(['tipe_sk', 'status_sk_honor'])
        ->whereHas('status_sk_honor', function(Builder $query){
            $query->whereIn('id', [2,3,4,5,6]);
        })->get();

        // dd($sk_honor);
        return view('bpp.honor_sk.honor_index', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Skripsi'
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
            return redirect()->route('bpp.honor-skripsi.index');
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
            return redirect()->route('bpp.honor-skripsi.index')->with("verif_bpp", 'Honorarium berhasil ditarik, status kembali menjadi "Draft"');
        } else if ($request->verif_bpp == 1) {
            $sk_honor->id_status_sk_honor = 3;
            $sk_honor->pesan_revisi = null;
            $sk_honor->save();
            return redirect()->route('bpp.honor-skripsi.index')->with('verif_bpp', 'Verifikasi honorarium berhasil, status honorarium saat ini "Disetujui BPP"');
        }
    }

    public function ktu_index()
    {
        $sk_honor = sk_honor::where('id_tipe_sk', 1)
        ->orderBy('updated_at', 'desc')
        ->with(['tipe_sk', 'status_sk_honor'])
        ->whereHas('status_sk_honor', function(Builder $query){
            $query->whereIn('id', [3,4,5,6]);
        })->get();

        // dd($sk_honor);
        return view('ktu.honor_sk.honor_index', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Skripsi'
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
            return redirect()->route('ktu.honor-skripsi.index');
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
            return redirect()->route('ktu.honor-skripsi.index')->with("verif_ktu", 'Honorarium berhasil ditarik, status kembali menjadi "Draft"');
        } else if ($request->verif_ktu == 1) {
            $sk_honor->id_status_sk_honor = 4;
            $sk_honor->pesan_revisi = null;
            $sk_honor->save();
            return redirect()->route('ktu.honor-skripsi.index')->with('verif_ktu', 'Verifikasi honorarium berhasil, status SK saat ini "Disetujui KTU"');
        }
    }

    public function wadek2_index()
    {
        $sk_honor = sk_honor::where('id_tipe_sk', 1)
        ->orderBy('updated_at', 'desc')
        ->with(['tipe_sk', 'status_sk_honor'])
        ->whereHas('status_sk_honor', function(Builder $query){
            $query->whereIn('id', [4,5,6]);
        })->get();

        // dd($sk_honor);
        return view('wadek2.honor_sk.honor_index', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Skripsi'
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
            return redirect()->route('wadek2.honor-skripsi.index');
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
            return redirect()->route('wadek2.honor-skripsi.index')->with("verif_wadek2", 'Honorarium berhasil ditarik, status kembali menjadi "Draft"');
        } else if ($request->verif_wadek2 == 1) {
            $sk_honor->id_status_sk_honor = 5;
            $sk_honor->pesan_revisi = null;
            $sk_honor->save();
            return redirect()->route('wadek2.honor-skripsi.index')->with('verif_wadek2', 'Verifikasi honorarium berhasil, status SK saat ini "Disetujui Wakil Dekan 2"');
        }
    }

    public function dekan_index()
    {
        $sk_honor = sk_honor::where('id_tipe_sk', 1)
        ->orderBy('updated_at', 'desc')
        ->with(['tipe_sk', 'status_sk_honor'])
        ->whereHas('status_sk_honor', function(Builder $query){
            $query->whereIn('id', [5,6]);
        })->get();

        // dd($sk_honor);
        return view('dekan.honor_sk.honor_index', [
            'sk_honor' => $sk_honor,
            'tipe' => 'SK Skripsi'
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
            return redirect()->route('dekan.honor-skripsi.index');
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
            return redirect()->route('dekan.honor-skripsi.index')->with("verif_dekan", 'Honorarium berhasil ditarik, status kembali menjadi "Draft"');
        } else if ($request->verif_dekan == 1) {
            $sk_honor->id_status_sk_honor = 6;
            $sk_honor->pesan_revisi = null;
            $sk_honor->save();
            return redirect()->route('dekan.honor-skripsi.index')->with('verif_dekan', 'verifikasi honorarium berhasil, status SK saat ini "Disetujui Dekan"');
        }
    }
}
