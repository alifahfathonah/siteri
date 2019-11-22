@extends('layouts.template')

@section('side_menu')
   @include('include.keuangan_menu')
@endsection

@section('page_title')
	Daftar Honorarium SK Sempro
@endsection

@section('css_link')
   <link rel="stylesheet" type="text/css" href="/css/custom_style.css">
   <style type="text/css">
      table{
         font-size: 16px;
      }

      table th{
         text-align: center;
      }

      .revisi_wrap{
        padding: 5px;
      }

      .revisi_wrap h4{
        color: red;
      }

      .jml_total td{
         font-weight: bold;
         background-color: white;
      }

      td span {
         float: right;
      }
   </style>
@endsection

@section('judul_header')
	Honorarium SK Sempro
@endsection

@section('content')
   <button id="back_top" class="btn bg-black" title="Kembali ke Atas"><i class="fa fa-arrow-up"></i></button>
   <input type="hidden" name="status">
   <div class="row">
      <div class="col-xs-12" id="top_title">
         <div class="box box-success">
            <div class="box-header">
               <h3 class="box-title">Honorarium SK Sempro</h3>
               <span style="margin-left: 5px;">
                 @if($sk_honor->verif_kebag_keuangan == 2)
                 <label class="label bg-red">Butuh Revisi (BPP)</label>
                 @elseif($sk_honor->verif_ktu == 2) 
                 <label class="label bg-red">Butuh Revisi (KTU)</label>
                 @elseif($sk_honor->verif_wadek2 == 2) 
                 <label class="label bg-red">Butuh Revisi (Wadek 2)</label>
                 @endif
               </span>

               <div class="box-tools pull-right">
                <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>

            <div class="box-body">
               {{-- <div class="form-group" style="float: right;">
                  @if($sk_honor->verif_kebag_keuangan != 1) 
                     <a href="{{ route('keuangan.honor-sempro.edit', $sk_honor->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Ubah</a>
                  @endif
                  
                  @if ($sk_honor->verif_dekan == 1)
                     <a href="{{ route('keuangan.honor-skripsi.cetak', $sk_honor->id) }}" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
                  @endif
               </div> --}}

               <p>Tanggal SK : {{Carbon\Carbon::parse($sk_honor->created_at)->locale('id_ID')->isoFormat('D MMMM Y')}}</p>
               <p>Sesuai SK Dekan: {{ $sk_honor->sk_sempro->no_surat }}/UN 25.1.15/SP/{{Carbon\Carbon::parse($sk_honor->sk_sempro->created_at)->year}}</p>

               <h4><b>Progres Daftar Honor ini: </b></h4>
               <div class="tl_wrap">
                 <div class="item_tl" id="progres_1">
                   <div><i></i></div>
                   <h4>Disimpan</h4>
                 </div>

                 <div class="item_tl" id="progres_2">
                   <div><i></i></div>
                   <h4>Dikirim</h4>
                 </div>

                 <div class="item_tl" id="progres_3">
                   <div><i></i></div>
                   <h4>Disetujui BPP</h4>
                 </div>

                 <div class="item_tl" id="progres_4">
                   <div><i></i></div>
                   <h4>Disetujui KTU</h4>
                 </div>

                 <div class="item_tl" id="progres_5">
                   <div><i></i></div>
                   <h4>Disetujui Wadek 2</h4>
                 </div>

                 <div class="item_tl" id="progres_6">
                   <div><i></i></div>
                   <h4>Disetujui Dekan</h4>
                 </div>
               </div>
                 
               @if(!is_null($sk_honor->pesan_revisi))
                 <div class="revisi_wrap">
                  <h4><b>Pesan Revisi</b> : </h4>
                  <p>"{{ $sk_honor->pesan_revisi }}"</p>
                 </div>
               @endif
            </div>
         </div>
      </div>
   </div>

   <div class="row">
   	<div class="col-xs-12">
   		<div class="box box-danger">
   			<div class="box-header">
   				<h3 class="box-title">Daftar Honor Pembahas Sempro }}</h3>

               <div class="box-tools pull-right">
                     <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                     </button>
                     <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                   </button>
               </div>
   			</div>

   			<div class="box-body">
               <div class="table-responsive">
                  <table id="dataTable2" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Pembahas I/II</th>
                           <th>NPWP</th>
                           <th>Nama Mahasiswa/NIM</th>
                           <th>Gol</th>
                           <th>Honorarium</th>
                           <th>PPH psl 5%-15%</th>
                           <th>Penerimaan</th>
                        </tr>
                     </thead>

                     <tbody id="tbl_penguji">
                        @php $no=0; $total_honor=0; $total_pph=0; $total_penerimaan=0; @endphp
                        @foreach($detail_skripsi as $item)
                           <tr id="{{ $no+=1 }}">
                              <td>{{ $no }}</td>
                              <td>{{ $item->surat_tugas[0]->dosen1->nama }}</td>
                              <td>{{ $item->surat_tugas[0]->dosen1->npwp }}</td>
                              <td rowspan="2">
                                 <p>{{ $item->skripsi->mahasiswa->nama_mhs }}</p>
                                 <p>NIM: {{ $item->skripsi->nim }}</p>
                              </td>
                              <td>{{ $item->surat_tugas[0]->dosen1->golongan->golongan }}</td>
                              <td id="penguji_{{$no}}" class="pengujiHonor">Rp 
                                 {{ number_format($sk_honor->detail_honor->histori_besaran_honor->jumlah_honor, 0, ",", ".") }}
                              </td>
                              <td class="pph" id="pph_{{$no}}">Rp
                                 @php
                                    $pph = ($item->surat_tugas[0]->dosen1->golongan->pph * $sk_honor->detail_honor->histori_besaran_honor->jumlah_honor)/100;
                                 @endphp
                                 {{ number_format($pph, 0, ",", ".") }}
                              </td>
                              <td class="penerimaan" id="penerimaan_{{$no}}">Rp
                                 @php
                                    $penerimaan = $sk_honor->detail_honor->histori_besaran_honor->jumlah_honor - $pph;
                                 @endphp
                                 {{ number_format($penerimaan, 0, ",", ".") }}
                              </td>

                              @php
                                 $total_honor+=$sk_honor->detail_honor->histori_besaran_honor->jumlah_honor;
                                 $total_pph+=$pph;
                                 $total_penerimaan+=$penerimaan;
                              @endphp
                           </tr>

                           <tr id="{{ $no+=1 }}">
                              <td>{{ $no }}</td>
                              <td>{{ $item->surat_tugas[0]->dosen2->nama }}</td>
                              <td>{{ $item->surat_tugas[0]->dosen2->npwp }}</td>
                              <td>{{ $item->surat_tugas[0]->dosen2->golongan->golongan }}</td>
                              <td id="penguji_{{$no}}" class="pengujiHonor">Rp
                                 {{ number_format($sk_honor->detail_honor->histori_besaran_honor->jumlah_honor, 0, ",", ".") }}
                              </td>
                              <td class="pph" id="pph_{{$no}}">Rp
                                 @php
                                    $pph = ($item->surat_tugas[0]->dosen2->golongan->pph * $sk_honor->detail_honor->histori_besaran_honor->jumlah_honor)/100;
                                 @endphp
                                 {{ number_format($pph, 0, ",", ".") }}
                              </td>
                              <td class="penerimaan" id="penerimaan_{{$no}}">Rp
                                 @php
                                    $penerimaan = $sk_honor->detail_honor->histori_besaran_honor->jumlah_honor - $pph;
                                 @endphp
                                 {{ number_format($penerimaan, 0, ",", ".") }}
                              </td>

                              @php
                                $total_honor+=$sk_honor->detail_honor->histori_besaran_honor->jumlah_honor;
                                $total_pph+=$pph;
                                $total_penerimaan+=$penerimaan;
                              @endphp
                           </tr>
                        @endforeach

                        <tr class="jml_total">
                           <td colspan="5" style="text-align: center;">Jumlah</td>
                           <td>Rp {{ number_format($total_honor, 0, ",", ".") }}</td>
                           <td>Rp {{ number_format($total_pph, 0, ",", ".") }}</td>
                           <td>Rp {{ number_format($total_penerimaan, 0, ",", ".") }}</td>
                        </tr>
                        
                        <tr>
                           <td colspan="8">Terbilang: </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
   			</div>
   		</div>
   	</div>
   </div>
@endsection

@section('script')
   <script src="/js/btn_backTop.js"></script>
   <script type="text/javascript">
      var status = @json($sk_honor->id_status_sk_honor);
      for (var i = status; i > 0; i--) {
         $("#progres_"+i).addClass('verified');
         $("#progres_"+i).find('i').addClass('fa fa-check');
      }

      // var detail_sk = @json($detail_skripsi);
      // var honor_pembimbing = @json($sk_honor->detail_honor->histori_besaran_honor->jumlah_honor);
      // var honor_penguji = @json($sk_honor->detail_honor->histori_besaran_honor->jumlah_honor);

      // $(".pembimbingHonor").children('span').text(honor_pembimbing);

      // var no = 0;
      // $.each(detail_sk, function(index, val){
      //    no+=1;
      //    var pph1 = (honor_pembimbing * val.pembimbing_utama.golongan.pph)/100;
      //    var penerimaan1 = honor_pembimbing - pph1;
      //    $("#tbl_pembimbing").find("#pph_"+no).children('span').text(pph1);
      //    $("#tbl_pembimbing").find("#penerimaan_"+no).children('span').text(penerimaan1);

      //    no+=1;
      //    var pph2 = (honor_pembimbing * val.pembimbing_pendamping.golongan.pph)/100;
      //    var penerimaan2 = honor_pembimbing - pph2;
      //    $("#tbl_pembimbing").find("#pph_"+no).children('span').text(pph2);
      //    $("#tbl_pembimbing").find("#penerimaan_"+no).children('span').text(penerimaan2);
      // });

      
      // $(".pengujiHonor").children('span').text(honor_penguji);
      // var nomor = 0;
      // $.each(detail_sk, function(index, val){
      //    nomor+=1;
      //    var pph1 = (honor_penguji * val.penguji_utama.golongan.pph)/100;
      //    var penerimaan1 = honor_penguji - pph1;
      //    $("#tbl_penguji").find("#pph_"+nomor).children('span').text(pph1);
      //    $("#tbl_penguji").find("#penerimaan_"+nomor).children('span').text(penerimaan1);

      //    nomor+=1;
      //    var pph2 = (honor_penguji * val.penguji_pendamping.golongan.pph)/100;
      //    var penerimaan2 = honor_penguji - pph2;
      //    $("#tbl_penguji").find("#pph_"+nomor).children('span').text(pph2);
      //    $("#tbl_penguji").find("#penerimaan_"+nomor).children('span').text(penerimaan2);
      // });
   </script>
@endsection