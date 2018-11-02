<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Data for Json Format (all)
     */
    public function supplierJson(){
        $list = Supplier::where('supplier_status', 'Aktif');
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
        return view('staff.supplier.index');
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
            'supplier_nama' => 'required|string',
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
        $store = Supplier::create([
            'supplier_nama' => $request->supplier_nama,
            'supplier_kontak' => $request->supplier_kontak,
            'supplier_detail' => $request->supplier_detail,
        ]);
        $message = [
            "status" => "success",
            "message" => "Successfully add ".$request->supplier_nama." to database!",
            "response" => $store,
        ];
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validator($request->all())->validate();

        $supplier = Supplier::findOrFail($id);
        $supplier->supplier_nama = $request->supplier_nama;
        $supplier->supplier_kontak = $request->supplier_kontak;
        $supplier->supplier_detail = $request->supplier_detail;

        $message = [
            'status' => 'success',
            'message' => $supplier->supplier_nama.' successfully updated!',
            'response' => $supplier->save(),
        ];
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->supplier_status = "Tidak Aktif";

        $message = [
            'status' => 'success',
            'message' => $supplier->supplier_nama.' successfully deleted!',
            'response' => $supplier->save(),
        ];
        return response()->json($message);
    }
}
