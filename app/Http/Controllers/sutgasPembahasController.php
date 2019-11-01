<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sutgasPembahasController extends suratTugasController
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_detail_skripsi' => 'required',
            'no_surat' => 'required',
            'id_pembahas1' => 'required',
            'id_pembahas2' => 'required',
            'status' => 'required'
        ]);
        try {
            $surat_tugas = $this->store_sutgas($request, 2, $request->status);
            detail_skripsi::where('id',$request->input('id_detail_skripsi'))->update([
                'id_surat_tugas_pembahas' => $surat_tugas->id,
                'id_pembahas1' => $request->input('id_pembahas1'),
                'id_pembahas2' => $request->input('id_pembahas2'),
            ]);
            return redirect()->route('akademik.sutgas-pembahas.index')->with('success', 'Data Surat Tugas Berhasil Ditambahkan');
        } catch (Exception $e) {
            return redirect()->route('akademik.sutgas-pembahas.create')->with('error', $e->getMessage());
        }
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
            detail_skripsi::where('id', $request->input('id_detail_skripsi'))->update([
                'id_surat_tugas_pembahas' => $surat_tugas->id,
                'id_pembahas1' => $request->input('id_pembahas1'),
                'id_pembahas2' => $request->input('id_pembahas2'),
            ]);
            return redirect()->route('akademik.sutgas-pembahas.edit', $id)->with('success', 'Data Surat Tugas Berhasil Dirubah');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->route('akademik.sutgas-pembahas.edit', $id)->with('error', $e->getMessage());
        }
    }
}
