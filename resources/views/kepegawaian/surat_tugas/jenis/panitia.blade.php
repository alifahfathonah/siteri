<div class="box-body surat">
    <div id="kop_surat">
       <div id="logo">
          <img src={{ asset("image/logo-unej.png") }}>
       </div>

       <div id="keterangan_kop">
          <span class="header_14">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</span><br>
          <span class="header_14">UNIVERSITAS JEMBER</span><br>
          <span class="header_14">FAKULTAS ILMU KOMPUTER</span>
          <br>
          <span>Jalan Kalimantan No. 37 Kampus Tegal Boto Jember 68121</span><br>
          <span>Telepon 0331 326935, Faximile 0331 326911</span><br>
          <span>Website : <i class="underline">www.ilkom.unej.ac.id</i></span>
       </div>
    </div>

    <div id="body_surat" class="margin-body">
       <p class="top-title">
          <span class="judul_surat">SURAT TUGAS</span><br>
          <span>Nomor: {{  $surat_tugas->nomor_surat}}/UN25.1.15/KP/{{ Carbon\Carbon::parse($surat_tugas->created_at)->year }}</span>
       </p>

       <p style="margin-bottom: 0pt;">
          Wakil Dekan II Fakultas Ilmu Komputer Universitas Jember, dengan ini menugaskan kepada :
       </p>

       <table>
 <thead>
 <tr>
    <th width="20" style="text-align: center;">No</th>
    <th style="text-align: center" width="60%">Nama</th>
    <th style="text-align: center">Jabatan</th>
 </tr>
 </thead>
 <tbody>
      @foreach ($dosen_tugas as $key => $dosen)
      <tr>
          <td style="text-align: center; width: 10%">{{$key+1}}</td>
          <td><span>{{$dosen->user['nama']}}</span><br/><span>{{$dosen->user['no_pegawai']}}</span></td>
          <td >{{$dosen->jabatan}}</td>
      </tr>
      @endforeach


 </tbody>
</table>
<div class="deskripsi">
Sebagai {{$surat_tugas->jenis_sk['jenis']}} untuk Kegiatan {{$surat_tugas->keterangan}} yang akan dilaksanakan pada tanggal {{ Carbon\Carbon::parse($surat_tugas->started_at)->locale('id_ID')->isoFormat('D MMMM Y') }} - {{ Carbon\Carbon::parse($surat_tugas->end_at)->locale('id_ID')->isoFormat('D MMMM Y') }} yang bertempat di {{$surat_tugas->lokasi}}.
</div>
<div style="margin-top: 20px;">
  Demikian surat tugas ini dikeluarkan untuk dilaksanakan dengan penuh rasa tanggung jawab.
</div>
       <div class="ttd-right">
          Jember, {{ Carbon\Carbon::parse($surat_tugas->created_at)->locale('id_ID')->isoFormat('D MMMM Y') }} <br>
          Wakil Dekan II,
          <br><br><br>
          <span><b>Windi Eka Yulia Retnani, S. Kom., MT</b></span><br>
          <span>NIP. 198403052010122002</span>
       </div>

       
    </div>
 </div>