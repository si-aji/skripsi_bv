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
    public function paketJson()
    {
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
    public function paketSelectTwoJson()
    {
        $array = array();
        $array_item = array();
        $barang = array();
        $list_paket = Paket::where('paket_status', 'Aktif')->with('paketItem', 'paketItem.barang')->orderBy('paket_nama')->get();

        foreach($list_paket as $paket){
            $data = (object) [];
            $data->id = 0;
            $data->text = $paket->paket_nama;
            foreach($paket->paketItem as $paketItem){
                // array_push($array_barang, $paketItem->barang->barang_nama);
                $barang[] = ucwords($paketItem->barang->barang_nama);
            }
            //$data->text = implode(', ', $barang);

            $data_item = (object) [];
            $data_item->id = $paket->id;
            $data_item->text = implode(', ', $barang);

            array_push($array_item, $data_item); //Push data untuk children select 2
            $data->children = $array_item;

            array_push($array, $data);

            unset($barang);
            unset($array_item);
            $barang = array();
            $array_item = array();
        }

        return response()->json($array);
    }
    public function paketSpecificJson($id)
    {
        $list = Paket::where('id', $id)->with('paketItem')->get()->map(function($data, $key) {
            $data->barang_hJual = (object)[];

            $data->barang_hJual = $data->paket_harga;
            $data->barang_hBeli = "0";

            return $data;
        });
        return datatables()
                ->of($list)
                ->toJson();
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
     * Check if two array have similiar value
     *
     * @param  $a and $b
     */
    private function array_values_identical($a, $b) {
        $x = array_values($a);
        $y = array_values($b);

        sort($x);
        sort($y);

        return $x === $y;
    }

    /**
     * Check if Paket is Already Exist
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkPaket(Request $request)
    {
        $data = array();
        foreach($request->barang_id as $item => $key){
            array_push($data, $request->barang_id[$item]);
        }
        $data = array_map('intval', $data); //Convert String to Integer

        $temp_item = array();
        $dataPaket = Paket::where('paket_status', 'aktif')->with('paketItem')->get();

        foreach($dataPaket as $paket){
            //Reset temp item
            unset($temp_item);
            $temp_item = array();
            foreach($paket->paketItem as $item){
                array_push($temp_item, $item->barang_id);
            }

            //Cek kombinasi item apakah sudah ada atau belum
            if($this->array_values_identical($data, $temp_item)){
                $message = [
                    'message' => "Exists at paket : ".$paket->paket_nama,
                ];
                return $message;
            }
        }

        //Jika paket belum ada
        $this->validator($request->all())->validate();
        $storePaket = Paket::create([ //Save Paket
            'paket_nama' => $request->paket_nama,
            'paket_harga' => $request->paket_harga,
            'paket_status' => "Aktif",
        ]);

        $dataPaket = Paket::where('paket_nama', $request->paket_nama)->firstOrFail();
        foreach($request->barang_id as $item => $key){
            $storePaketItem = PaketItem::create([//Save Paket Item
                'paket_id' => $dataPaket->id,
                'barang_id' => $request->barang_id[$item],
                'barang_hAsli' => $request->harga_asli[$item],
                'barang_hJual' => $request->harga_item[$item],
            ]);
        }

        $message = [
            'message' => "Paket berhasil dibuat",
        ];
        return $message;
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
        $harga_jual = 0;
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

                $harga_jual += $request->harga_item[$item];
            }

            if(in_array(true, $isChanged)){
                $paket = Paket::findOrFail($id);
                $paket->paket_harga = $harga_jual;
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
