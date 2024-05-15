<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherClaim extends Model
{
    use HasFactory;
    protected $table = 'voucher_claim';
    protected $fillable =  [
        'id_voucher',
        'tanggal_claim',
  
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher', 'id');
    }

}
