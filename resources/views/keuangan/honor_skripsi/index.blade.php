@extends('keuangan.keuangan_view')

@section('page_title')
      Daftar Honorarium Skripsi
@endsection

@section('css_link')
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <link rel="stylesheet" type="text/css" href="/css/custom_style.css">
@endsection

@section('judul_header')
      Honorarium Skripsi
@endsection

@section('content')     
   <div class="row">
      <div class="col-xs-12">
         <div class="box box-success">
            <div class="box-header">
               <h3 class="box-title">Daftar Honorarium Skripsi</h3>

               <div style="float: right;">
                  <a href="{{route('keuangan.honor-skripsi.pilih-sk')}}" class="btn btn-primary"><i class="fa fa-plus"></i>  Buat Dartar Honor</a>
               </div>
            </div>

            <div class="box-body">
               <div class="table-responsive">
                  <table id="table_data1" class="table table-bordered table-hovered">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Tanggal Dibuat</th>
                           <th>Status</th>
                           <th>Verif BPP</th>
                           <th>Verif KTU</th>
                           <th>Verif Wadek 2</th>
                           <th>Verif Dekan</th>
                           <th>Opsi</th>
                        </tr>
                     </thead>

                     <tbody>
                        @php $no=0; @endphp
                        @foreach ($sk_honor as $item)
                           <tr id="sk_{{ $item->id }}">
                              <td>{{ $no+=1 }}</td>
                              <td>
                                 {{ Carbon\Carbon::parse($item->created_at)->locale('id_ID')->isoFormat('D MMMM Y') }}
                              </td>
                              <td>{{ $item->status_sk_honor->status }}</td>
                              <td>
                                 @if($item->verif_kebag_keuangan == 0) 
                                    Belum Diverifikasi
                                 @elseif($item->verif_kebag_keuangan == 2) 
                                    <label class="label bg-red">Butuh Revisi</label> 
                                 @else
                                    <label class="label bg-green">Sudah Diverifikasi</label>
                                 @endif
                              </td>
                              <td>
                                 @if($item->verif_ktu == 0) 
                                    Belum Diverifikasi
                                 @elseif($item->verif_ktu == 2) 
                                    <label class="label bg-red">Butuh Revisi</label> 
                                 @else
                                    <label class="label bg-green">Sudah Diverifikasi</label>
                                 @endif
                              </td>
                              <td>
                                 @if($item->verif_wadek2 == 0) 
                                    Belum Diverifikasi
                                 @elseif($item->verif_wadek2 == 2) 
                                    <label class="label bg-red">Butuh Revisi</label> 
                                 @else
                                    <label class="label bg-green">Sudah Diverifikasi</label>
                                 @endif
                              </td>
                              <td>
                                 @if($item->verif_dekan == 0) 
                                    Belum Diverifikasi
                                 @elseif($item->verif_dekan == 2) 
                                    <label class="label bg-red">Butuh Revisi</label> 
                                 @else
                                    <label class="label bg-green">Sudah Diverifikasi</label>
                                 @endif
                              </td>
                              <td>
                                 @if ($item->tipe_sk->tipe == "SK Skripsi")
                                    <a href="{{ route('keuangan.honor-skripsi.show', $item->id) }}" class="btn btn-primary" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                                    @if ($item->verif_dekan != 1)
                                       <a href="{{ route('keuangan.honor-skripsi.edit', $item->id) }}" class="btn btn-warning" title="Lihat Detail"><i class="fa fa-edit"></i></a>
                                    @endif
                                 @endif

                                 @if ($item->tipe_sk->tipe == "SK Skripsi")
                                    <a href="#" class="btn btn-danger" name="delete_honor" id="{{ $item->id }}" data-toggle="modal" data-target="#modal-delete"><i class="fa fa-trash"></i></a>
                                 @endif
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="success_delete" class="pop_up_info">
        <h4><i class="icon fa fa-check"></i>  <span></span></h4>
   </div>

   <div class="modal modal-danger fade" id="modal-delete">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Konfirmasi Penghapusan</h4>
          </div>
          <div class="modal-body">
            <p>Apakah anda yakin ingin menghapus darfat honor ini?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>           
         <button type="button" id="hapusBtn" data-dismiss="modal" class="btn btn-outline">Hapus</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
@endsection

@section('script')
   <script type="text/javascript">
      $("a[name='delete_honor']").click(function(event) {
         event.preventDefault();
         var id_sk = $(this).attr('id');

         @if($sk_honor[0]->tipe_sk->tipe == "SK Skripsi")
         var url_del = "{{route('keuangan.honor-skripsi.destroy')}}" + '/' + id_sk;             
         @else
         // var url_del = "{{route('akademik.sempro.destroy')}}" + '/' + id_sk;
         @endif
         console.log(url_del);
         
         $('div.modal-footer').off().on('click', '#hapusBtn', function(event) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
               url: url_del,
               type: 'POST',
               // dataType: '',
               data: {_method: 'DELETE'},
            })
            .done(function(hasil) {
               console.log("success");
               $("tr#sk_"+id_sk).hide();
               $("#success_delete").show();
               $("#success_delete").find('span').html(hasil);
               $("#success_delete").fadeOut(1800);
            })
            .fail(function() {
               console.log("error");
            });
         });
      
      });
   </script>
@endsection  