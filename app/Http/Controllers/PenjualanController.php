<?php

namespace App\Http\Controllers;
use Auth;

use App\Barang;
use App\Kategori;

use App\Penjualan;
use App\PenjualanDetail;
use App\PenjualanLog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all()->sortBy('kategori_kode');
        $barang = Barang::all()->where('barang_status', 'Aktif');
        return view('staff.penjualan.create', compact('kategori','barang'));
    }

    /**
     * Validate data
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'toko_id' => 'required',
            'penjualan_tgl' => 'required',
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $invoice = invoiceJual();
        $status = "";
        $result = "";

        $storePenjualan = Penjualan::create([
            'toko_id' => $request->toko_id,
            'kostumer_id' => $request->kostumer_id,
            'penjualan_invoice' => $invoice,
            'penjualan_tgl' => $request->penjualan_tgl,
            'penjualan_detail' => $request->penjualan_detail,
        ]);

        //Jika sukses simpan data penjualan
        if((bool)$storePenjualan){
            $status .= "Penjualan OKE";
            $result = true;

            //Insert Penjualan Detail
            $items = $request->barang_id;
            //Get Penjualan
            $penjualan = Penjualan::where('penjualan_invoice', $invoice)->get();
            foreach($items as $item => $key){
                //Cek Stok Barang
                $barang = Barang::where('id', $request->barang_id[$item])->get();
                if($barang[0]->barang_stokStatus == "Aktif"){
                    //Jika Stok Aktif
                    if($barang[0]->barang_stok >= $request->qty[$item]){
                        //Jika stok lebih
                        $storePenjualanDetail = PenjualanDetail::create([
                            'penjualan_id' => $penjualan[0]->id,
                            'barang_id' => $request->barang_id[$item],
                            'harga_beli' => $request->harga_beli[$item],
                            'harga_jual' => $request->harga_jual[$item],
                            'jual_qty' => $request->qty[$item],
                            'diskon' => $request->diskon[$item],
                        ]);

                        $status .= ", Penjualan Detail OKE";
                        $result = true;
                    } else {
                        //Stok kurang
                        $status .= ", Penjualan Detail GAK OKE, barang_id ".$request->barang_id[$item].", stok : ".$barang[0]->barang_stok." | qty : ".$request->qty[$item];
                        $storePenjualanDetail = 0;
                        $result = false;

                        //Delete All Data related to this transaction
                        $status .= " | ".$this->destroy($penjualan[0]->id);
                    }
                } else {
                    $storePenjualanDetail = PenjualanDetail::create([
                        'penjualan_id' => $penjualan[0]->id,
                        'barang_id' => $request->barang_id[$item],
                        'harga_beli' => $request->harga_beli[$item],
                        'harga_jual' => $request->harga_jual[$item],
                        'jual_qty' => $request->qty[$item],
                        'diskon' => $request->diskon[$item],
                    ]);
                    $status .= ", Penjualan Detail OKE, tanpa stok. Barang_id ".$request->barang_id[$item];
                    $result = true;
                }
            }

            if((bool) $storePenjualanDetail){
                //Insert Penjualan Log
                $storePenjualanLog = PenjualanLog::create([
                    'penjualan_id' => $penjualan[0]->id,
                    'user_id' => Auth::user()->id,
                    'pembayaran_tgl' => $request->pembayaran_tgl,
                    'biaya_lain' => $request->biaya_lain,
                    'bayar' => $request->bayar,
                ]);
                $status .= ", Penjualan Log OKE";
                $result = true;
            }
        } else {
            //Failed to save Penjualan
        }

        $message = [
            'status' => $result,
            "message" => $status,
        ];
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete data from Database
        $data_penjualanLog = PenjualanLog::where('penjualan_id',$id);
        $data_penjualanDetail = PenjualanDetail::where('penjualan_id',$id);
        $data_penjualan = Penjualan::findOrFail($id);

        if($data_penjualanLog != null){
            $hapus_log = $data_penjualanLog->delete();
        } else {
            $hapus_log = "Not Found";
        }
        if($data_penjualanDetail != null){
            $hapus_detail = $data_penjualanDetail->delete();
        } else {
            $hapus_detail = "Not Found";
        }

        $hapus_penjualan = $data_penjualan->delete();

        $message = [
            'status' => 'success',
            "message" => " successfully deleted!",
            'response' => 'Penjualan : '.$hapus_penjualan.' / Detail : '.$hapus_detail.' / Log : '.$hapus_log
        ];
        return response()->json($message);
    }
}
