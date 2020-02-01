@extends('admin.admin_view')
@section('page_title','Admin Dashboard')
@section('content')
<section class="content-header">
    <h1>
        <b>DATA PEGAWAI</b>
    </h1>
</section>
<!-- Main content -->
@include('layouts.flashmsg')
<section class="content">
    <div class="box">
        <div class="box-header">
            <!-- alert create pegawai -->

            <!-- alert create pegawai -->

            <!-- alert create pegawai -->
            <div class="row">
                <div class="col-sm-8">
                <a class="btn btn-primary" href="{{route('admin.pegawai.create')}}">Tambah Pegawai</a>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>

            <form method="POST" action="#">
                <input type="hidden" name="_token" value="3mVEDsiJVqtGW8Y4bp9s6IsqIDoVfy95PqOdJZTb">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pencarian</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputnama" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input value="" type="text" class="form-control" name="nama" id="inputnama"
                                            placeholder="Nama">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputjabatan" class="col-sm-3 control-label">Jabatan</label>
                                    <div class="col-sm-9">
                                        <input value="" type="text" class="form-control" name="jabatan"
                                            id="inputjabatan" placeholder="Jabatan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            Cari
                        </button>
                    </div>
                </div>
            </form>

            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                            aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th width="2%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                        <center>No</center>
                                    </th>
                                    <th width="15%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                        <center>Nama Pegawai</center>
                                    </th>
                                    <th width="15%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                        <center>NIP</center>
                                    </th>
                                    <th width="20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                        <center>Jabatan Fungsional</center>
                                    </th>
                                    <th width="20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                        <center>Pangkat</center>
                                    </th>
                                    <th width="10%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                        <center>Golongan</center>
                                    </th>
                                    {{-- <th width="3%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"><center>Tingkat</center></th> --}}
                                    <th width="20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="2">
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1; 
                                if ($data->currentPage() == 1) {
                                    $skipped = 0;
                                }
                                else {
                                    $skipped = $data->currentPage() * $data->perPage();
                                }
                                ?>
                                @foreach ($data as $user)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{$skipped + $no}}</td>
                                    <td class="hidden-xs">{{$user->nama}}</td>
                                    <td class="hidden-xs">{{$user->no_pegawai}}</td>
                                    <td class="hidden-xs">{{$user->fungsionalnya['jab_fungsional']}}</td>
                                    {{-- <td class="hidden-xs">{{$user->jabatannya['jabatan']}}</td> --}}
                                    <td class="hidden-xs">{{$user->pangkatnya['pangkat']}}</td>
                                    <td class="hidden-xs">{{$user->golongannya['golongan']}}</td>
                                    <td>
                                        <form class="row" method="POST" action="{{route('admin.pegawai.destroy', $user->username)}}"
                                            onsubmit="return confirm('Are you sure?')">
                                            @method('DELETE')
                                            @csrf
                                            <a href="
                                            @php
                                             if($user->username == " admin"){ echo "#" ; } @endphp
                                                {{route('admin.pegawai.edit', $user->username)}}"
                                                class="btn btn-warning col-sm-5 col-xs-5 btn-margin"
                                                style="margin-left: 10px;">
                                                Edit
                                            </a>
                                            <button type="submit" class="btn btn-danger col-sm-5 col-xs-5 btn-margin"
                                                style="margin-left: 5px;">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                    @php
                                    $no++;
                                    @endphp
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to
                            {{count($data)}} of {{count($data)}} entries</div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<!-- /.content -->
@endsection