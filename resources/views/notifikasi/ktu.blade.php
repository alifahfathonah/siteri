@extends('notifikasi.template')
@section('content')

@foreach (Auth::user()->unreadNotifications as $notif)
@if ($notif->type == 'App\Notifications\verifPeminjamanBarang')
<li>
	<a href="{{ route('notifikasi.read', $notif->id) }}" style="white-space: initial;">
		<i class="fa fa-exclamation-circle col-xs-2"></i>
		<div class="col-xs-10">
			Laporan Peminjaman Barang Baru<br>
			<b>{{ $notif->data['kegiatan'] }}</b><br>
			<small
			style="color: grey;">{{ Carbon\Carbon::parse($notif->data['updated_at'])->locale('id_ID')->DiffForHumans() }}</small>
		</div>
	</a>
</li>
@elseif ($notif->type == 'App\Notifications\verifPeminjamanRuang')
<li>
	<a href="{{ route('notifikasi.read', $notif->id) }}" style="white-space: initial;">
		<i class="fa fa-exclamation-circle col-xs-2"></i>
		<div class="col-xs-10">
			Laporan Peminjaman Ruang Baru<br>
			<b>{{ $notif->data['kegiatan'] }}</b><br>
			<small
			style="color: grey;">{{ Carbon\Carbon::parse($notif->data['updated_at'])->locale('id_ID')->DiffForHumans() }}</small>
		</div>
	</a>
</li>
@elseif ($notif->type == 'App\Notifications\suratTugasKepegawaian')
<li>
	<a href="{{ route('notifikasi.read', $notif->id) }}" style="white-space: initial;">
		<i class="fa fa-exclamation-circle col-xs-2"></i>
		<div class="col-xs-10">
			Surat Tugas Kepegawaian 
			{{ $notif->data['nomor_surat'] }}/UN25.1.15/KP/{{ \Carbon\Carbon::parse($notif->data['created_at'])->year }} 
			Butuh Verifikasi.
			<br>
			<small style="color: grey;">{{ Carbon\Carbon::parse($notif->created_at)->locale('id_ID')->DiffForHumans() }}</small>
		</div>
	</a>
</li>
@endif
@endforeach

@endsection
