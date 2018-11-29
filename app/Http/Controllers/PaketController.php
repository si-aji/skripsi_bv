<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Paket;
use App\PaketItem;

use App\Kategori;
use App\Barang;

class PaketController extends Controller
{
    public function paketJson(){
        $list = Paket::where('paket_status', 'Aktif')->with('paketItem', 'paketItem.barang')->get()->map(function($data, $key) {
            //Membuat Data Barang
            $data->items = (object)[];
            $barang = array();
            foreach($data->paketItem as $detail){
                $barang[] = ucwords($detail->barang->barang_nama);
            }

            $data->items->barang = implode(", ", $barang);

            //Remove unnecessary data
            unset($data->paketItem);
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
        $kategori = Kategori::all()->sortBy('kategori_kode');
        $barang = Barang::all()->where('barang_status', 'Aktif');
        return view('staff.paket.index', compact('kategori', 'barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'paket_nama' => 'required|unique:tbl_paket,paket_nama',
            'paket_harga' => 'required|integer',
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

        $storePaket = Paket::create([
            'paket_nama' => $request->paket_nama,
            'paket_harga' => $request->paket_harga,
            'paket_status' => "Aktif",
        ]);

        $dataPaket = Paket::where('paket_nama', $request->paket_nama)->firstOrFail();

        $items = $request->barang_id;
        foreach($items as $item => $key){//Simpan Item Paket
            $storePaketItem = PaketItem::create([
                'paket_id' => $dataPaket->id,
                'barang_id' => $request->barang_id[$item],
                'barang_hAsli' => $request->harga_asli[$item],
                'barang_hJual' => $request->harga_item[$item],
            ]);
        }

        $message = [
            'hasil' => true,
            'error' => false,
            'message' => "Paket berhasil dibuat",
        ];
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function show(Paket $paket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paket = Paket::with('paketItem', 'paketItem.barang')->findOrFail($id);

        $kategori = Kategori::all()->sortBy('kategori_kode');
        $barang = Barang::all()->where('barang_status', 'Aktif');
        return view('staff.paket.edit', compact("paket", "kategori", "barang"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exists = array();
        $isChanged = array();

        if($request->permintaan == "hapus_item"){
            $paketItem = paketItem::where([
                ['paket_id', $request->paket_id],
                ['barang_id', $request->barang_id]
            ]);

            $message = [
                'hasil' => (bool) $paketItem->delete(),
                'error' => false,
                'message' => "Item berhasil dihapus",
            ];

            return response()->json($message);
        } else {
            $items = $request->barang_id;
            foreach($items as $item => $key){//Simpan Item Paket
                $paketItem = paketItem::where([
                    ['paket_id', $request->id],
                    ['barang_id', $request->barang_id[$item]]
                ])->first();

                if($paketItem !== null){
                    // Paket ada, ubah paket tersebut
                    $paketItem->barang_hJual = $request->harga_item[$item];
                    $isChanged[] = $paketItem->isDirty();
                    $paketItem->save();
                } else {
                    // Item tidak ada, tambah item baru
                    $storePaketItem = PaketItem::create([
                        'paket_id' => $request->id,
                        'barang_id' => $request->barang_id[$item],
                        'barang_hAsli' => $request->harga_asli[$item],
                        'barang_hJual' => $request->harga_item[$item],
                    ]);
                    $isChanged[] = (bool) $storePaketItem;
                }
            }

            if(in_array(true, $isChanged)){
                $paket = Paket::findOrFail($id);
                $paket->updated_at = now();
                $paket->save();

                $pesan = 'Successfully updated!';
            } else {
                $pesan = 'Nothing changed!';
            }

            $message = [
                'id_paket' => $id,
                'isChanged' => $isChanged,
                'message' => $pesan,
            ];

            return response()->json($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paket $paket)
    {
        //
    }
}
