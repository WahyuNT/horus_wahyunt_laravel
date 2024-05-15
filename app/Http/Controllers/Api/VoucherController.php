<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherClaim;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function getVoucher(){
         $voucher = Voucher::where('status','aktif')
         ->get();

         return response()->json([
             'success' => true,
             'data'    => $voucher,
         ], 200);
    }
    public function getVoucherKategori($kategori){
         $voucher = Voucher::where('status','aktif')
            ->where('kategori',$kategori)
         ->get();



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
    public function claimVoucher($id){

        $voucher = Voucher::where('id',$id)->first();
        $voucher->update([
                'status' => 'terklaim'
        ]);

        $postVoucher = VoucherClaim::create([
            'id_voucher' => $id,
            'tanggal_claim' => now(),
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

            $removeVoucher = VoucherClaim::where('id_voucher',$id)->delete();

         return response()->json([
             'success' => true,
             'data'    => $voucher,
         ], 200);
    }

    public function history(){

        $voucher =VoucherClaim::with('voucher')->get();
        $total = $voucher->count();
       
        return response()->json([
            'success' => true,
            'data'    => $voucher,
            'total'   => $total
        ], 200);
   }
    public function historyKategori($kategori){
        
        $voucher =VoucherClaim::whereHas('voucher', function($query) use ($kategori){
            $query->where('kategori', $kategori);
        })->with('voucher')->get();
        
        
        return response()->json([
            'success' => true,
            'data'    => $voucher,
           
        ], 200);
   }

   public function kategoryVoucher(){
    
    $vouchers = Voucher::where('status', 'aktif')->get();
    
    $kategoriCounts = [];


    foreach ($vouchers as $voucher) {
        $kategori = $voucher->kategori; 
        if (!isset($kategoriCounts[$kategori])) {
            $kategoriCounts[$kategori] = 0;
        }
        $kategoriCounts[$kategori]++;
    }

    $kategoriData = [];
    foreach ($kategoriCounts as $kategori => $count) {
        $kategoriData[] = [
            'kategori' => $kategori,
            'jumlah' => $count,
        ];
    }

    return response()->json([
        'success' => true,
        'data' => $kategoriData,
    ], 200);
    }
   public function kategoryVoucherClaim(){
    
    $vouchers = Voucher::where('status', 'terklaim')->get();
    
    $kategoriCounts = [];


    foreach ($vouchers as $voucher) {
        $kategori = $voucher->kategori; 
        if (!isset($kategoriCounts[$kategori])) {
            $kategoriCounts[$kategori] = 0;
        }
        $kategoriCounts[$kategori]++;
    }

    $kategoriData = [];
    foreach ($kategoriCounts as $kategori => $count) {
        $kategoriData[] = [
            'kategori' => $kategori,
            'jumlah' => $count,
        ];
    }

    $total = array_sum(array_column($kategoriData, 'jumlah'));

    return response()->json([
        'success' => true,
        'data' => $kategoriData,
        'total' => $total
    ], 200);
    }

}
