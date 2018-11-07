<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Kategori;

use App\Penjualan;
use App\PenjualanDetail;
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

        $storePenjualan = Penjualan::create([
            'toko_id' => $request->toko_id,
            'kostumer_id' => $request->kostumer_id,
            'penjualan_invoice' => invoiceJual(),
            'penjualan_tgl' => $request->penjualan_tgl,
            'penjualan_detail' => $request->penjualan_detail,
        ]);

        //Jika sukses simpan data penjualan
        if((bool)$storePenjualan){
            //Insert Penjualan Detail
            $items = $request->barang_id;
            //Get Penjualan
            $penjualan = Penjualan::where('penjualan_invoice', invoiceJual())->get();
            foreach($items as $item => $key){
                $storePenjualanDetail = PenjualanDetail::create([
                    'penjualan_id' => $penjualan[0]->id,
                    'barang_id' => $request->barang_id[$item],
                    'harga_beli' => $request->harga_beli[$item],
                    'harga_jual' => $request->harga_jual[$item],
                    'jual_qty' => $request->qty[$item],
                    'diskon' => $request->diskon[$item],
                ]);
            }
        } else {
            //Delete Where Invoice is same with invoiceJual()
        }
        return response()->json($penjualan[0]->id);
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
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
}
