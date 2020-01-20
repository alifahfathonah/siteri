@extends('perlengkapan.perlengkapan_view')

@section('page_title', 'Peminjaman Ruang')

@section('judul_header', 'Peminjaman Ruang')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Laporan Peminjaman Ruang</h3>

                <div style="float: right;">
                    <a href="{{ route('perlengkapan.peminjaman_ruang.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Buat Laporan</a>
                </div>
            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table id="peminjaman_ruang" class="table table-bordered table-hovered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                                <th>Jam Mulai</th>
                                <th>Jam Berakhir</th>
                                <th>Kegiatan</th>
                                <th>Jumlah Peserta</th>
                                <th>Nama Ruang</th>
                                <th>Status</th>
                                <!-- <th>Verifikasi</th> -->
                                <th style="width:99.8px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 0 @endphp
                            @foreach($laporan as $item)
                            <tr id="lap_{{ $item->peminjaman_ruang->id }}">
                                <td>{{$no+=1}}</td>
                                <td>{{$item->peminjaman_ruang->tanggal_mulai}}</td>
                                <td>{{$item->peminjaman_ruang->tanggal_berakhir}}</td>
                                <td>{{$item->peminjaman_ruang->jam_mulai}}</td>
                                <td>{{$item->peminjaman_ruang->jam_berakhir}}</td>
                                <td>{{$item->peminjaman_ruang->kegiatan}}</td>
                                <td>{{$item->peminjaman_ruang->jumlah_peserta}}</td>
                                <td>{{$item->data_ruang->nama_ruang}}</td>
                                <td>
                                    @if($item->verif_baper == 0)
                                    Belum Diverifikasi
                                    @else
                                    <label class="label bg-green">Sudah Diverifikasi</label>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('perlengkapan.peminjaman_ruang.show', $item->peminjaman_ruang->id) }}" class="btn btn-primary" title="Lihat Laporan"><i class="fa fa-eye"></i></a>    
                                    @if($item->verif_baper != 1)
                                    <a href="{{ route('perlengkapan.peminjaman_ruang.edit', $item->peminjaman_ruang->id) }}" class="btn btn-warning" title="Ubah Laporan"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if($item->verif_baper != 1)
                                    <a href="#" class="btn btn-danger" id="{{ $item->peminjaman_ruang->id }}" name="hapus_laporan" title="Hapus Laporan" data-toggle="modal" data-target="#modal-delete"><i class="fa fa-trash"></i></a>
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
                <p>Apakah anda yakin ingin membatalkan peminjaman ruang ini?</p>
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
    $(function() {
        $('#peminjaman_ruang').DataTable();
    });
</script>
@endsection