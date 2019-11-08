<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\surat_tugas;
use App\detail_skripsi;
use App\skripsi;
use PDF;
use Exception;
use App\User;
use App\keris;
use App\mahasiswa;
use Carbon\Carbon;

class sutgasPembahasController extends suratTugasController
{

    public function index()
    {
        $surat_tugas = surat_tugas::with(['tipe_surat_tugas', 'status_surat_tugas', 'detail_skripsi', 'detail_skripsi.skripsi.mahasiswa'])
            ->whereHas('tipe_surat_tugas',function(Builder $query){
                $query->where('tipe_surat','Surat Tugas pembahas');
            })->orderBy('created_at', 'desc')->get();
            // dd($surat_tugas);
        return view('akademik.sutgas_pembahas.index', ['surat_tugas' => $surat_tugas]);
    }

    public function create()
    {
        $mahasiswa = mahasiswa::with(['skripsi', 'skripsi.status_skripsi'])
        ->whereHas('skripsi.status_skripsi', function(Builder $query)
        {
            $query->where('status', 'Sudah punya pembimbing');
        })->get();
        $dosen = user::where('is_dosen', 1)->get();
        // dd($mahasiswa);
        return view('akademik.sutgas_pembahas.create', ['mahasiswa' => $mahasiswa, 'dosen' => $dosen]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nim' => 'required',
            'no_surat' => 'required',
            'judul_inggris' => 'required',
            'tanggal' => 'required',
            'tempat' => 'required',
            'id_pembahas1' => 'required',
            'id_pembahas2' => 'required',
            'status' => 'required'
        ]);
        try {
            $skripsi = skripsi::select('id')->where('nim',$request->input('nim'))->first();
            $detail_skripsi = $this->update_detail_skripsi($request,$skripsi->id);
            $id_baru = $this->store_sutgas(
                $request,
                2,
                $request->status,
                $detail_skripsi->id,
                'id_pembahas1',
                'id_pembahas2'
            );
            return redirect()->route('akademik.sutgas-pembahas.show', $id_baru)->with('success', 'Data Surat Tugas Berhasil Ditambahkan');
        } catch (Exception $e) {
            return redirect()->route('akademik.sutgas-pembahas.create')->with('error', $e->getMessage());
        }
    }

    private function update_detail_skripsi($request, int $id_skripsi){
        detail_skripsi::select('id')
            ->where('id_skripsi', $id_skripsi)
            ->orderBy('created_at','desc')
            ->update([
                'judul_inggris' => $request->input('judul_inggris'),
        ]);
        $detail_skripsi = detail_skripsi::where('id_skripsi', $id_skripsi)->orderBy('created_at', 'desc')->first();
        return $detail_skripsi;
    }

    public function show($id)
    {
        $surat_tugas = surat_tugas::where('id', $id)
        ->with([
            "status_surat_tugas",
            "detail_skripsi",
            "detail_skripsi.skripsi.mahasiswa",
            "detail_skripsi.keris",
            "dosen1:no_pegawai,nama",
            "dosen2:no_pegawai,nama"
        ])->first();
        // dd($surat_tugas);
      return view('akademik.sutgas_pembahas.show', [
        'surat_tugas' => $surat_tugas
      ]);
    }

    public function edit($id)
    {
        $surat_tugas = surat_tugas::where('id', $id)
        ->with([
            "detail_skripsi",
            "detail_skripsi.skripsi.mahasiswa",
            "detail_skripsi.keris",
            "dosen1:no_pegawai,nama",
            "dosen2:no_pegawai,nama"
        ])->first();

        // $sutgas_pembimbing = surat_tugas::with(['detail_skripsi', 'tipe_surat_tugas', 'status_surat_tugas'])
        // ->wherehas('detail_skripsi', function(Builder $query)
        // {
        //     $query->where('id', $surat_tugas->detail_skripsi->id);
        // })
        // ->wherehas('tipe_surat_tugas', function(Builder $query)
        // {
        //     $query->where('tipe_surat', 'Surat tugas pembimbing');
        // })
        // ->wherehas('status_surat_tugas', function(Builder $query)
        // {
        //     $query->where('status', 'Diverifikasi KTU');
        // })
        // ->max('created_at')->first();

        $pembimbing = $this->getPembimbing($surat_tugas->detail_skripsi->skripsi->nim);

        $t = carbon::parse($surat_tugas->tanggal)->toDateString();
        $j = carbon::parse($surat_tugas->tanggal)->format('h:i');
        $tanggal = $t.'T'.$j;
        $mahasiswa = mahasiswa::with(['skripsi', 'skripsi.status_skripsi'])
        ->whereHas('skripsi.status_skripsi', function(Builder $query)
        {
            $query->where('status', 'Sudah punya pembimbing');
        })->orWhere("nim", $surat_tugas->detail_skripsi->skripsi->nim)->get();
        $dosen = user::where('is_dosen', 1)->get();
        // dd($mahasiswa);

        return view('akademik.sutgas_pembahas.edit', [
            'surat_tugas' => $surat_tugas,
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen,
            'tanggal' => $tanggal,
            'pembimbing' => $pembimbing
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_detail_skripsi' => 'required',
            'no_surat' => 'required',
            'id_pembahas1' => 'required',
            'id_pembahas2' => 'required',
            'status' => 'required'
        ]);
        try {
            $this->update_sutgas($request, 2, $request->status, $id);
            $this->update_detail_skripsi(
                $request,
                $id,
                'id_surat_tugas_pembahas',
                'id_pembahas1',
                'id_pembahas2'
            );


            return redirect()->route('akademik.sutgas-pembahas.show', $id)->with('success', 'Data Surat Tugas Berhasil Dirubah');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->route('akademik.sutgas-pembahas.edit', $id)->with('error', $e->getMessage());
        }
    }

    public function cetak_pdf($id)
    {
        $surat_tugas = surat_tugas::where('id', $id)
        ->with([
            "detail_skripsi",
            "detail_skripsi.skripsi.mahasiswa",
            "detail_skripsi.skripsi.mahasiswa.bagian",
            "detail_skripsi.keris",
            "dosen1:no_pegawai,nama,id_fungsional",
            "dosen1.fungsional",
            "dosen2:no_pegawai,nama,id_fungsional",
            "dosen2.fungsional"
        ])->first();

        $sutgas_pembimbing = surat_tugas::where('id_detail_skripsi', $surat_tugas->id_detail_skripsi)
        ->with([
            "status_surat_tugas",
            "tipe_surat_tugas",
            "detail_skripsi",
            "dosen1:no_pegawai,nama,id_fungsional",
            "dsoen1.fungsional",
            "dosen2:no_pegawai,nama,id_fungsional",
            "dosen2.fungsional"
        ])
        ->whereHas('tipe_surat_tugas', function(Builder $query)
        {
            $query->where('tipe_surat', 'Surat tugas pembimbing');
        })
        ->max('created_at')->first();

        $dekan = User::with("jabatan")
        ->wherehas("jabatan", function (Builder $query){
            $query->where("jabatan", "Dekan");
        })->first();

        // return view('akademik.sutgas_pembimbing.pdf', ['surat_tugas' => $surat_tugas, 'dekan' => $dekan]);

        $pdf = PDF::loadview('akademik.sutgas_pembahas.pdf', [
            'surat_tugas' => $surat_tugas,
            'sutgas_pembimbing' => $sutgas_pembimbing,
            'dekan' => $dekan
        ])->setPaper('folio', 'portrait')->setWarnings(false);
        return $pdf->download("Sutgas_Pembahas-" . $surat_tugas->no_surat);
    }

    //KTU
    public function ktu_index()
    {
        $surat_tugas = surat_tugas::with(['tipe_surat_tugas', 'status_surat_tugas', 'detail_skripsi', 'detail_skripsi.skripsi.mahasiswa'])
            ->whereHas('tipe_surat_tugas',function(Builder $query){
                $query->where('tipe_surat','Surat Tugas Pembahas');
            })
            ->whereHas('status_surat_tugas', function (Builder $query){
                $query->whereIn('status', ['Dikirim', 'Disetujui KTU']);
            })
            ->orderBy('updated_at', 'desc')->get();

        // dd($surat_tugas);
        return view('ktu.sutgas_akademik.index', [
            'surat_tugas' => $surat_tugas,
            'tipe' => 'surat tugas pembahas'
        ]);
    }

    public function ktu_show($id)
    {
        $surat_tugas = surat_tugas::where('id', $id)
        ->with([
            "detail_skripsi",
            "detail_skripsi.skripsi.mahasiswa",
            "detail_skripsi.skripsi.mahasiswa.bagian",
            "detail_skripsi.keris",
            "dosen1:no_pegawai,nama,id_fungsional",
            "dosen1.fungsional",
            "dosen2:no_pegawai,nama,id_fungsional",
            "dosen2.fungsional"
        ])->first();

        $sutgas_pembimbing = surat_tugas::where('id_detail_skripsi', $surat_tugas->id_detail_skripsi)
        ->with([
            "status_surat_tugas",
            "tipe_surat_tugas",
            "detail_skripsi",
            "dosen1:no_pegawai,nama,id_fungsional",
            "dsoen1.fungsional",
            "dosen2:no_pegawai,nama,id_fungsional",
            "dosen2.fungsional"
        ])
        ->whereHas('tipe_surat_tugas', function(Builder $query)
        {
            $query->where('tipe_surat', 'Surat tugas pembimbing');
        })
        ->max('created_at')->first();

        $dekan = User::with("jabatan")
        ->wherehas("jabatan", function (Builder $query){
            $query->where("jabatan", "Dekan");
        })->first();
        // dd($surat_tugas);
      return view('ktu.sutgas_akademik.show_pembahas', [
        'surat_tugas' => $surat_tugas,
        'sutgas_pembimbing' => $sutgas_pembimbing,
        'dekan' => $dekan,
        'tipe' => 'surat tugas pembahas'
      ]);
    }

    public function ktu_verif(Request $request, $id)
    {
        $surat_tugas = surat_tugas::find($id);
        $surat_tugas->verif_ktu = $request->verif_ktu;
        if($request->verif_ktu == 2){
            $request->validate([
                'pesan_revisi' => 'required|string'
            ]);
            $surat_tugas = $this->verif($surat_tugas, 1, $request->pesan_revisi);
            $surat_tugas->save();
            return redirect()->route('ktu.sutgas-pembahas.index')->with("verif_ktu", 'Surat tugas berhasil ditarik, status kembali menjadi "Draft"');
        }
        else if ($request->verif_ktu == 1) {
            $surat_tugas = $this->verif($surat_tugas,3,null);
            $surat_tugas->save();
            return redirect()->route('ktu.sutgas-pembahas.show', $id)->with('verif_ktu', 'verifikasi surat tugas berhasil, status surat tugas saat ini "Disetujui KTU"');
        }
    }
}
