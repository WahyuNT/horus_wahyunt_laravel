<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function getVoucher(){
         $voucher = Voucher::where('status','aktif')
         ->get();

         $voucherCountCategory =$voucher->count();

         return response()->json([
             'success' => true,
             'data'    => $voucher,
                'count'   => $voucherCountCategory
         ], 200);
    }
    public function detailVoucher($id){
         $voucher = Voucher::where('id',$id)->first();

         return response()->json([
             'success' => true,
             'data'    => $voucher,
         ], 200);
    }
    public function claimVoucher($id){
         $voucher = Voucher::where('id',$id)->first();
            $voucher->update([
                'status' => 'terklaim'
            ]);

         return response()->json([
             'success' => true,
             'data'    => $voucher,
         ], 200);
    }
     public function removeVoucher($id){
         $voucher = Voucher::where('id',$id)->first();
            $voucher->update([
                'status' => 'aktif'
            ]);

         return response()->json([
             'success' => true,
             'data'    => $voucher,
         ], 200);
    }
}
