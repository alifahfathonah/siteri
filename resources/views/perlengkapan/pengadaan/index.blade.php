@extends('perlengkapan.perlengkapan_view')

@section('page_title', 'Laporan Pengadaan')

@section('judul_header', 'Laporan Pengadaan')

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Laporan Pengadaan</h3>

                <div style="float: right;">
                    <a href="{{ route('perlengkapan.pengadaan.create') }}" class="btn btn-primary"><i
                            class="fa fa-plus"></i> Buat Laporan</a>
                </div>
            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table id="pengadaan" class="table table-bordered table-hovered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Dibuat</th>
                                <th>Keterangan</th>
                                {{-- <th>Nama Barang</th>
                                <th>Spesifikasi</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total</th> --}}
                                <th>Status</th>
                                <th style="width:99.8px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 0 @endphp
                            @foreach($laporan as $item)
                            <tr id="lap_{{ $item->id }}">
                                <td>{{$no+=1}}</td>
                                <td>
                                    {{Carbon\Carbon::parse($item->dibuat)->locale('id_ID')->isoFormat('D MMMM Y')}}
                                </td>
                                <td>{{$item->keterangan}}</td>
                                {{-- <td>{{$item->nama_barang}}</td>
                                <td>{{$item->spesifikasi}}</td>
                                <td>{{$item->jumlah}}</td>
                                <td>Rp {{$item->harga}}</td>
                                <td>Rp {{$item->jumlah * $item->harga}}</td> --}}
                                <td>
                                    @if($item->verif_wadek2 == 0)
                                    Belum Diverifikasi
                                    @else
                                    <label class="label bg-green">Sudah Diverifikasi</label>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('perlengkapan.pengadaan.show', $item->id) }}"
                                        class="btn btn-primary" title="Lihat Laporan"><i class="fa fa-eye"></i></a>
                                    @if($item->verif_wadek2 != 1)
                                    <a href="{{ route('perlengkapan.pengadaan.edit', [$item->id, 'laporan' => true]) }}"
                                        class="btn btn-warning" title="Ubah Laporan"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if($item->verif_wadek2 != 1)
                                    <a href="#" class="btn btn-danger" id="{{ $item->id }}" name="hapus_laporan"
                                        title="Hapus Laporan" data-toggle="modal" data-target="#modal-delete"><i
                                            class="fa fa-trash"></i></a>
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
    <h4><i class="icon fa fa-check"></i> <span></span></h4>
</div>

<div class="modal modal-danger fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi Pembatalan</h4>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin membatalkan pengadaan ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Tidak</button>
                <button type="button" id="hapusBtn" data-dismiss="modal" class="btn btn-outline">Iya</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('script')

<script>
    $(function(){
        $('#pengadaan').DataTable();
    });
</script>

@endsection