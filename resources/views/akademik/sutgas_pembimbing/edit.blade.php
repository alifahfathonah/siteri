@extends('layouts.template')

@section('side_menu')
   @include('include.akademik_menu')
@endsection

@section('page_title')
	Ubah Surat Tugas Pembimbing Skripsi
@endsection

@section('css_link')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{asset('/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/css/custom_style.css')}}">
	<style type="text/css">
		form{
			width: 90%;
			margin: auto;
		}

		#nim, #nama_mhs{
			/*width: 80%;*/
		}

		#no_surat{
			width: 25%;
		}

		#format_nomor{
			font-size: 16px;
		}

		#btn_group{
			float: right;
			margin-right: 20px;
		}
	</style>
@endsection

@section('judul_header')
	Surat Tugas Pembimbing Skripsi
@endsection

@section('content')
	<div class="row">
   	<div class="col-xs-12">
   		<div class="box box-primary">
   			<div class="box-header">
               <h3 class="box-title">Ubah Surat Tugas Pembimbing Skripsi</h3>

               <br>
               <h5>Status surat tugas : {{ $surat_tugas->status_surat_tugas->status }}</h5>
            </div>
            <div class="col-xs-12">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Sukses</h4>
                    {{session('success')}}
                </div>
                @php
                Session::forget('success');
                @endphp
                @endif

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i>Error</h4>
                    {{session('error')}}
                @php
                Session::forget('error');
                @endphp
                @endif
            </div>
            <form action="{{route('akademik.sutgas-pembimbing.update',$surat_tugas->id)}}" method="post">
               @csrf
               @method('PUT')
               <div class="box-body">
                  <input type="hidden" name="id_detail_skripsi" value="{{$surat_tugas->detail_skripsi->id}}">
                  <input type="hidden" name="id_skripsi" value="{{$surat_tugas->detail_skripsi->id_skripsi}}">
                  <input type="hidden" name="original_nim" value="{{$surat_tugas->detail_skripsi->skripsi->nim}}">
                  <div class="form-group">
                     <label for="no_surat">No Surat</label><br>
                     <input type="text" name="no_surat" id="no_surat" value="{{ $surat_tugas->no_surat }}">
                     <span id="format_nomor">/UN25.1.15/SP/{{ Carbon\Carbon::today()->year }}</span>

                     @error('no_surat')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                           <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="nim">NIM Mahasiswa</label><br>
                           <select id="nim" name="nim" class="form-control select2">
                              <option value="">-- Pilih NIM --</option>
                              @foreach ($mahasiswa as $item)
                                 <option value="{{ $item->nim }}" {{ ($item->nim == $surat_tugas->detail_skripsi->skripsi->nim? 'selected':'' ) }}>{{ $item->nim }}</option>
                              @endforeach
                           </select>

                           @error('nim')
                              <span class="invalid-feedback" role="alert" style="color: red;">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                     </div>

                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="nama_mhs">Nama Mahasiswa</label>
                           <input type="text" name="nama_mhs" id="nama_mhs" class="form-control" readonly="" value="{{ $surat_tugas->detail_skripsi->skripsi->mahasiswa->nama }}">
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="id_keris">Keris</label><br>
                     <select id="id_keris" name="id_keris" class="form-control select2">
                        <option value="">-- Pilih Keris --</option>
                        @foreach ($keris as $item)
                           <option value="{{ $item->id }}" {{ ($item->id == $surat_tugas->detail_skripsi->id_keris? 'selected' : '') }}>
                              {{ $item->nama }}
                           </option>
                        @endforeach
                     </select>

                     @error('id_keris')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                           <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </div>

                  <div class="form-group">
                     <label for="judul">Judul Skripsi</label>
                     <textarea name="judul" id="judul" class="form-control" rows="3">{{ $surat_tugas->detail_skripsi->judul }}</textarea>

                     @error('judul')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                           <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </div>

                  <div class="form-group">
                     <label for="pembimbing_utama">Pembimbing Utama</label><br>
                     <select name="id_pembimbing_utama" id="id_pembimbing_utama" class="form-control select2">
                        <option value="">--Pilih Pembimbing Utama--</option>
                        @foreach ($dosen1 as $item)
                           <option value="{{ $item->no_pegawai }}" {{ ($item->no_pegawai == $surat_tugas->id_dosen1? 'selected':'') }}>
                              {{ $item->nama }}
                           </option>
                        @endforeach
                     </select>

                     @error('id_pembimbing_utama')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                            <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </div>

                  <div class="form-group">
                     <label for="pembimbing_pendamping">Pembimbing Pendamping</label><br>
                     <select name="id_pembimbing_pendamping" id="id_pembimbing_pendamping" class="form-control select2">
                        <option value="">--Pilih Pembimbing Pendamping--</option>
                        @foreach ($dosen2 as $item)
                           <option value="{{ $item->no_pegawai }}" {{ ($item->no_pegawai == $surat_tugas->id_dosen2? 'selected':'') }}>
                              {{ $item->nama }}
                           </option>
                        @endforeach
                     </select>

                     @error('id_pembimbing_pendamping')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                            <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </div>
               </div>

               <div class="box-footer">
                  <input type="hidden" name="status" value="">
                  <a href="{{ route('akademik.sutgas-pembimbing.show', $surat_tugas->id) }}" class="btn btn-default">Kembali</a> &ensp;

                  <div id="btn_group">
                     {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                     <button type="submit" name="simpan_draf" class="btn bg-purple">Simpan Sebagai Draft</button> &ensp;
                     <button type="submit" name="simpan_kirim" class="btn btn-success">Simpan dan Kirim</button>
                  </div>
               </div>
            </form>

   		</div>
   	</div>
	</div>
@endsection

@section('script')
	<script src="{{asset('/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
	<script type="text/javascript">
		$('.select2').select2();

      $("button[name='simpan_draf']").click(function(event) {
         event.preventDefault();
         $("input[name='status']").val(1);
         $('form').trigger('submit');
      });

      $("button[name='simpan_kirim']").click(function(event) {
         event.preventDefault();
         $("input[name='status']").val(2);
         $('form').trigger('submit');
      });

		var mahasiswa = @json($mahasiswa);
      var id_dosen1 = @json($surat_tugas->id_dosen1);
      var id_dosen2 = @json($surat_tugas->id_dosen2);

		$("select[name='nim']").change(function(event) {
			var nim = $(this).val();
			var nama = "";
			$.each(mahasiswa, function(index, val) {
				 if(nim == val.nim){
				 	nama = val.nama;
				 	return false;
				 }
			});
			$("input[name='nama_mhs']").val(nama);
		});

      //Set disable pilihan dosen di select dosen 2 yg sdh dipilih di select dosen 1
      $("select#id_pembimbing_pendamping option[value='"+id_dosen1+"']").attr('disabled', 'disabled');
      //Set disable pilihan dosen di select dosen 1 yg sdh dipilih di select dosen 2
      $("select#id_pembimbing_utama option[value='"+id_dosen2+"']").attr('disabled', 'disabled');

      // Set dosen yg sama di select dosen 2 jadi disabled ketika select dosen 1 berubah
      $("select#id_pembimbing_utama").change(function(event) {
         $("select#id_pembimbing_pendamping option[disabled='disabled']").removeAttr('disabled');
         var no_pegawai = $(this).val();
         $("select#id_pembimbing_pendamping option[value='"+no_pegawai+"']").attr('disabled', 'disabled');
      });

      //Set dosen yg sama di select dosen 1 jadi disabled ketika select dosen 2 berubah
      $("select#id_pembimbing_pendamping").change(function(event) {
         $("select#id_pembimbing_utama option[disabled='disabled']").removeAttr('disabled');
         var no_pegawai = $(this).val();
         $("select#id_pembimbing_utama option[value='"+no_pegawai+"']").attr('disabled', 'disabled');
      });
	</script>
@endsection
