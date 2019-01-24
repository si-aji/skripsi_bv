<?php

namespace App\Http\Controllers;
use Auth;

use App\Barang;
use App\Kategori;

use App\Penjualan;
use App\PenjualanItem;
use App\PenjualanBayar;

use App\Paket;
use App\PaketItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * Data for Json Format (all)
     */
    public function penjualanJson(){
        $list = Penjualan::with('penjualanItem', 'penjualanItem.barang', 'penjualanBayar')->get()->map(function($data, $key) {
            //Make formated invoice
            $data->invoice_url = str_replace('/', '-', $data->penjualan_invoice);

            //Make detail item
            $data->items = (object)[];
            $barang = array();
            $total = 0;
            //Detail
            foreach($data->penjualanItem as $detail){
                $barang[] = $detail->barang->barang_nama." (".$detail->jual_qty.")";
                $total = $total + ( ($detail->harga_jual * $detail->jual_qty) - $detail->diskon );
            }

            $biayaLain = 0;
            $bayar = 0;
            foreach($data->penjualanBayar as $log){
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
            unset($data->penjualanItem);
            unset($data->penjualanBayar);
            return $data;
        });

        return datatables()
                ->of($list)
                ->toJson();
        // return response()->json($list);
    }

    public function penjualanFilterJson(Request $request){
        $query = Penjualan::query();

        if($request->filter_tanggal == "Y"){
            $query = $query->whereBetween('penjualan_tgl', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        $list = $query->with('penjualanItem', 'penjualanItem.barang', 'penjualanBayar')->get()->map(function($data, $key) {
            //Make formated invoice
            $data->invoice_url = str_replace('/', '-', $data->penjualan_invoice);

            //Make detail item
            $data->items = (object)[];
            $barang = array();
            $total = 0;
            //Detail
            foreach($data->penjualanItem as $detail){
                $barang[] = $detail->barang->barang_nama." (".$detail->jual_qty.")";
                $total = $total + ( ($detail->harga_jual * $detail->jual_qty) - $detail->diskon );
            }

            $biayaLain = 0;
            $bayar = 0;
            foreach($data->penjualanBayar as $log){
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
            unset($data->penjualanItem);
            unset($data->penjualanBayar);
            return $data;
        });

        return datatables()
                ->of($list)
                ->toJson();
        // return response()->json($list);
    }

    public function penjualanDateBasedJson(Request $request){
        $list = Penjualan::whereBetween('penjualan_tgl', [$request->tanggal_mulai, $request->tanggal_akhir])->with('penjualanItem', 'penjualanItem.barang', 'penjualanBayar')->get()->map(function($data, $key) {
            //Make formated invoice
            $data->invoice_url = str_replace('/', '-', $data->penjualan_invoice);

            //Make detail item
            $data->items = (object)[];
            $barang = array();
            $total = 0;
            //Detail
            foreach($data->penjualanItem as $detail){
                $barang[] = $detail->barang->barang_nama." (".$detail->jual_qty.")";
                $total = $total + ( ($detail->harga_jual * $detail->jual_qty) - $detail->diskon );
            }

            $biayaLain = 0;
            $bayar = 0;
            foreach($data->penjualanBayar as $log){
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
            unset($data->penjualanItem);
            unset($data->penjualanBayar);
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
            'pembayaran_tgl' => 'required',
            'bayar' => 'required',
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
        $invoice = generateInvoice('Jual');
        $status = "";
        $result = "";
        $list_paketItem = "";

        $storePenjualan = Penjualan::create([
            'toko_id' => $request->toko_id,
            'kostumer_id' => $request->kostumer_id,
            'penjualan_invoice' => $invoice,
            'penjualan_tgl' => $request->penjualan_tgl,
            'penjualan_detail' => $request->penjualan_detail,
        ]);

        //Jika sukses simpan data penjualan
        if((bool)$storePenjualan){
            $status = "Penjualan Berhasil";
            $result = true;

            //Get an array from field Penjualan Detail
            $items = $request->barang_id;
            $penjualan = Penjualan::where('penjualan_invoice', $invoice)->firstOrFail(); //Get Penjualan
            $item_num = 1;
            foreach($items as $item => $key){//Perulangan Item
                $request_diskon = $request->diskon[$item];
                //Cek apakah Paket / Barang satuan
                if($request->statusPaket[$item] == "checked"){
                    //Jika paket
                    $list_paketItem = paketItem::where('paket_id', $request->barang_id[$item])->get();

                    foreach($list_paketItem as $paketItem){
                        $barang = Barang::where('id', $paketItem->barang_id)->firstOrFail();
                        $paket = Paket::where('id', $paketItem->paket_id)->firstOrFail();

                        if($barang->barang_stokStatus == "Aktif"){ //Check Status
                            if($barang->barang_stok >= $request->qty[$item]){ //Jika stok >= permintaan
                                $storepenjualanItem = penjualanItem::create([
                                    'penjualan_id' => $penjualan->id,
                                    'barang_id' => $barang->id,
                                    'harga_beli' => $barang->barang_hBeli,
                                    'harga_jual' => $paketItem->barang_hJual,
                                    'jual_qty' => $request->qty[$item],
                                    'diskon' => $request_diskon,
                                ]);
                            } else {
                                $status = "(Baris item ke-".$item_num.") Kesalahan pada ".$barang->barang_nama." (Paket : ".$paket->paket_nama."), stok : ".$barang->barang_stok." | permintaan : ".$request->qty[$item];
                                $this->destroy($penjualan->id);
                                return response()->json($status);
                            }
                        } else {
                            $storepenjualanItem = penjualanItem::create([
                                'penjualan_id' => $penjualan->id,
                                'barang_id' => $barang->id,
                                'harga_beli' => $barang->barang_hBeli,
                                'harga_jual' => $paketItem->barang_hJual,
                                'jual_qty' => $request->qty[$item],
                                'diskon' => $request_diskon,
                            ]);
                        }

                        $request_diskon = 0;
                    }
                } else {
                    //Jika barang satuan
                    $barang = Barang::where('id', $request->barang_id[$item])->firstOrFail();

                    if($barang->barang_stokStatus == "Aktif"){ //Check Status
                        if($barang->barang_stok >= $request->qty[$item]){ //Jika stok >= permintaan
                            $storepenjualanItem = penjualanItem::create([
                                'penjualan_id' => $penjualan->id,
                                'barang_id' => $barang->id,
                                'harga_beli' => $barang->barang_hBeli,
                                'harga_jual' => $barang->barang_hJual,
                                'jual_qty' => $request->qty[$item],
                                'diskon' => $request->diskon[$item],
                            ]);
                        } else {
                            $status = "(Baris item ke-".$item_num.") Kesalahan pada barang".$barang->barang_nama.", stok : ".$barang->barang_stok." | qty : ".$request->qty[$item];
                            $this->destroy($penjualan->id);
                            return response()->json($status);
                        }
                    } else {
                        $storepenjualanItem = penjualanItem::create([
                            'penjualan_id' => $penjualan->id,
                            'barang_id' => $barang->id,
                            'harga_beli' => $barang->barang_hBeli,
                            'harga_jual' => $barang->barang_hJual,
                            'jual_qty' => $request->qty[$item],
                            'diskon' => $request->diskon[$item],
                        ]);
                    }
                }
                $item_num++;
            }

            if((bool) $storepenjualanItem){
                //Insert Penjualan Log jika Penjualan Detail berhasil
                $storepenjualanBayar = penjualanBayar::create([
                    'penjualan_id' => $penjualan->id,
                    'user_id' => Auth::user()->id,
                    'pembayaran_tgl' => $request->pembayaran_tgl,
                    'biaya_lain' => $request->biaya_lain,
                    'bayar' => $request->bayar,
                ]);
                $status = "Input transaksi Berhasil";
                $error = false;
                $result = true;
            }
        } else {
            //Failed to save Penjualan
        }

        $message = [
            'result' => $result,
            'invoice' => str_replace('/', '-', $invoice),
            'message' => $status,
            'error' => false,
        ];
        return response()->json($message);
        // return response()->json($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show($invoice)
    {
        $id = str_replace('-', '/', $invoice);
        $penjualan = Penjualan::where('penjualan_invoice', $id)->with('toko', 'kostumer', 'penjualanItem', 'penjualanItem.barang', 'penjualanBayar')->firstOrFail();

        return view('staff.penjualan.invoice', compact('penjualan'));
        // return $penjualan;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit($invoice)
    {
        $id = str_replace('-', '/', $invoice);
        $penjualan = Penjualan::where('penjualan_invoice', $id)->with('toko', 'kostumer', 'penjualanItem', 'penjualanItem.barang', 'penjualanItem.barang.kategori', 'penjualanBayar')->firstOrFail();

        // return response()->json($penjualan);
        return view('staff.penjualan.edit', compact('penjualan'));
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
        $this->validator($request->all())->validate();
        $pesan = "";
        $status = "";
        $result = "";
        $isChanged = array();

        $penjualan = Penjualan::findOrFail($id);
        //Penjualan
        $penjualan->toko_id = $request->toko_id;
        $penjualan->kostumer_id = $request->kostumer_id;
        $penjualan->penjualan_tgl = $request->penjualan_tgl;
        $penjualan->penjualan_detail = $request->penjualan_detail;

        $isChanged[] = $penjualan->isDirty();//Check if anything change
        $status_penjualan = $penjualan->save();

        //Detail
        $items = $request->barang_id;
        $item_num = 1;
        foreach($items as $item => $key){
            //Cek Stok Barang
            $barang = Barang::where('id', $request->barang_id[$item])->get();//Ambil data barang terkait
            $penjualanItem = penjualanItem::where([
                ['penjualan_id', $id],
                ['barang_id', $request->barang_id[$item]]
            ])->firstOrFail();//Ambil data penjualanItem terkait

            if($barang[0]->barang_stokStatus == "Aktif"){ //Jika Stok Aktif
                //Cek perubahan permintaan
                $permintaanQty = $request->qty[$item] - $penjualanItem->jual_qty;

                if($barang[0]->barang_stok >= $permintaanQty){ //Cek sisa stok dengan perubahan permintaan
                    //Jika sisa stok lebih
                    $penjualanItem->harga_jual = $request->harga_jual[$item];
                    $penjualanItem->jual_qty = $request->qty[$item];
                    $penjualanItem->diskon = $request->diskon[$item];

                    $status = "Item Penjualan Berhasil. Permintaan baru : ".$permintaanQty;
                    $error = false;
                    $isChanged[] = $penjualanItem->isDirty();

                    $result = (bool) $penjualanItem->save();
                } else {
                    //Sisa stok kurang
                    $storepenjualanItem = 0;

                    $status = "(Baris item ke-".$item_num.") Kesalahan pada barang ".$barang[0]->barang_nama.", sisa stok : ".$barang[0]->barang_stok." | tambahan permintaan : ".$permintaanQty;
                    $error = "(Baris item ke-".$item_num.") Kesalahan pada barang ".$barang[0]->barang_nama.", sisa stok : ".$barang[0]->barang_stok." | tambahan permintaan : ".$permintaanQty;
                    $result = false;

                    $message = [
                        'status' => $result,
                        'error' => $error,
                        'invoice' => '',
                        'message' => $status,
                    ];
                    return response()->json($message);
                }
            } else {
                $penjualanItem->harga_jual = $request->harga_jual[$item];
                $penjualanItem->jual_qty = $request->qty[$item];
                $penjualanItem->diskon = $request->diskon[$item];

                $status = "Item Penjualan Berhasil, tanpa stok. Barang_id ".$request->barang_id[$item];
                $error = false;
                $isChanged[] = $penjualanItem->isDirty();
                $result = (bool) $penjualanItem->save();
            }
            $item_num++;
        }

        //Log
        $penjualanBayar = penjualanBayar::where('penjualan_id', $id)->get();
        $biayaLain = 0;
        $bayar = 0;
        foreach($penjualanBayar as $log){
            $biayaLain = $biayaLain + $log->biaya_lain;
            $bayar = $bayar + $log->bayar;
        }

        $perubahan_biayaLain = $request->biaya_lain - $biayaLain;
        $perubahan_bayar = $request->bayar - $bayar;

        if($perubahan_biayaLain != 0 || $perubahan_bayar != 0){
            $storepenjualanBayar = penjualanBayar::create([
                'penjualan_id' => $penjualan->id,
                'user_id' => Auth::user()->id,
                'pembayaran_tgl' => $request->pembayaran_tgl,
                'biaya_lain' => $perubahan_biayaLain,
                'bayar' => $perubahan_bayar,
            ]);

            $isChanged[] = true;
        }

        if(in_array(true, $isChanged)){
            $penjualan = Penjualan::findOrFail($id);
            $penjualan->updated_at = now();
            $penjualan->save();

            $pesan = 'Successfully updated!';
        } else {
            $pesan = 'Nothing changed!';
        }

        $message = [
            'invoice' => str_replace('/', '-', $penjualan->penjualan_invoice),
            'isChanged' => $isChanged,
            'message' => $pesan,
            'status' => $status,
        ];

        return response()->json($message);
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
        $data_penjualanBayar = penjualanBayar::where('penjualan_id',$id);
        $data_penjualanItem = penjualanItem::where('penjualan_id',$id);
        $data_penjualan = Penjualan::findOrFail($id);

        if($data_penjualanBayar != null){
            $hapus_log = $data_penjualanBayar->delete();
        } else {
            $hapus_log = "Not Found";
        }
        if($data_penjualanItem != null){
            $hapus_detail = $data_penjualanItem->delete();
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
