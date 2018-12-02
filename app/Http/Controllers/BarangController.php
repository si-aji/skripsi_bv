<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Data for Json Format (all)
     */
    public function barangJson(){
        $list = Barang::where('barang_status', 'Aktif')->with('kategori');
        return datatables()
                ->of($list)
                ->toJson();
    }
    /**
     * Data for Json Format (select2 - for select barang at penjualanItem)
     */
    public function barangSelectTwoJson(){
        $array = array();
        $array_barang = array();
        $list_kategori = Kategori::all()->sortBy('kategori_kode');
        foreach($list_kategori as $kategori){
            $data = (object) [];
            $data->id = 0;
            $data->text = $kategori->kategori_nama;

            $list = Barang::where([
                ['kategori_id', $kategori->id],
                ['barang_status', 'Aktif']
            ])->get();
            foreach($list as $barang){
                $data_barang = (object) [];
                $data_barang->id = $barang->id;
                $data_barang->text = $barang->barang_nama;

                array_push($array_barang, $data_barang); //Push data untuk children select 2
            }
            $data->children = $array_barang;
            array_push($array, $data);

            unset($array_barang); //Unset data pada array_barang
            $array_barang = array(); //Re-init array data_barang
        }
        return response()->json($array);
    }
    /**
     * Data for Json Format (Specific by id)
     */
    public function barangSpecificJson($id){
        $list = Barang::where('id', $id)->with('kategori');
        return datatables()
                ->of($list)
                ->toJson();
    }
    /**
     * Data for Json Format (Specific by kategori)
     */
    public function kategoriSpecificJson($id){
        $list = Barang::where('kategori_id', $id)->max('barang_kode');
        return response()->json($list);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.barang.index');
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
            'kategori_id' => 'required|',
            'barang_nama' => 'required|string',
            'barang_stokStatus' => 'required|string',
            'barang_stok' => 'required|integer|min:0',
            'barang_hBeli' => 'required|integer|min:0',
            'barang_hJual' => 'required|integer|min:0',
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
        $store = Barang::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'barang_stokStatus' => $request->barang_stokStatus,
            'barang_stok' => $request->barang_stok,
            'barang_hBeli' => $request->barang_hBeli,
            'barang_hJual' => $request->barang_hJual,
            'barang_detail' => $request->barang_detail,
            'barang_status' => "Aktif",
            'barang_slug' => str_slug($request->barang_nama, '-')
        ]);
        $message = [
            "status" => "success",
            "message" => "Successfully add ".$request->barang_nama." to database!",
            "response" => $store,
        ];
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->kategori_id = $request->kategori_id;
        $barang->barang_kode = $request->barang_kode;
        $barang->barang_nama = $request->barang_nama;
        $barang->barang_stokStatus = $request->barang_stokStatus;
        $barang->barang_stok = $request->barang_stok;
        $barang->barang_hBeli = $request->barang_hBeli;
        $barang->barang_hJual = $request->barang_hJual;
        $barang->barang_detail = $request->barang_detail;
        $barang->barang_slug = str_slug($request->barang_nama, '-');

        $message = [
            'status' => 'success',
            'message' => $barang->barang_nama.' successfully updated!',
            'response' => $barang->save(),
        ];
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->barang_status = "Tidak Aktif";

        $message = [
            'status' => 'success',
            'message' => $barang->barang_nama.' successfully deleted!',
            'response' => $barang->save(),
        ];
        return response()->json($message);
    }
}
