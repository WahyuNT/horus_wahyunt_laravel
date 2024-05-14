<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function getVoucher(){
         $voucher = Voucher::all();

         return response()->json([
             'success' => true,
             'data'    => $voucher,
         ], 200);
    }
    public function detailVoucher($id){
         $voucher = Voucher::where('id',$id)->first();

         return response()->json([
             'success' => true,
             'data'    => $voucher,
         ], 200);
    }
}
