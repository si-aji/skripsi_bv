<?php

namespace App\Http\Controllers;

use App\Kostumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KostumerController extends Controller
{
    /**
     * Data for Json Format (all)
     */
    public function kostumerJson(){
        $list = Kostumer::all()->sortBy('kostumer_nama');
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
        return view('staff.kostumer.index');
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
            'kostumer_nama' => 'required|string',
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
        $store = Kostumer::create([
            'kostumer_nama' => $request->kostumer_nama,
            'kostumer_kontak' => $request->kostumer_kontak,
            'kostumer_detail' => $request->kostumer_detail,
        ]);
        $message = [
            "status" => "success",
            "message" => "Successfully add ".$request->kostumer_nama." to database!",
            "response" => $store,
        ];
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kostumer  $kostumer
     * @return \Illuminate\Http\Response
     */
    public function show(Kostumer $kostumer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kostumer  $kostumer
     * @return \Illuminate\Http\Response
     */
    public function edit(Kostumer $kostumer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kostumer  $kostumer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validator($request->all())->validate();

        $kostumer = Kostumer::findOrFail($id);
        $kostumer->kostumer_nama = $request->kostumer_nama;
        $kostumer->kostumer_kontak = $request->kostumer_kontak;
        $kostumer->kostumer_detail = $request->kostumer_detail;

        $message = [
            'status' => 'success',
            'message' => $kostumer->kostumer_nama.' successfully updated!',
            'response' => $kostumer->save(),
        ];
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kostumer  $kostumer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kostumer $kostumer)
    {
        //
    }
}
