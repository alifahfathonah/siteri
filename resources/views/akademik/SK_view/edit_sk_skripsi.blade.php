@extends('layouts.template')

@section('side_menu')
   @include('include.akademik_menu')
@endsection

@section('page_title')
   Ubah SK Skripsi
@endsection

@section('css_link')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{asset('/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/css/custom_style.css')}}">
	<!-- bootstrap datepicker -->
   <link rel="stylesheet" href="{{asset('/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

   <style type="text/css">
      table tbody tr td:first-child{
         /*width: 10%;*/
      }

      table th {
         text-align: center;
      }

      .tbl_row{
         display: table;
         width: 100%;
         border-bottom: 0.1px solid lightgrey;
         margin-top: 10px;
         margin-bottom: 10px;
      }

      .hide_tr{
         display: none;
      }

      .show_tr{
         display: block;
      }

      .input_no_surat{
         width: 35%;
      }
	</style>
@endsection

@section('judul_header')
	SK Skripsi
@endsection

@section('content')
   <button id="back_top" class="btn bg-black" title="Kembali ke Atas"><i class="fa fa-arrow-up"></i></button>
   <form action="{{ route('akademik.skripsi.update', $sk->id) }}" method="post" autocomplete="off">
      @csrf
      @method("PUT")
      {{-- @php
         dd($detail_skripsi); 
      @endphp --}}
   	<div class="row">
      	<div class="col-xs-12">
      		<div class="box box-primary">
      			<div class="box-header">
                  <h3 class="box-title">Ubah SK Skripsi</h3>

                    <br><br>
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
                    </div>

                    @php
                    Session::forget('error');
                    @endphp
                    @endif

               </div>

                  <div class="box-body">
                     <div class="row">
                        <div class="form-group col-md-3">
                           <label for="no_surat_pembimbing">No Surat SK Pembimbing</label><br>
                           <input type="text" name="no_surat_pembimbing" id="no_surat_pembimbing" class="input_no_surat" value="{{ $sk->no_surat_pembimbing }}">
                           <span id="format_nomor">/UN25.1.15/SP/{{ Carbon\Carbon::today()->year }}</span>

                           @error('no_surat_pembimbing')
                              <br>
                              <span class="invalid-feedback" role="alert" style="color: red;">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>

                        <div class="form-group col-md-3">
                           <label for="no_surat_penguji">No Surat SK Penguji</label><br>
                           <input type="text" name="no_surat_penguji" id="no_surat_penguji" class="input_no_surat" value="{{ $sk->no_surat_penguji }}">
                           <span id="format_nomor">/UN25.1.15/SP/{{ Carbon\Carbon::today()->year }}</span>

                           @error('no_surat_penguji')
                              <br>
                              <span class="invalid-feedback" role="alert" style="color: red;">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>

                        <div class="form-group col-md-3">
                           <label for="tgl_sk_pembimbing">Tanggal SK Pembimbing</label>
                           <input type="text" name="tgl_sk_pembimbing" id="tgl_sk_pembimbing" class="form-control datepicker" style="font-size: 16px;" value="{{ Carbon\Carbon::parse($sk->tgl_sk_pembimbing)->format('d-m-Y') }}">

                           @error('tgl_sk_pembimbing')
                              <span class="invalid-feedback" role="alert" style="color: red;">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>

                        <div class="form-group col-md-3">
                           <label for="tgl_sk_penguji">Tanggal SK Penguji</label>
                           <input type="text" name="tgl_sk_penguji" id="tgl_sk_penguji" class="form-control datepicker" style="font-size: 16px;" value="{{ Carbon\Carbon::parse($sk->tgl_sk_penguji)->format('d-m-Y') }}">

                           @error('tgl_sk_penguji')
                              <span class="invalid-feedback" role="alert" style="color: red;">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                     </div>

                  </div>

                  <div class="box-footer">
                     <a href="{{ route('akademik.skripsi.show', $sk->id) }}" class="btn btn-default pull-left">Batal</a>

                     {{-- <div class="form-group"> --}}
                        <input type="hidden" name="status" value="">
                        <button type="submit" name="simpan_kirim" class="btn btn-success pull-right">Simpan dan Kirim</button>
                        <button type="submit" name="simpan_draf" class="btn bg-purple pull-right" style="margin-right: 5px;">Simpan Sebagai Draft</button>
                     {{-- </div> --}}

                  </div>

      		</div>
      	</div>
   	</div>

      <div class="row">
         <div class="col-xs-12">
            <div class="box box-default">
               <div class="box-header">
                 <h3 class="box-title">Pilih Mahasiswa</h3>
               </div>

               <div class="box-body">
                  <div class="table-responsive">

                     <div class="form-group">
                        <label for="nim">Pilih NIM Mahasiswa: </label>
                        <select class="form-control select2" id="pilih_nim">
                           <option value="">--Pilih NIM--</option>
                           @if (!empty($old_data))
                              @foreach ($mahasiswa as $item)
                                 @if (in_array($item->nim, $nim_dihapus) || !in_array($item->nim, $old_data["nim"]))
                                 <option value="{{ $item->nim }}">{{ $item->nim }}</option>
                                 @endif
                              @endforeach
                           @else
                              @foreach ($mahasiswa as $item)
                                 @if (!in_array($item->nim, $nim_detail))
                                    <option value="{{ $item->nim }}">{{ $item->nim }}</option>
                                 @endif
                              @endforeach
                           @endif
                        </select>
                     </div>

                     {{-- @foreach ($detail_skripsi as $item)
                        <input type="hidden" name="{{ $item->skripsi->nim }}" value="2">
                     @endforeach --}}

                     <h5>Total Data = <span class="data_count"></span></h5>
                     <table id="tbl-data" class="table table-bordered">
                        <thead>
                           <tr>
                              <th>NIM</th>
                              <th>Nama Mahasiswa</th>
                              <th>Program Studi</th>
                              <th>Judul Skripsi</th>
                              <th>Dosen Pembimbing</th>
                              <th>Dosen Penguji</th>
                              <th>Opsi</th>
                           </tr>
                        </thead>

                        <tbody>
                        @if ($old_mahasiswa != "")
                           @foreach($old_mahasiswa as $index => $val)

                              <tr id="{{ $index }}" nim_mhs="{{ $val->nim }}" class="{{ ($old_data['pilihan_nim'][$index] == 3? 'hide_tr':'') }}">
                                 <td style="width: 60px;">
                                    {{ $val->nim }}
                                    <input type="hidden" name="nim[]" value="{{ $val->nim }}">
                                    @if (in_array($val->nim, $nim_detail))
                                       <input type="hidden" name="pilihan_nim[]" value="2">
                                    @endif
                                 </td>
                                 <td>{{ $val->nama }}</td>
                                 <td>{{ $val->prodi->nama }}</td>
                                 <td style="width: 280px;" >{{ $val->skripsi->detail_skripsi[0]->judul }}</td>
                                 @if ($val->skripsi->detail_skripsi[0]->surat_tugas[0]->tipe_surat_tugas->tipe_surat == "Surat Tugas Pembimbing")
                                    <td>
                                       <div class="tbl_row">
                                          1. {{ $val->skripsi->detail_skripsi[0]->surat_tugas[0]->dosen1->nama }}
                                       </div>
                                       <div class="tbl_row">
                                          2. {{ $val->skripsi->detail_skripsi[0]->surat_tugas[0]->dosen2->nama }}
                                       </div>
                                    </td>
                                    <td>
                                       <div class="tbl_row">
                                          1. {{ $val->skripsi->detail_skripsi[0]->surat_tugas[1]->dosen1->nama }}
                                       </div>
                                       <div class="tbl_row">
                                          2. {{ $val->skripsi->detail_skripsi[0]->surat_tugas[1]->dosen2->nama }}
                                       </div>
                                    </td>
                                 @else
                                    <td>
                                       <div class="tbl_row">
                                          1. {{ $val->skripsi->detail_skripsi[0]->surat_tugas[1]->dosen1->nama }}
                                       </div>
                                       <div class="tbl_row">
                                          2. {{ $val->skripsi->detail_skripsi[0]->surat_tugas[1]->dosen2->nama }}
                                       </div>
                                    </td>
                                    <td>
                                       <div class="tbl_row">
                                          1. {{ $val->skripsi->detail_skripsi[0]->surat_tugas[0]->dosen1->nama }}
                                       </div>
                                       <div class="tbl_row">
                                          2. {{ $val->skripsi->detail_skripsi[0]->surat_tugas[0]->dosen2->nama }}
                                       </div>
                                    </td>
                                 @endif
                                 <td>
                                    <button class="btn btn-danger" type="button" title="Hapus Data" name="delete_data"><i class="fa fa-trash"></i></button>
                                 </td>
                              </tr>

                           @endforeach
                        @else
                           @foreach($detail_skripsi as $index => $val)
                              <tr id="{{ $index }}" nim_mhs="{{ $val->skripsi->nim }}">
                                 <td style="width: 60px;">
                                    {{ $val->skripsi->nim }}
                                    <input type="hidden" name="nim[]" value="{{ $val->skripsi->nim }}">
                                    <input type="hidden" name="pilihan_nim[]" value="2">
                                 </td>
                                 <td>{{ $val->skripsi->mahasiswa->nama }}</td>
                                 <td>{{ $val->skripsi->mahasiswa->prodi->nama }}</td>
                                 <td style="width: 280px;" >{{ $val->judul }}</td>
                                 @if ($val->surat_tugas[0]->tipe_surat_tugas->tipe_surat == "Surat Tugas Pembimbing")
                                    <td>
                                       <div class="tbl_row">
                                          1. {{ $val->surat_tugas[0]->dosen1->nama }}
                                       </div>
                                       <div class="tbl_row">
                                          2. {{ $val->surat_tugas[0]->dosen2->nama }}
                                       </div>
                                    </td>
                                    <td>
                                       <div class="tbl_row">
                                          1. {{ $val->surat_tugas[1]->dosen1->nama }}
                                       </div>
                                       <div class="tbl_row">
                                          2. {{ $val->surat_tugas[1]->dosen2->nama }}
                                       </div>
                                    </td>
                                 @else
                                    <td>
                                       <div class="tbl_row">
                                          1. {{ $val->surat_tugas[1]->dosen1->nama }}
                                       </div>
                                       <div class="tbl_row">
                                          2. {{ $val->surat_tugas[1]->dosen2->nama }}
                                       </div>
                                    </td>
                                    <td>
                                       <div class="tbl_row">
                                          1. {{ $val->surat_tugas[0]->dosen1->nama }}
                                       </div>
                                       <div class="tbl_row">
                                          2. {{ $val->surat_tugas[0]->dosen2->nama }}
                                       </div>
                                    </td>
                                 @endif
                                 <td>
                                    <button class="btn btn-danger" type="button" title="Hapus Data" name="delete_data"><i class="fa fa-trash"></i></button>
                                 </td>
                              </tr>
                           @endforeach
                        @endif
                        </tbody>

                        <tfoot>
                           <tr>
                              <th>NIM</th>
                              <th>Nama Mahasiswa</th>
                              <th>Program Studi</th>
                              <th>Judul Skripsi</th>
                              <th>Dosen Pembimbing</th>
                              <th>Dosen Penguji</th>
                              <th>Opsi</th>
                           </tr>
                        </tfoot>
                     </table>

                     <h5>Total Data = <span class="data_count"></span></h5>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>
@endsection

@section('script')
   <script src="{{asset('/js/btn_backTop.js')}}"></script>
	<script src="{{asset('/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
   <!-- bootstrap datepicker -->
   <script src="{{asset('/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
   <script src="{{asset('/adminlte/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.id.js')}}"></script>

	<script type="text/javascript">
		$('.select2').select2();
		var mahasiswa = @json($mahasiswa);
      var detail_skripsi = @json($detail_skripsi);
      var nim_detail = @json($nim_detail)

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

      //Date picker
      $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        language: 'id'
      })

      var no = 0;
      if ($("#tbl-data tbody tr").length) {
         var kelas = $("#tbl-data tbody tr:last-child").attr('class');
         no = parseInt(kelas);
      }

      $("#pilih_nim").on("select2:select", function(event) {
         var nim = $(this).val();

         if (nim_detail.indexOf(nim) > -1) {
            $("tr[nim_mhs='"+nim+"']").removeClass('hide_tr');
            $("tr[nim_mhs='"+nim+"']").find('input[name="pilihan_nim[]"]').val(2);
         }
         else{
            $.each(mahasiswa, function(index, val) {
               if(nim == val.nim){
                  no+=1;
                  if (val.skripsi.detail_skripsi[0].surat_tugas[0].tipe_surat_tugas.tipe_surat == "Surat Tugas Pembimbing") {
                     $("tbody").append(`
                        <tr id="`+no+`" nim_mhs="`+nim+`">
                           <td style="width: 60px;" >
                              `+val.nim+`
                              <input type="hidden" name="nim[]" value="`+val.nim+`">
                              <input type="hidden" name="pilihan_nim[]" value="1">
                           </td>
                           <td class="nama_mhs" >`+val.nama+`</td>
                           <td>`+val.prodi.nama+`</td>
                           <td style="width: 280px;" >`+val.skripsi.detail_skripsi[0].judul+`</td>
                           <td>
                              <div class="tbl_row">1. `+val.skripsi.detail_skripsi[0].surat_tugas[0].dosen1.nama+`</div>
                              <div class="tbl_row">2. `+val.skripsi.detail_skripsi[0].surat_tugas[0].dosen2.nama+`</div>
                           </td>
                           <td>
                              <div class="tbl_row">1. `+val.skripsi.detail_skripsi[0].surat_tugas[1].dosen1.nama+`</div>
                              <div class="tbl_row">2. `+val.skripsi.detail_skripsi[0].surat_tugas[1].dosen2.nama+`</div>
                           </td>
                           <td >
                              <button class="btn btn-danger" type="button" title="Hapus Data" name="delete_data"><i class="fa fa-trash"></i></button>
                           </td>
                        </tr>
                     `);
                  }
                  else{
                     $("tbody").append(`
                        <tr id="`+no+`" nim_mhs="`+nim+`">
                           <td style="width: 60px;" >
                              `+val.nim+`
                              <input type="hidden" name="nim[]" value="`+val.nim+`">
                              <input type="hidden" name="pilihan_nim[]" value="1">
                           </td>
                           <td class="nama_mhs" >`+val.nama+`</td>
                           <td>`+val.prodi.nama+`</td>
                           <td style="width: 280px;" >`+val.skripsi.detail_skripsi[0].judul+`</td>
                           <td>
                              <div class="tbl_row">1. `+val.skripsi.detail_skripsi[0].surat_tugas[1].dosen1.nama+`</div>
                              <div class="tbl_row">2. `+val.skripsi.detail_skripsi[0].surat_tugas[1].dosen2.nama+`</div>
                           </td>
                           <td>
                              <div class="tbl_row">1. `+val.skripsi.detail_skripsi[0].surat_tugas[0].dosen1.nama+`</div>
                              <div class="tbl_row">2. `+val.skripsi.detail_skripsi[0].surat_tugas[0].dosen2.nama+`</div>
                           </td>
                           <td >
                              <button class="btn btn-danger" type="button" title="Hapus Data" name="delete_data"><i class="fa fa-trash"></i></button>
                           </td>
                        </tr>
                     `);
                  }
                  
                  return false;

                  // var status = false;
                  // $.each(detail_skripsi, function(index2, el) {
                  //    if (val.nim == el.skripsi.nim) {
                  //       status = true;
                  //       return false;
                  //    }
                  // });

                  // if (!status) {
                  //    $("tbody tr#"+no+" td:first-child").append(`
                  //       <input type="hidden" name="`+val.nim+`" value="1">
                  //    `);
                  // }
                  // else{
                  //    $("input[name='"+nim+"']").val(2);
                  // }

               }
            });
         }

         $(this).find('option[value="'+nim+'"]').remove();
         data_count();
         hapus_baris();
      });

      hapus_baris();
      function hapus_baris() {
         $('button[name="delete_data"]').off("click").click(function(event) {
            // console.log("hapus ya");
            var nim = $(this).parents("tr").find('input[name="nim[]"').val();
            var newOption = new Option(nim, nim, false, false);
            $('#pilih_nim').append(newOption).trigger('change');

            if (nim_detail.indexOf(nim) > -1) {
               $("tr[nim_mhs='"+nim+"']").addClass('hide_tr');
               $("tr[nim_mhs='"+nim+"']").find('input[name="pilihan_nim[]"]').val(3);
            }
            else{
               var tr_class = $(this).parents("tr").remove();
            }
            data_count();

            // $.each(detail_skripsi, function(index2, el) {
            //    if (nim == el.skripsi.nim) {
            //       $("input[name='"+nim+"']").val(3);
            //       return false;
            //    }
            // });
         });
      }

      data_count();
      function data_count() {
         var all_tr = $("tbody tr").length;
         var hide_tr = $("tbody tr.hide_tr").length;
         var jml = all_tr - hide_tr;
         $(".data_count").text(jml);
      }

	</script>
@endsection
