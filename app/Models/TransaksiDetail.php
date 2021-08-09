<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $table = 'transaksi_detail';
}
