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
     * Data for Json Format (all)
     */
    public function penjualanJson(){
        $list = Penjualan::with('penjualanDetail', 'penjualanDetail.barang', 'penjualanLog')->get()->map(function($data, $key) {
            $data->items = (object)[];
            $barang = array();
            $total = 0;
            //Detail
            foreach($data->penjualanDetail as $detail){
                $barang[] = $detail->barang->barang_nama." (".$detail->jual_qty.")";
                $total = $total + ( ($detail->harga_jual * $detail->jual_qty) - $detail->diskon );
            }

            $biayaLain = 0;
            $bayar = 0;
            foreach($data->penjualanLog as $log){
                $biayaLain = $biayaLain + $log->biaya_lain;
                $bayar = $bayar + $log->bayar;
            }
            $total = $total + $biayaLain;

            $data->items->barang = implode(", ", $barang);
            $data->items->total = $total;
            $data->items->biayaLain = $biayaLain;
            $data->items->bayar = $bayar;

            //Remove unnecessary data
            unset($data->penjualan_detail);
            unset($data->penjualanDetail);
            unset($data->penjualanLog);
            return $data;
        });

        return datatables()
                ->of($list)
                ->toJson();
        // return response()->json($list);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.penjualan.index');
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
            $item_num = 1;
            foreach($items as $item => $key){
                //Cek Stok Barang
                $barang = Barang::where('id', $request->barang_id[$item])->get();//Ambil data barang terkait
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
                        $error = false;
                        $result = true;
                    } else {
                        //Stok kurang
                        $storePenjualanDetail = 0;

                        $status .= ", Penjualan Detail GAGAL, barang_id ".$barang[0]->barang_nama.", stok : ".$barang[0]->barang_stok." | qty : ".$request->qty[$item];
                        $error = "Gagal pada barang baris ke-".$item_num." (".$barang[0]->barang_nama.") karena sisa stok kurang (Stok : ".$barang[0]->barang_stok.", Permintaan QTY : ".$request->qty[$item].")";
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
                    $error = false;
                    $result = true;
                }

                $item_num++;
            }

            if((bool) $storePenjualanDetail){
                //Insert Penjualan Log jika Penjualan Detail berhasil
                $storePenjualanLog = PenjualanLog::create([
                    'penjualan_id' => $penjualan[0]->id,
                    'user_id' => Auth::user()->id,
                    'pembayaran_tgl' => $request->pembayaran_tgl,
                    'biaya_lain' => $request->biaya_lain,
                    'bayar' => $request->bayar,
                ]);
                $status .= ", Penjualan Log OKE";
                $error = false;
                $result = true;
            }
        } else {
            //Failed to save Penjualan
        }

        $message = [
            'status' => $result,
            'error' => $error,
            'message' => $status,
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
