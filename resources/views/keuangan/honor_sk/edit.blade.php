@extends('layouts.template')

@section('side_menu')
   @include('include.keuangan_menu')
@endsection

@section('page_title')
	Ubah Honorarium SK {{ ($sk_honor->tipe_sk->tipe == "SK Skripsi"? "Skripsi" : "Sempro") }}
@endsection

@section('css_link')
   <link rel="stylesheet" type="text/css" href="{{asset('/css/custom_style.css')}}">
   <style type="text/css">
      #btn_honor_pembimbing, #btn_honor_penguji{
         margin-left: 8px;
      }

      table{
         font-size: 15px;
      }

      table th{
         text-align: center;
      }

      td span{
         float: right;
      }

      #tbl_add_honor_pembimbing td{
         padding: 3px;
      }

      #tbl_add_honor_pembimbing td input{
         width: 100%;
      }

      .jml_total td{
         font-weight: bold;
         background-color: white;
      }

      /* .absolute{
         top: 0px;
         right: -250px;
      } */
   </style>
@endsection

@section('judul_header')
	Honorarium SK {{ ($sk_honor->tipe_sk->tipe == "SK Skripsi"? "Skripsi" : "Sempro") }}
@endsection

@section('content')
<button id="back_top" type="button" class="btn bg-black"><i class="fa fa-arrow-up"></i></button>

<form method="POST" action="{{ ($sk_honor->tipe_sk->tipe == "SK Skripsi"? route('keuangan.honor-skripsi.update',$sk_honor->id) : route('keuangan.honor-sempro.update',$sk_honor->id)) }}">
   @csrf
   @method('PUT')
   <input type="hidden" name="status">
   <div class="row">
      <div class="col-xs-12" id="top_title">
            <div class="box box-success">
               <div class="box-header">
                  <h3 class="box-title">Ubah Honorarium SK {{ ($sk_honor->tipe_sk->tipe == "SK Skripsi"? "Skripsi" : "Sempro") }}</h3>

                  <div class="box-tools pull-right">
                   <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                   </button>
                   <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                   </button>
                 </div>
               </div>

               <div class="box-body">
                  <h4><b>Informasi Daftar Honor:</b></h3>
                  <p>
                     Nomor SK : {{ $sk_honor->detail_sk[0]->sk_akademik->no_surat }}/UN 25.1.15/SP/{{Carbon\Carbon::parse($sk_honor->detail_sk[0]->sk_akademik->created_at)->year}}
                  </p>
                  <p>Tanggal Dibuat : {{Carbon\Carbon::parse($sk_honor->created_at)->locale('id_ID')->isoFormat('D MMMM Y')}}</p>
                  <p>
                     Tanggal SK {{($sk_honor->tipe_sk->tipe == "SK Skripsi")? "Skripsi" : "Sempro"}} : {{Carbon\Carbon::parse($sk_honor->detail_sk[0]->sk_akademik->created_at)->locale('id_ID')->isoFormat('D MMMM Y')}}
                  </p>
                  <button class="btn bg-purple" name="simpan_draf">Simpan Sebagai Draft</button>
                  <button class="btn btn-success" name="simpan_kirim">Simpan dan Kirim</button>
               </div>
            </div>
      </div>
   </div>

   <div class="row">
      <div class="col-xs-12">
         <div class="box box-primary">
            <div class="box-header">
               <h3 class="box-title">Ubah Daftar Honor Pembimbing {{ ($sk_honor->tipe_sk->tipe == "SK Skripsi"? "Skripsi" : "Sempro") }}</h3>
               <input type="hidden" name="id_sk_honor" value="{{$sk_honor->id}}">
               <input type="hidden" name="id_sk_akademik" value="{{$sk_honor->detail_sk[0]->sk_akademik->id}}">
               {{-- <input type="hidden" name="no_surat" value="{{$sk_akademik->no_surat}}"> --}}

               <div class="box-tools pull-right">
                  <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                  </button>
               </div>
            </div>
            <div class="box-body form-group">
               <table id="tbl_add_honor_pembimbing">
                  <tr>
                     <td><label for="honor_pembimbing">Honor Pembimbing I: Rp </label></td>
                     <td><input type="number" name="honor_pembimbing1" id="honor_pembimbing1" placeholder="Masukkan jumlah honor" value="{{ $sk_honor->honor_pembimbing1 }}"></td>

                     @error('honor_pembimbing1')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                            <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </tr>

                  <tr>
                     <td><label for="honor_pembimbing">Honor Pembimbing II: Rp </label></td>
                     <td>
                        <input type="number" name="honor_pembimbing2" id="honor_pembimbing2" placeholder="Masukkan jumlah honor" value="{{ $sk_honor->honor_pembimbing2 }}">
                     </td>
                     <td>
                        <button type="button" id="btn_honor_pembimbing" class="btn btn-primary">Ok</button>
                     </td>

                     @error('honor_pembimbing2')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                            <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </tr>
               </table>

               {{-- <div class="input_honor">
                  <label for="honor_pembimbing">Masukkan jumlah uang honorarium: Rp </label>
                  <input type="number" name="honor_pembimbing" id="honor_pembimbing" value="{{ $sk_honor->honor_pembimbing }}">
                  <button type="button" id="btn_honor_pembimbing" class="btn btn-default">Ok</button>
               </div> --}}

               <div class="table-responsive">
                  <table id="dataTable2" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Pembimbing I/II</th>
                           <th>NPWP</th>
                           <th>Nama Mahasiswa/NIM</th>
                           <th>Gol</th>
                           <th>Honorarium</th>
                           <th>PPH psl 5%-15%</th>
                           <th>Penerimaan</th>
                        </tr>
                     </thead>

                     <tbody id="tbl_pembimbing">
                        @php $no = 0; $total_honor=0; $total_pph=0; $total_penerimaan=0; @endphp
                        @foreach($sk_honor->detail_sk as $item)
                           <tr id="{{$no+=1}}">
                              <td>{{$no}}</td>
                              <td>{{$item->pembimbing_utama->nama}}</td>
                              <td>{{$item->pembimbing_utama->npwp}}</td>
                              <td rowspan="2">
                                 <p>{{$item->nama_mhs}}</p>
                                 <p>NIM: {{$item->nim}}</p>
                              </td>
                              <td>{{$item->pembimbing_utama->golongan->golongan}}</td>
                              <td class="pembimbingHonor_1">Rp
                                  <span>{{ number_format($sk_honor->honor_pembimbing1, 0, ",", ".") }}</span>
                              </td>
                              <td class="pph" id="pph_{{$no}}">Rp &ensp; 
                                 <span>
                                    @php
                                       $pph = ($item->pembimbing_utama->golongan->pph * $sk_honor->honor_pembimbing1)/100;
                                    @endphp
                                    {{ number_format($pph, 0, ",", ".") }}
                                 </span>
                              </td>
                              <td class="penerimaan" id="penerimaan_{{$no}}">Rp &ensp;
                              @php $penerimaan = $sk_honor->honor_pembimbing1 - $pph @endphp 
                                 <span>{{ number_format($penerimaan, 0, ",", ".") }}</span>
                              </td>

                              @php
                                 $total_honor+=$sk_honor->honor_pembimbing1;
                                 $total_pph+=$pph;
                                 $total_penerimaan+=$penerimaan;
                              @endphp
                           </tr>

                           <tr id="{{$no+=1}}">
                              <td>{{$no}}</td>
                               <td>{{$item->pembimbing_pendamping->nama}}</td>
                              <td>{{$item->pembimbing_pendamping->npwp}}</td>
                              <td>{{$item->pembimbing_pendamping->golongan->golongan}}</td>
                              <td class="pembimbingHonor_2">Rp 
                                 <span>{{ number_format($sk_honor->honor_pembimbing2, 0, ",", ".") }}</span>
                              </td>
                              <td class="pph" id="pph_{{$no}}">Rp &ensp; 
                                 <span>
                                    @php
                                       $pph = ($item->pembimbing_pendamping->golongan->pph * $sk_honor->honor_pembimbing2)/100;
                                    @endphp
                                    {{ number_format($pph, 0, ",", ".") }}
                                 </span>
                              </td>
                              <td class="penerimaan" id="penerimaan_{{$no}}">Rp &ensp;
                                 @php $penerimaan = $sk_honor->honor_pembimbing2 - $pph @endphp 
                                 <span>{{ number_format($penerimaan, 0, ",", ".") }}</span>
                              </td>

                              @php
                                 $total_honor+=$sk_honor->honor_pembimbing2;
                                 $total_pph+=$pph;
                                 $total_penerimaan+=$penerimaan;
                              @endphp
                           </tr>
                        @endforeach

                        <tr class="jml_total">
                           <td colspan="5" style="text-align: center;">Jumlah</td>
                           <td>Rp <span id="total_honor_pembimbing">{{ number_format($total_honor, 0, ",", ".") }}</span></td>
                           <td>Rp <span id="total_pph_pembimbing">{{ number_format($total_pph, 0, ",", ".") }}</span></td>
                           <td>Rp <span id="total_penerimaan_pembimbing">{{ number_format($total_penerimaan, 0, ",", ".") }}</span></td>
                           <td></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
   	<div class="col-xs-12">
   		<div class="box box-danger">
   			<div class="box-header">
   				<h3 class="box-title">Ubah Daftar Honor {{ ($sk_honor->tipe_sk->tipe == "SK Skripsi"? "penguji Skripsi" : "Pembahas Sempro") }}</h3>

               <div class="box-tools pull-right">
                     <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                     </button>
                     <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                   </button>
               </div>
   			</div>

   			<div class="box-body">
               <div class="input_honor">
                  <label for="honor_penguji">Honor {{ ($sk_honor->tipe_sk->tipe == "SK Skripsi"? "Penguji" : "Pembahas") }}: Rp </label>
                  <input type="number" name="honor_penguji" id="honor_penguji" value="{{ $sk_honor->honor_penguji }}">
                  <button type="button" id="btn_honor_penguji" class="btn btn-primary">Ok</button>
               </div>
               @error('honor_penguji')
                  <span class="invalid-feedback" role="alert" style="color: red;">
                      <strong>{{ $message }}</strong>
                  </span>
               @enderror
               
               <div class="table-responsive">
                  <table id="dataTable2" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th> {{ ($sk_honor->tipe_sk->tipe == "SK Skripsi"? "Penguji" : "Pembahas") }} I/II</th>
                           <th>NPWP</th>
                           <th>Nama Mahasiswa/NIM</th>
                           <th>Gol</th>
                           <th>Honorarium</th>
                           <th>PPH psl 5%-15%</th>
                           <th>Penerimaan</th>
                        </tr>
                     </thead>

                     <tbody id="tbl_penguji">
                        @php $no = 0; $total_honor=0; $total_pph=0; $total_penerimaan=0; @endphp
                        @foreach($sk_honor->detail_sk as $item)
                           <tr id="{{$no+=1}}">
                              <td>{{$no}}</td>
                              <td>{{$item->penguji_utama->nama}}</td>
                              <td>{{$item->penguji_utama->npwp}}</td>
                              <td rowspan="2">
                                 <p>{{$item->nama_mhs}}</p>
                                 <p>NIM: {{$item->nim}}</p>
                              </td>
                              <td>{{$item->penguji_utama->golongan->golongan}}</td>
                              <td class="pengujiHonor">Rp 
                                 <span>{{ number_format($sk_honor->honor_penguji, 0, ",", ".") }}</span>
                              </td>
                              <td class="pph" id="pph_{{$no}}">Rp &ensp; 
                                 <span>
                                    @php
                                       $pph = ($item->penguji_utama->golongan->pph * $sk_honor->honor_penguji)/100;
                                    @endphp
                                    {{ number_format($pph, 0, ",", ".") }}
                                 </span>
                              </td>
                              <td class="penerimaan" id="penerimaan_{{$no}}">Rp &ensp; 
                                 @php $penerimaan = $sk_honor->honor_penguji - $pph @endphp
                                 <span>{{ number_format($penerimaan, 0, ",", ".") }}</span>
                              </td>

                              @php
                                 $total_honor+=$sk_honor->honor_penguji;
                                 $total_pph+=$pph;
                                 $total_penerimaan+=$penerimaan;
                              @endphp
                           </tr>

                           <tr id="{{$no+=1}}">
                              <td>{{$no}}</td>
                               <td>{{$item->penguji_pendamping->nama}}</td>
                              <td>{{$item->penguji_pendamping->npwp}}</td>
                              <td>{{$item->penguji_pendamping->golongan->golongan}}</td>
                              <td class="pengujiHonor">Rp 
                                 <span>{{ number_format($sk_honor->honor_penguji, 0, ",", ".") }}</span>
                              </td>
                              <td class="pph" id="pph_{{$no}}">Rp &ensp; 
                                 <span>
                                    @php
                                       $pph = ($item->penguji_pendamping->golongan->pph * $sk_honor->honor_penguji)/100;
                                    @endphp
                                    {{ number_format($pph, 0, ",", ".") }}
                                 </span>
                              </td>
                              <td class="penerimaan" id="penerimaan_{{$no}}">Rp &ensp; 
                                 @php $penerimaan = $sk_honor->honor_penguji - $pph @endphp
                                 <span>{{ number_format($penerimaan, 0, ",", ".") }}</span>
                              </td>

                              @php
                                 $total_honor+=$sk_honor->honor_penguji;
                                 $total_pph+=$pph;
                                 $total_penerimaan+=$penerimaan;
                              @endphp
                           </tr>
                        @endforeach

                        <tr class="jml_total">
                           <td colspan="5" style="text-align: center;">Jumlah</td>
                           <td>Rp <span id="total_honor_penguji">{{ number_format($total_honor, 0, ",", ".") }}</span></td>
                           <td>Rp <span id="total_pph_penguji">{{ number_format($total_pph, 0, ",", ".") }}</span></td>
                           <td>Rp <span id="total_penerimaan_penguji">{{ number_format($total_penerimaan, 0, ",", ".") }}</span></td>
                           <td></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
   			</div>
   		</div>
   	</div>
   </div>
   <div class="row">
      <div class="col-xs-12">
         <input type="hidden" name="status" value="">
         <div class="form-group" style="float: left;">
		      	<button type="submit" name="simpan_draf" class="btn bg-purple">Simpan Sebagai Draft</button> &ensp;
		      	<button type="submit" name="simpan_kirim" class="btn btn-success">Simpan dan Kirim</button>	
		   </div>
      </div>
   </div>
</form>
@endsection

@section('script')
   <script src="{{asset('/js/btn_backTop.js')}}"></script>
   <script type="text/javascript">
      $("#back_top").on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '500');
      });

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

      var detail_sk = @json($sk_honor->detail_sk);
      // console.log(detail_sk);

      $("#btn_honor_pembimbing").click(function(event) {
         var honor_1 = $("#honor_pembimbing1").val();
         var honor_2 = $("#honor_pembimbing2").val();

         $(".pembimbingHonor_1").children("span").text(formatRupiah(honor_1));
         $(".pembimbingHonor_2").children("span").text(formatRupiah(honor_2));

         var ttl_honor_pembimbing = 0;
         var ttl_pph_pembimbing = 0;
         var ttl_penerimaan_pembimbing = 0;
         var no = 0;
         $.each(detail_sk, function(index, val){
            no+=1;
            var pph1 = (honor_1 * val.pembimbing_utama.golongan.pph)/100;
            var penerimaan1 = honor_1 - pph1;
            $("#tbl_pembimbing").find("#pph_"+no).children('span').text(formatRupiah(pph1));
            $("#tbl_pembimbing").find("#penerimaan_"+no).children('span').text(formatRupiah(penerimaan1));
            ttl_honor_pembimbing += parseInt(honor_1);
            ttl_pph_pembimbing += pph1;
            ttl_penerimaan_pembimbing += penerimaan1; 

            no+=1;
            var pph2 = (honor_2 * val.pembimbing_pendamping.golongan.pph)/100;
            var penerimaan2 = honor_2 - pph2;
            $("#tbl_pembimbing").find("#pph_"+no).children('span').text(formatRupiah(pph2));
            $("#tbl_pembimbing").find("#penerimaan_"+no).children('span').text(formatRupiah(penerimaan2));
            ttl_honor_pembimbing += parseInt(honor_2);
            ttl_pph_pembimbing += pph2;
            ttl_penerimaan_pembimbing += penerimaan2;
         });

         $("#total_honor_pembimbing").text(formatRupiah(ttl_honor_pembimbing));
         $("#total_pph_pembimbing").text(formatRupiah(ttl_pph_pembimbing));
         $("#total_penerimaan_pembimbing").text(formatRupiah(ttl_penerimaan_pembimbing));
      });


      $("#btn_honor_penguji").click(function(event) {
         var honor = $("#honor_penguji").val();
         $(".pengujiHonor").children('span').text(formatRupiah(honor));

         var ttl_honor_penguji = 0;
         var ttl_pph_penguji = 0;
         var ttl_penerimaan_penguji = 0;
         var no = 0;
         $.each(detail_sk, function(index, val){
            no+=1;
            var pph1 = (honor * val.penguji_utama.golongan.pph)/100;
            var penerimaan1 = honor - pph1;
            $("#tbl_penguji").find("#pph_"+no).children('span').text(formatRupiah(pph1));
            $("#tbl_penguji").find("#penerimaan_"+no).children('span').text(formatRupiah(penerimaan1));
            ttl_honor_penguji += parseInt(honor);
            ttl_pph_penguji += pph1;
            ttl_penerimaan_penguji += penerimaan1;

            no+=1;
            var pph2 = (honor * val.penguji_pendamping.golongan.pph)/100;
            var penerimaan2 = honor - pph2;
            $("#tbl_penguji").find("#pph_"+no).children('span').text(formatRupiah(pph2));
            $("#tbl_penguji").find("#penerimaan_"+no).children('span').text(formatRupiah(penerimaan2));
            ttl_honor_penguji += parseInt(honor);
            ttl_pph_penguji += pph2;
            ttl_penerimaan_penguji += penerimaan2;
         });

         $("#total_honor_penguji").text(formatRupiah(ttl_honor_penguji));
         $("#total_pph_penguji").text(formatRupiah(ttl_pph_penguji));
         $("#total_penerimaan_penguji").text(formatRupiah(ttl_penerimaan_penguji));
      });

      //Mengubah format angka
      function formatRupiah(angka){
         var number_string = angka.toString().replace(/[^,\d]/g, ''),
         split       = number_string.split(','),
         sisa           = split[0].length % 3,
         rupiah         = split[0].substr(0, sisa),
         ribuan         = split[0].substr(sisa).match(/\d{3}/gi);
      
         // tambahkan titik jika yang di input sudah menjadi angka ribuan
         if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
         }
      
         rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
         return rupiah;
         // return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
      }
   </script>
@endsection