@extends('layouts.template')

@section('side_menu')
   @include('include.wadek2_menu')
@endsection

@section('page_title')
	Detail SK Sempro
@endsection

@section('css_link')
  <link rel="stylesheet" type="text/css" href="/css/custom_style.css">
	<style type="text/css">
		.tbl_row{
			display: table;
			width: 100%;
			border-bottom: 0.1px solid black;
			margin-top: 5px;
		}

		#tgl_sk{
			margin-top: 15px;
		}

		.box-body{
         width: 70%;
         margin: auto;
         margin-bottom: 20px;
         margin-top: 20px;
         font-family: 'Times New Roman';
         font-size: 16px;
         padding: 20px 50px;
         border: 1px solid black;
      }

      .landscape{
    	 width: 95%;
    	 padding: 20px 15px;
      }

		#kop_surat{
		   padding: 5px;
		   overflow: hidden;
		   border-bottom: 3px solid black;
		}

		#logo{
		   float: left;
		   width: 15%;
		}

		#logo img{
		   width: 100%;
		   height: auto;
		   margin-top: 10pt;

		}

		#keterangan_kop{
		   width: 85%;
		   float: left;
		   text-align: center;
		}

		#body_surat{
		   text-align: justify-all;
		}

		.top-title{
		   margin-top: 10px;
		   text-align: center;
		}

		.judul_surat{
		   font-size: 18px;
		   /*text-decoration: underline;*/
		   letter-spacing: 2pt;
		   font-weight: bold;
		}

		#detail_table{
			margin-top: 15px;
			width: 100%;
			border-collapse: collapse;
		}

		#detail_table th{
			text-align: center;
		}

		#detail_table td, th{
			border: 1px solid black;
			padding: 5px;
		}

		#detail_table td:last-child{
			padding: 0;
		}

      #detail_table td:nth-child(5){
         width: 300px;
      }

		#isi_template_surat{
			width: 100%;
		}

		#isi_template_surat table:nth-child(2) tr:nth-child(6){
			page-break-after: always;
		}

		.ttd-right{
         float: right;
    }

    .right-margin{
    	margin-right: 60px;
    }
	</style>
@endsection

@section('judul_header')
	SK Sempro
@endsection

@section('content')
  <button id="back_top" class="btn bg-black" title="Kembali ke Atas"><i class="fa fa-arrow-up"></i></button>
	<div class="row">
		<div class="col-xs-12">
   		<div class="box box-primary">
   			<div class="box-header">
              <h3 class="box-title">Data SK Sempro </h3>

              <div id="tgl_sk">
              		<h5><b>Tanggal Dibuat</b> : {{Carbon\Carbon::parse($sk->created_at)->locale('id_ID')->isoFormat('D MMMM Y')}}</h5>
              </div>
            </div>

            <div class="box-body">
            	<div id="kop_surat">
            	   <div id="logo">
            	      <img src="{{ asset('/image/logo-unej.png') }}">
            	   </div>

            	   <div id="keterangan_kop">
            	      <span class="header_18">KEMENTERIAN RISET, TEKNOLOGI, DAN PENDIDIKAN TINGGI</span><br>
            	      <span class="header_18">UNIVERSITAS JEMBER</span><br>
            	      <span class="header_18">FAKULTAS ILMU KOMPUTER</span>

            	      <br>

            	      <span>Jalan Kalimantan No. 37 Kampus Tegal Boto Jember 68121</span><br>
            	      <span>Telepon 0331 326935, Faximile 0331 326911</span><br>
            	      <span>Website : <i class="underline">www.ilkom.unej.ac.id</i></span>
            	   </div>
            	</div>

            	<div id="body_surat">
            	   <p class="top-title">
            	      <span class="judul_surat">KEPUTUSAN</span><br>
            	      <span>DEKAN FAKULTAS ILMU KOMPUTER UNIVERSITAS JEMBER</span><br>
            	      <span>Nomor: {{ $sk->no_surat }}/UN25.1.15/SP/{{ Carbon\Carbon::parse($sk->created_at)->year }}</span><br>
            	      <small><b>tentang</b></small><br>
            	      <span>PENETAPAN DOSEN PEMBAHAS SEMINAR PROPOSAL SKRIPSI MAHASISWA</span><br>
            	      <span>FAKULTAS ILMU KOMPUTER UNIVERSITAS JEMBER</span><br>
            	      <span>TAHUN AKADEMIK {{ $tahun_akademik['tahun_awal'].'/'.$tahun_akademik['tahun_akhir'] }}</span><br>
            	   </p>

            	   <div id="isi_template_surat">
            	   	{!! $sk->template->isi !!}
            	   </div>
                   <br>
            	   <div class="ttd-right">
            	   	{{-- <br> --}}
            	      Jember, {{ Carbon\Carbon::parse($sk->created_at)->locale('id_ID')->isoFormat('D MMMM Y') }} <br>
            	      Dekan,
            	      <br><br><br><br>
            	      <span><b>{{ $dekan->nama }}</b></span><br>
            	      <span>NIP. {{ $dekan->no_pegawai }}</span>
            	   </div>

            	   <p style="clear: both;">Tembusan: </p>
            	   <ol>
            	      <li>Penjabat Wakil Dekan I, II;</li>
            	      <li>Kasubag. Tata Usaha;</li>
            	   </ol>
            	   <span>Fakultas Ilmu Komputer Universitas Jember.</span>
            	</div>
            </div>

            <div class="box-body landscape">
            	<p>Lampiran Dekan Fakultas Ilmu Komputer Universitas Jember</p>
            	<table id="tabel_keterangan">
            		<tr>
            			<td>Nomor	</td>
            			<td>: {{ $sk->no_surat }}//UN25.1.15/SP/{{ Carbon\Carbon::parse($sk->created_at)->year }}</td>
            		</tr>
            		<tr>
            			<td>Tanggal	</td>
            			<td>: {{ Carbon\Carbon::parse($sk->created_at)->locale('id_ID')->isoFormat('D MMMM Y') }}</td>
            		</tr>
            		<tr>
            			<td>Tentang		</td>
                    <td>: Penetapan Dosen Pembahas Seminar Porposal Skripsi Mahasiswa Fakultas Ilmu Komputer Jember Tahun Akademik {{ $tahun_akademik['tahun_awal'].'/'.$tahun_akademik['tahun_akhir'] }}</td>
            		</tr>
            	</table>
         		<table id="detail_table">
            		<thead>
	            		<tr>
                        <th>No</th>
	            			<th>NIM</th>
	            			<th>Nama Mahasiswa</th>
	            			<th>Program Studi</th>
	            			<th>Judul Skripsi</th>
	            			<th>Dosen Pembahas</th>
	            		</tr>
	            	</thead>
	            	<tbody>
	            		@foreach($detail_skripsi as $item)
            			<tr>
                        <td>{{ $loop->index + 1 }}</td>
            				<td>{{$item->skripsi->nim}}</td>
            				<td>{{$item->skripsi->mahasiswa->nama}}</td>
            				<td>{{$item->skripsi->mahasiswa->prodi->nama}}</td>
            				<td>{{$item->judul}}</td>
            				<td>
            					<div class="tbl_row">
            						{{ $item->surat_tugas[0]->dosen1->nama }}
            					</div>
            					<div>
            						{{ $item->surat_tugas[0]->dosen2->nama }}
            					</div>
            				</td>
            			</tr>
	            		@endforeach
	            	</tbody>
	            </table>
                <br>
	            <div class="ttd-right">
	            	{{-- <br> --}}
	               Dekan,
	               <br><br><br><br>
	               <span><b>{{ $dekan->nama }}</b></span><br>
	               <span>NIP. {{ $dekan->no_pegawai }}</span>
	            </div>
            </div>

            <div class="box-footer">
               <a href="{{ route('wadek2.sk-sempro.index') }}" class="btn btn-default pull-right">Kembali</a>
            </div>
   		</div>
      </div>
	</div>

@endsection

@section('script')
<script src="/js/btn_backTop.js"></script>
@endsection
