<?php

namespace App\Http\Controllers;

use Auth;


use App\Barang;
use App\Kategori;

use App\Pembelian;
use App\PembelianItem;
use App\PembelianBayar;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


class PembelianController extends Controller
{
    /**
     * Data for Json Format (all)
     */
    public function pembelianJson(){
        $list = Pembelian::with('pembelianItem', 'pembelianItem.barang', 'pembelianBayar')->get()->map(function($data, $key) {
            //Make formated invoice
            $data->invoice_url = str_replace('/', '-', $data->pembelian_invoice);

            //Make detail item
            $data->items = (object)[];
            $barang = array();
            $total = 0;
            //Detail
            foreach($data->pembelianItem as $detail){
                $barang[] = $detail->barang->barang_nama." (".$detail->beli_qty.")";
                $total = $total + ($detail->harga_beli * $detail->beli_qty);
            }

            $biayaLain = 0;
            $diskon = 0;
            $bayar = 0;
            foreach($data->pembelianBayar as $log){
                $biayaLain = $biayaLain + $log->biaya_lain;
                $diskon = $diskon + $log->diskon;
                $bayar = $bayar + $log->bayar;
            }
            $total = ( $total + $biayaLain ) - $diskon;

            $data->items->barang = implode(", ", $barang);
            $data->items->total = $total;
            $data->items->biayaLain = $biayaLain;
            $data->items->diskon = $diskon;
            $data->items->bayar = $bayar;

            //Remove unnecessary data
            unset($data->pembelianItem);
            unset($data->pembelianBayar);
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
        return view('staff.pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all()->sortBy('kategori_kode');
        $barang = Barang::where([
            ['barang_stokStatus', 'Aktif'],
            ['barang_status', 'Aktif']
        ])->get();
        return view('staff.pembelian.create', compact('kategori','barang'));
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
            'supplier_id' => 'required',
            'pembelian_tgl' => 'required',
            'pembayaran_tgl' => 'required',
            'bayar' => 'required',
        ]);
    }
    protected function validatorItem(array $data)
    {
        return Validator::make($data, [
            'harga_beli' => 'required|integer|min:0',
            'qty' => 'required|integer|min:1',
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
        $invoice = generateInvoice('Beli');
        $status = "";
        $result = "";
        $error = "";

        $storePembelian = Pembelian::create([
            'supplier_id' => $request->supplier_id,
            'pembelian_invoice' => $invoice,
            'pembelian_tgl' => $request->pembelian_tgl,
            'pembelian_detail' => $request->pembelian_detail,
        ]);

        //Jika sukses simpan data pembelian
        if((bool)$storePembelian){
            $status = "Pembelian Berhasil";
            $result = true;
            $error = false;

            //Get an array from field Pembelian Detail
            $items = $request->barang_id;
            //Get Pembelian
            $pembelian = Pembelian::where('pembelian_invoice', $invoice)->get();
            $item_num = 1;

            foreach($items as $item => $key){
                $storePembelianItem = PembelianItem::create([
                    'pembelian_id' => $pembelian[0]->id,
                    'barang_id' => $request->barang_id[$item],
                    'harga_beli' => $request->harga_beli[$item],
                    'beli_qty' => $request->qty[$item],
                ]);

                if((bool) $storePembelianItem){
                    //Jika store item pembelian berhasil
                    $status = "Pembelian Item Berhasil";
                    $result = true;
                    $error = false;
                } else {
                    //Jika store item pembelian berhasil
                    $status = "Pembelian Item Gagal";
                    $result = false;
                    $error = true;

                    $this->destroy($pembelian[0]->id);
                    $message = [
                        'result' => $result,
                        'error' => $error,
                        'invoice' => str_replace('/', '-', $invoice),
                        'message' => $status,
                    ];
                    return response()->json($message);
                }
            }

            if($result){
                //Insert Pembayaran
                $storePembelianBayar = PembelianBayar::create([
                    'pembelian_id' => $pembelian[0]->id,
                    'user_id' => Auth::user()->id,
                    'pembayaran_tgl' => $request->pembayaran_tgl,
                    'biaya_lain' => $request->biaya_lain,
                    'diskon' => $request->diskon,
                    'bayar' => $request->bayar,
                ]);
                $status = "Input transaksi Berhasil";
                $result = true;
                $error = false;
            } else {
                //Aksi sebelum ada yang gagal
            }
        } else {
            $status = "Pembelian Gagal";
            $result = false;
            $error = false;
        }

        $message = [
            'result' => $result,
            'error' => $error,
            'invoice' => str_replace('/', '-', $invoice),
            'message' => $status,
        ];
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show($invoice)
    {
        $id = str_replace('-', '/', $invoice);
        $pembelian = Pembelian::where('pembelian_invoice', $id)->with('supplier', 'pembelianItem', 'pembelianItem.barang', 'pembelianBayar')->firstOrFail();

        return view('staff.pembelian.invoice', compact('pembelian'));
        // return $pembelian;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit($invoice)
    {
        $id = str_replace('-', '/', $invoice);
        $pembelian = Pembelian::where('pembelian_invoice', $id)->with('supplier', 'pembelianItem', 'pembelianItem.barang', 'pembelianItem.barang.kategori', 'pembelianBayar')->firstOrFail();

        return view('staff.pembelian.edit', compact('pembelian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validator($request->all())->validate();
        $pesan = "";
        $status = "";
        $result = "";
        $isChanged = array();

        //Pembelian
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->supplier_id = $request->supplier_id;
        $pembelian->pembelian_tgl = $request->pembelian_tgl;
        $pembelian->pembelian_detail = $request->pembelian_detail;
        $isChanged[] = $pembelian->isDirty();//Check if anything change
        $getChanged[] = $pembelian->getDirty();

        $result = (bool) $pembelian->save();

        // Detail
        $items = $request->barang_id;
        $item_num = 1;
        foreach($items as $item => $key){
            $permintaanQty = 0;
            $barang = Barang::where('id', $request->barang_id[$item])->get();//Ambil data barang terkait
            $pembelianItem = PembelianItem::where([
                ['pembelian_id', $id],
                ['barang_id', $request->barang_id[$item]]
            ])->firstOrFail();//Ambil data pembelianItem terkait

            $permintaanQty = $request->qty[$item] - $pembelianItem->beli_qty;
            $pembelianItem->harga_beli = $request->harga_beli[$item];
            $pembelianItem->beli_qty = $request->qty[$item];

            $status = "Item Pembelian Berhasil. Permintaan baru : ".$permintaanQty;
            $isChanged[] = $pembelianItem->isDirty();
            $status = (bool) $pembelianItem->save();

            $item_num++;
        }

        // Log
        $pembelianBayar = PembelianBayar::where('pembelian_id', $id)->get();
        $biayaLain = 0;
        $bayar = 0;
        $diskon = 0;
        foreach($pembelianBayar as $log){
            $biayaLain = $biayaLain + $log->biaya_lain;
            $diskon = $diskon + $log->diskon;
            $bayar = $bayar + $log->bayar;
        }

        $perubahan_biayaLain = $request->biaya_lain - $biayaLain;
        $perubahan_bayar = $request->bayar - $bayar;
        $perubahan_diskon = $request->diskon - $diskon;

        if($perubahan_biayaLain != 0 || $perubahan_bayar != 0 || $perubahan_diskon != 0){
            $storepembelianBayar = PembelianBayar::create([
                'pembelian_id' => $pembelian->id,
                'user_id' => Auth::user()->id,
                'pembayaran_tgl' => $request->pembayaran_tgl,
                'biaya_lain' => $perubahan_biayaLain,
                'diskon' => $perubahan_diskon,
                'bayar' => $perubahan_bayar,
            ]);
            $isChanged[] = true;
            $error = false;
        }

        if(in_array(true, $isChanged)){
            $pembelian = Pembelian::findOrFail($id);
            $pembelian->updated_at = now();
            $error = false;

            $pesan = 'Successfully updated!';
        } else {
            $error = false;
            $pesan = 'Nothing changed!';
        }

        $message = [
            'invoice' => str_replace('/', '-', $pembelian->pembelian_invoice),
            'isChanged' => $isChanged,
            'message' => $pesan,
            'error' => $error,
        ];
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete data from Database
        $data_pembelianBayar = PembelianBayar::where('pembelian_id',$id);
        $data_pembelianItem = PembelianItem::where('pembelian_id',$id);
        $data_pembelian = Pembelian::findOrFail($id);

        if($data_pembelianBayar != null){
            $hapus_log = $data_pembelianBayar->delete();
        } else {
            $hapus_log = "Not Found";
        }
        if($data_pembelianItem != null){
            $hapus_detail = $data_pembelianItem->delete();
        } else {
            $hapus_detail = "Not Found";
        }

        $hapus_pembelian = $data_pembelian->delete();

        $message = [
            'status' => 'success',
            "message" => " successfully deleted!",
            'response' => 'Pembelian : '.$hapus_pembelian.' / Detail : '.$hapus_detail.' / Log : '.$hapus_log
        ];
        return response()->json($message);
    }
}
