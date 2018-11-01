<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;

//For Validating data
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Data for Json Format (All)
     */
    public function kategoriAllJson()
    {
        $list = Kategori::all()->sortBy('kategori_kode');
        return datatables()
                ->of($list)
                ->toJson();
    }
    /**
     * Data for Json Format (Specific by id)
     */
    public function kategoriSpecificJson($id){
        $list = Kategori::all()->where('id', $id);
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
        return view('staff.kategori.index');
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
            'kategori_kode' => 'required|string|max:10|unique:tbl_kategori,kategori_kode',
            'kategori_nama' => 'required|string',
        ]);
    }
    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'kategori_kode' => 'required|string|max:10|unique:tbl_kategori,kategori_kode,'.$data['id'],
            'kategori_nama' => 'required|string',
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

        $store = Kategori::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
            'kategori_slug' => str_slug($request->kategori_nama, '-')
        ]);
        $message = [
            "status" => "success",
            "message" => "Successfully add ".$request->kategori_nama." added!",
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
        $this->validatorUpdate($request->all())->validate();

        $kategori = Kategori::findOrFail($id);
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->kategori_slug = str_slug($request->kategori_nama, '-');

        $message = [
            'status' => 'success',
            'message' => $kategori->kategori_nama.' successfully updated!',
            'response' => $kategori->save(),
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
        //Delete data from Database
        $data = Kategori::findOrFail($id);
        $message = [
            'status' => 'success',
            'message' => $data->kategori_nama." successfully deleted!",
            'response' => $data->delete()
        ];
        return response()->json($message);
    }
}
