<?php

namespace App\Http\Controllers;

use App\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TokoController extends Controller
{
    /**
     * Data for Json Format (all)
     */
    public function tokoJson(){
        $list = Toko::where('toko_status', 'Aktif');
        return datatables()
                ->of($list)
                ->toJson();
    }
    public function tokoTipeJson(Request $request){
        $list = Toko::where([
            ['toko_tipe', $request->toko_tipe],
            ['toko_status', 'Aktif'],
        ]);
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
        return view('staff.toko.index');
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
            'toko_tipe' => 'required|',
            'toko_nama' => 'required|string|max:191',
            'toko_alamat' => 'max:191',
            'toko_link' => 'max:191',
            'toko_kontak' => 'max:191',
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
        $store = Toko::create([
            'toko_tipe' => $request->toko_tipe,
            'toko_nama' => $request->toko_nama,
            'toko_alamat' => $request->toko_alamat,
            'toko_link' => $request->toko_link,
            'toko_kontak' => $request->toko_kontak,
        ]);
        $message = [
            "status" => "success",
            "message" => "Successfully add ".$request->toko_nama." to database!",
            "response" => $store,
        ];
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Toko  $toko
     * @return \Illuminate\Http\Response
     */
    public function show(Toko $toko)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Toko  $toko
     * @return \Illuminate\Http\Response
     */
    public function edit(Toko $toko)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Toko  $toko
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validator($request->all())->validate();
        $toko = Toko::findOrFail($id);
        $toko->toko_tipe = $request->toko_tipe;
        $toko->toko_nama = $request->toko_nama;
        $toko->toko_alamat = $request->toko_alamat;
        $toko->toko_link = $request->toko_link;
        $toko->toko_kontak = $request->toko_kontak;

        $message = [
            'status' => 'success',
            'message' => $toko->toko_nama.' successfully deleted!',
            'response' => $toko->save(),
        ];
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Toko  $toko
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $toko = Toko::findOrFail($id);
        $toko->toko_status = "Tidak Aktif";

        $message = [
            'status' => 'success',
            'message' => $toko->toko_nama.' successfully deleted!',
            'response' => $toko->save(),
        ];
        return response()->json($message);
    }
}
