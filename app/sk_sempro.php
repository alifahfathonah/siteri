<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sk_sempro extends Model
{
    protected $table = "sk_sempro";
    protected $primaryKey = "no_surat";
    public $timestamps = TRUE;
    public $incrementing = FALSE;
    protected $fillable = ['no_surat','id_status_sk','tgl_sempro1','tgl_sempro2','verif_ktu','pesan_revisi'];

    public function status_sk()
    {
        return $this->belongsTo('App\status_sk','id_status_sk');
    }

    public function detail_skripsi()
    {
        return $this->hasMany('App\detail_skripsi', 'id_sk_sempro');
    }
}
