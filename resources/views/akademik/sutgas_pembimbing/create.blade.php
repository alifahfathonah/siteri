@extends('akademik.akademik_view')

@section('page_title')
	Buat Surat Tugas Pembimbing
@endsection

@section('css_link')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="/adminlte/bower_components/select2/dist/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="/css/custom_style.css">
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
	Surat Tugas Pembimbing
@endsection

@section('content')
	<div class="row">
   	<div class="col-xs-12">
   		<div class="box box-primary">
   			<div class="box-header">
              <h3 class="box-title">Buat Surat Tugas Pembimbing</h3>
            </div>

            <form action="{{ route('akademik.sutgas-pembimbing.store') }}" method="post">
               <div class="box-body">
            		@csrf

            		<div class="form-group">
            			<label for="no_surat">No Surat</label><br>
            			<input type="text" name="no_surat" id="no_surat" value="{{ old('no_surat') }}">
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
            							<option value="{{ $item->nim }}" {{ ($item->nim == old('nim')? 'selected' : '') }}>
                                    {{ $item->nim }}
                                 </option>
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
            					<input type="text" name="nama_mhs" id="nama_mhs" class="form-control" readonly="">
            				</div>
            			</div>
            		</div>

                  <div class="form-group">
                     <label for="id_keris">Keris</label><br>
                     <select id="id_keris" name="id_keris" class="form-control select2">
                        <option value="">-- Pilih Keris --</option>
                        @foreach ($keris as $item)
                           <option value="{{ $item->id }}" {{ ($item->id == old('id_keris')? 'selected' : '') }}>
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
            			<textarea name="judul" id="judul" class="form-control" rows="3">{{ old('judul') }}</textarea>

                     @error('judul')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                           <strong>{{ $message }}</strong>
                        </span>
                     @enderror
            		</div>

            		<div class="form-group">
            			<label for="pembimbing_utama">Pembimbing Utama</label><br>
            			<select name="id_pembimbing_utama" id="id_pembimbing_utama" class="form-control select2">
            				<option value="">Pilih Pembimbing Utama</option>
            				@foreach ($dosen as $item)
            					<option value="{{ $item->no_pegawai }}" {{ ($item->no_pegawai == old('id_pembimbing_utama')? 'selected' : '') }}>
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
            				<option value="">Pilih Pembimbing Pendamping</option>
            				@foreach ($dosen as $item)
            					<option value="{{ $item->no_pegawai }}" {{ ($item->no_pegawai == old('id_pembimbing_pendamping')? 'selected' : '') }}>
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
                  <a href="{{ route('akademik.sutgas-pembimbing.index') }}" class="btn btn-default">Batal</a> &ensp;

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
	<script src="/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
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
      var nim_old = @json(old('nim'));

      if(nim_old != null){
         var nama = "";
         console.log('ada gan');
         $.each(mahasiswa, function(index, val) {
             if(nim_old == val.nim){
               nama = val.nama;
               return false;
             }
         });

         $("input[name='nama_mhs']").val(nama);
      }

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
	</script>
@endsection
