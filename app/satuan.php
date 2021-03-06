<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class satuan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'satuan';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function detail_pinjam_barang()
    {
        return $this->hasMany('App\detail_pinjam_barang', 'idsatuan_fk');
    }
}
