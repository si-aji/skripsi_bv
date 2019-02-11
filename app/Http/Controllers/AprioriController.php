<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;

use App\Apriori;

use App\Penjualan;
use App\PenjualanItem;

class AprioriController extends Controller
{
    /**
     *
     */
    public function __construct(BarangController $barangController)
    {
        $this->barangController = $barangController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apriori = Apriori::first();
        return view('staff.analisa.apriori.apriori', compact('apriori'));
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
            'min_support' => 'required|numeric',
            'min_confidence' => 'required|numeric',
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
        $apriori = Apriori::create([
            'id' => 1,
            'min_support' => $request->min_support,
            'min_confidence' => $request->min_confidence
        ]);

        $message = [
            'status' => 'success',
            'message' => 'Apriori settings successfully stored!',
            'old_support' => $request->min_support,
            'old_confidence' => $request->min_confidence,
            'response' => $apriori,
        ];
        return response()->json($message);
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
        $this->validator($request->all())->validate();

        try{
            $apriori = Apriori::findOrFail($id);

            $apriori->min_support = $request->min_support;
            $apriori->min_confidence = $request->min_confidence;

            $message = [
                'status' => 'success',
                'message' => 'Apriori settings successfully updated!',
                'old_support' => $request->min_support,
                'old_confidence' => $request->min_confidence,
                'response' => $apriori->save(),
            ];
            return response()->json($message);
        } catch(ModelNotFoundException $e){
            return $this->store($request);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->validator($request->all())->validate();

        $apriori = Apriori::findOrFail($id);
        $apriori->min_support = 50;
        $apriori->min_confidence = 70;

        $message = [
            'status' => 'success',
            'message' => 'Apriori settings successfully reset to default!',
            'old_support' => $request->min_support,
            'old_confidence' => $request->min_confidence,
            'response' => $apriori->save(),
        ];
        return response()->json($message);
    }

    /**
     * Fungsi untuk mendapatkan transaksi yang sesuai filter (tanggal)
     *
     * parameter (tgl_mulai, tgl_akhir)
     * result object
     */
    public function getBarang($tgl_mulai, $tgl_akhir)
    {
        return DB::select("
            SELECT
                COUNT(pi.barang_id) as jumlah,
                pi.barang_id,
                b.barang_nama,
                (
                    SELECT COUNT(*)
                        FROM
                            tbl_penjualan p
                        WHERE
                            penjualan_tgl BETWEEN '".$tgl_mulai."' AND '".$tgl_akhir."'
                ) as total
                FROM
                    tbl_penjualan_item pi
                        JOIN tbl_penjualan p
                        ON p.id = pi.penjualan_id
                        JOIN tbl_barang b
                        ON b.id = pi.barang_id
                WHERE
                    p.penjualan_tgl
                        BETWEEN '".$tgl_mulai."' AND '".$tgl_akhir."'
                GROUP BY pi.barang_id, b.barang_nama
        ");
    }

    /**
     * Fungsi untuk mendapatkan item apa saja yang ada pada tiap transaksi
     *
     * parameter (tgl_mulai, tgl_akhir)
     * result object
     */
    public function getTransactionItem($tgl_mulai, $tgl_akhir)
    {
        return DB::select("
            SELECT
                GROUP_CONCAT(b.barang_nama) as barang
            FROM
                tbl_penjualan_item pi
                    JOIN tbl_penjualan p
                    ON p.id = pi.penjualan_id
                    JOIN tbl_barang b
                    ON b.id = pi.barang_id
            WHERE
                p.penjualan_tgl
                    BETWEEN '".$tgl_mulai."' AND '".$tgl_akhir."'
            GROUP BY
                p.id
        ");
    }

    /**
     * Fungsi untuk mendapatkan barang yang memenuhi minimal support
     *
     * parameter (data_barang, min_support)
     * result array
     *
     * data_barang adalah object
     */
    public function getBarangWithSupport($obj_barang, $min_support)
    {
        $barang = array();

        foreach($obj_barang as $item){
            if(($item->jumlah * 100 / $item->total) >= $min_support){
                $barang_new = $item->barang_nama;
                array_push($barang, array($item->barang_nama, $item->jumlah));
            }
        }

        return $barang;
    }

    /**
     * Fungsi untuk convert Object Item Belian menjadi Array
     *
     * parameter (data_belian)
     * result array
     */
    public function getItemBelian($data_belian)
    {
        $belian = array();

        foreach($data_belian as $item){
            $belian_new = $item->barang;
            array_push($belian, $belian_new);
        }

        return $belian;
    }

    /**
     *
     */
    public function createTwoItemSet($barang, $belian)
    {
        $itemSet = array();
        $total_transaksi = 0;

        /**
         * Get Total Transaksi
         */
        foreach($belian as $b){
            $total_transaksi++;
        }

        $item1 = count($barang) - 1;
        $item2 = count($barang);

        if($item2 >= 2){
            // Membuat Kombinasi 2 Item
            for($i = 0; $i < $item1; $i++) {
                for($j = $i+1; $j < $item2; $j++) {
                    $item_pair = $barang[$i][0].' - '.$barang[$j][0];
                    $item_array[$item_pair] = 0;
                    foreach($belian as $item_belian) {
                        if((strpos($item_belian, $barang[$i][0]) !== false) && (strpos($item_belian, $barang[$j][0]) !== false)) {
                            $item_array[$item_pair]++;
                        }
                    }
                    $support = ($item_array[$item_pair] * 100) / $total_transaksi;
                    $itemSet[] = array(
                        "id_barang"=>array(
                            "id_satu"=>$this->barangController->getIdByName($barang[$i]),
                            "id_dua"=>$this->barangController->getIdByName($barang[$j]),
                        ),
                        "item"=>$item_pair,
                        "jumlah"=>$item_array[$item_pair],
                        "total"=>$total_transaksi,
                        "support"=>$support
                    );
                }
            }
        } else {
            $itemSet = 0;
        }

        return $itemSet;
    }

    /**
     *
     */
    public function createThreeItemSet($barang, $belian, $min_support)
    {
        $temp_result = array();
        $temp_barang = array();
        $total_transaksi = 0;

        /**
         * Cek Kombinasi untuk 2 Item Set yang memenuhi nilai support
         */
        $kdua = $this->createTwoItemSet($barang, $belian);
        if($kdua != 0){
            foreach($kdua as $kd){
                if($kd['support'] >= $min_support){
                    $temp_result[] = $kd['item'];
                }
            }
            $string = implode(' - ', $temp_result);
            $explode = array_unique(explode(' - ', $string));
            foreach($explode as $ex){
                $temp_barang[] = $ex;
            }

            /**
             * Get Total Transaksi
             */
            foreach($belian as $b){
                $total_transaksi++;
            }

            $item1 = count($temp_barang) - 2;
            $item2 = count($temp_barang) - 1;
            $item3 = count($temp_barang);
            if($item3 >= 3){
                // Membuat Kombinasi 3 Item
                for($i = 0; $i < $item1; $i++) {
                    for($j = $i+1; $j < $item2; $j++) {
                        for($k = $j+1; $k < $item3; $k++) {
                            $item_pair = $temp_barang[$i].' - '.$temp_barang[$j].' - '.$temp_barang[$k];
                            $item_array[$item_pair] = 0;
                            foreach($belian as $item_belian) {
                                if((strpos($item_belian, $temp_barang[$i]) !== false) && (strpos($item_belian, $temp_barang[$j]) !== false) && (strpos($item_belian, $temp_barang[$k]) !== false)) {
                                    $item_array[$item_pair]++;
                                }
                            }
                            $support = ($item_array[$item_pair]*100)/$total_transaksi;
                            $result[] = array(
                                "id_barang"=>array(
                                    "id_satu"=>$this->barangController->getIdByName($temp_barang[$i]),
                                    "id_dua"=>$this->barangController->getIdByName($temp_barang[$j]),
                                    "id_tiga"=>$this->barangController->getIdByName($temp_barang[$k]),
                                ),
                                "item"=>$item_pair,
                                "jumlah"=>$item_array[$item_pair],
                                "total"=>$total_transaksi,
                                "support"=>$support
                            );
                        }
                    }
                }
            } else {
                $result = 0;
            }
        } else {
            $result = 0;
        }

        return $result;
    }

    /**
     * Hitung Nilai Conf
     */
    public function getTwoConf(Request $request)
    {
        $temp = array();
        $tp = 0; $tn = 0; $fp = 0; $fn = 0;

        $data_barang = $this->getBarang($request->tanggal_mulai, $request->tanggal_akhir);
        // $data_barang = $this->getBarang('2018-12-01 00:00:00', '2018-12-09 23:59:59'); // Data Demo
        $data_belian = $this->getTransactionItem($request->tanggal_mulai, $request->tanggal_akhir);
        // $data_belian = $this->getTransactionItem('2018-12-01 00:00:00', '2018-12-09 23:59:59'); // Data Demo
        $barang = $this->getBarangWithSupport($data_barang, $request->min_support);
        // $barang = $this->getBarangWithSupport($data_barang, '50'); // Data Demo
        $belian = $this->getItemBelian($data_belian);

        $total_transaksi = 0;

        /**
         * Get Total Transaksi
         */
        foreach($belian as $b){
            $total_transaksi++;
        }

        $twoitemset = $this->createTwoItemSet($barang, $belian);
        if($twoitemset != 0){
            foreach($twoitemset as $k => $item){
                $arr[] = explode(' - ', $item['item']);

                //Get Support
                foreach($data_barang as $barang){
                    if($barang->barang_nama == $arr[$k][0]){
                        $support_x = ($barang->jumlah / $barang->total) * 100;
                    }
                }
                $support_xuy = $item['support'];
                if($support_x == 0){ //Handle Division by Zero Exception
                    $nilai_conf = 0;
                } else {
                    $nilai_conf = round(($support_xuy / $support_x) * 100, 2);
                }
                //Confusion Matrix
                if(($support_xuy >= $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $tp++;
                } else if(($support_xuy >= $request->min_support) && ($nilai_conf < $request->min_conf)){
                    $fn++;
                } else if(($support_xuy < $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $fp++;
                } else {
                    $tn++;
                }
                $one = array(
                    "item" => $arr[$k][0]." => ".$arr[$k][1],
                    "support_x" => $support_x,
                    "support_xuy" => $support_xuy,
                    "conf" => $nilai_conf,
                );
                array_push($temp, $one);
                $one = array();

                //Get Support
                foreach($data_barang as $barang){
                    if($barang->barang_nama == $arr[$k][1]){
                        $support_x = ($barang->jumlah / $barang->total) * 100;
                    }
                }
                $support_xuy = $item['support'];
                if($support_x == 0){ //Handle Division by Zero Exception
                    $nilai_conf = 0;
                } else {
                    $nilai_conf = round(($support_xuy / $support_x) * 100, 2);
                }
                //Confusion Matrix
                if(($support_xuy >= $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $tp++;
                } else if(($support_xuy >= $request->min_support) && ($nilai_conf < $request->min_conf)){
                    $fn++;
                } else if(($support_xuy < $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $fp++;
                } else {
                    $tn++;
                }
                $two = array(
                    "item" => $arr[$k][1]." => ".$arr[$k][0],
                    "support_x" => $support_x,
                    "support_xuy" => $support_xuy,
                    "conf" => $nilai_conf,
                );
                array_push($temp, $two);
                $two = array();
            }
        } else {
            $temp = [];
        }

        // return $temp;
        return datatables()
            ->of($temp)
            ->with([
                'TP' => $tp,
                'TN' => $tn,
                'FP' => $fp,
                'FN' => $fn,
            ])
            ->toJson();
    }
    public function getThreeConf(Request $request)
    {
        $temp = array();
        $temp_one = array();
        $temp_two = array();
        $tp = 0; $tn = 0; $fp = 0; $fn = 0;

        $data_barang = $this->getBarang($request->tanggal_mulai, $request->tanggal_akhir);
        // $data_barang = $this->getBarang('2019-01-01 00:00:00', '2019-01-17 23:59:59'); // Data Demo
        $data_belian = $this->getTransactionItem($request->tanggal_mulai, $request->tanggal_akhir);
        // $data_belian = $this->getTransactionItem('2018-12-01 00:00:00', '2019-01-17 23:59:59'); // Data Demo
        $barang = $this->getBarangWithSupport($data_barang, $request->min_support);
        // $barang = $this->getBarangWithSupport($data_barang, '30'); // Data Demo
        $belian = $this->getItemBelian($data_belian);

        $total_transaksi = 0;

        /**
         * Get Total Transaksi
         */
        foreach($belian as $b){
            $total_transaksi++;
        }

        $twoitemset = $this->createTwoItemSet($barang, $belian);
        $threeitemset = $this->createThreeItemSet($barang, $belian, $request->min_support);
        // $threeitemset = $this->createThreeItemSet($barang, $belian, '30');
        if($threeitemset != 0){
            foreach($threeitemset as $k => $item){
                $arr[] = explode(' - ', $item['item']);

                //0,1 => 2
                foreach($twoitemset as $bar){
                    if($bar['item'] == $arr[$k][0]." - ".$arr[$k][1]){
                        $support_x = ($bar['jumlah'] / $bar['total']) * 100;
                    }
                }
                $support_xuy = $item['support'];
                if($support_x == 0){ //Handle Division by Zero Exception
                    $nilai_conf = 0;
                } else {
                    $nilai_conf = round(($support_xuy / $support_x) * 100, 2);
                }
                //Confusion Matrix
                if(($support_xuy >= $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $tp++;
                } else if(($support_xuy >= $request->min_support) && ($nilai_conf < $request->min_conf)){
                    $fn++;
                } else if(($support_xuy < $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $fp++;
                } else {
                    $tn++;
                }
                $array = array(
                    "item" => $arr[$k][0]." - ".$arr[$k][1]." => ".$arr[$k][2],
                    "support_x" => $support_x,
                    "support_xuy" => $support_xuy,
                    "conf" => $nilai_conf,
                );
                array_push($temp, $array);
                $array = array();

                //2 => 0,1
                foreach($data_barang as $barang){
                    if($barang->barang_nama == $arr[$k][2]){
                        $support_x = ($barang->jumlah / $barang->total) * 100;
                    }
                }
                $support_xuy = $item['support'];
                if($support_x == 0){ //Handle Division by Zero Exception
                    $nilai_conf = 0;
                } else {
                    $nilai_conf = round(($support_xuy / $support_x) * 100, 2);
                }
                //Confusion Matrix
                if(($support_xuy >= $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $tp++;
                } else if(($support_xuy >= $request->min_support) && ($nilai_conf < $request->min_conf)){
                    $fn++;
                } else if(($support_xuy < $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $fp++;
                } else {
                    $tn++;
                }
                $array = array(
                    "item" => $arr[$k][2]." => ".$arr[$k][0]." - ".$arr[$k][1],
                    "support_x" => $support_x,
                    "support_xuy" => $support_xuy,
                    "conf" => $nilai_conf,
                );
                array_push($temp, $array);
                $array = array();

                //0,2 => 1
                foreach($twoitemset as $bar){
                    if($bar['item'] == $arr[$k][0]." - ".$arr[$k][2]){
                        $support_x = ($bar['jumlah'] / $bar['total']) * 100;
                    }
                }
                $support_xuy = $item['support'];
                if($support_x == 0){ //Handle Division by Zero Exception
                    $nilai_conf = 0;
                } else {
                    $nilai_conf = round(($support_xuy / $support_x) * 100, 2);
                }
                //Confusion Matrix
                if(($support_xuy >= $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $tp++;
                } else if(($support_xuy >= $request->min_support) && ($nilai_conf < $request->min_conf)){
                    $fn++;
                } else if(($support_xuy < $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $fp++;
                } else {
                    $tn++;
                }
                $array = array(
                    "item" => $arr[$k][0]." - ".$arr[$k][2]." => ".$arr[$k][1],
                    "support_x" => $support_x,
                    "support_xuy" => $support_xuy,
                    "conf" => $nilai_conf,
                );
                array_push($temp, $array);
                $array = array();

                //1 => 0,2
                foreach($data_barang as $barang){
                    if($barang->barang_nama == $arr[$k][1]){
                        $support_x = ($barang->jumlah / $barang->total) * 100;
                    }
                }
                $support_xuy = $item['support'];
                if($support_x == 0){ //Handle Division by Zero Exception
                    $nilai_conf = 0;
                } else {
                    $nilai_conf = round(($support_xuy / $support_x) * 100, 2);
                }
                //Confusion Matrix
                if(($support_xuy >= $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $tp++;
                } else if(($support_xuy >= $request->min_support) && ($nilai_conf < $request->min_conf)){
                    $fn++;
                } else if(($support_xuy < $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $fp++;
                } else {
                    $tn++;
                }
                $array = array(
                    "item" => $arr[$k][1]." => ".$arr[$k][0]." - ".$arr[$k][2],
                    "support_x" => $support_x,
                    "support_xuy" => $support_xuy,
                    "conf" => $nilai_conf,
                );
                array_push($temp, $array);
                $array = array();

                //1,2 => 0
                foreach($twoitemset as $bar){
                    if($bar['item'] == $arr[$k][1]." - ".$arr[$k][2]){
                        $support_x = ($bar['jumlah'] / $bar['total']) * 100;
                    }
                }
                $support_xuy = $item['support'];
                if($support_x == 0){ //Handle Division by Zero Exception
                    $nilai_conf = 0;
                } else {
                    $nilai_conf = round(($support_xuy / $support_x) * 100, 2);
                }
                //Confusion Matrix
                if(($support_xuy >= $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $tp++;
                } else if(($support_xuy >= $request->min_support) && ($nilai_conf < $request->min_conf)){
                    $fn++;
                } else if(($support_xuy < $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $fp++;
                } else {
                    $tn++;
                }
                $array = array(
                    "item" => $arr[$k][1]." - ".$arr[$k][2]." => ".$arr[$k][0],
                    "support_x" => $support_x,
                    "support_xuy" => $support_xuy,
                    "conf" => $nilai_conf,
                );
                array_push($temp, $array);
                $array = array();

                //0 => 1,2
                foreach($data_barang as $barang){
                    if($barang->barang_nama == $arr[$k][0]){
                        $support_x = ($barang->jumlah / $barang->total) * 100;
                    }
                }
                $support_xuy = $item['support'];
                if($support_x == 0){ //Handle Division by Zero Exception
                    $nilai_conf = 0;
                } else {
                    $nilai_conf = round(($support_xuy / $support_x) * 100, 2);
                }
                //Confusion Matrix
                if(($support_xuy >= $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $tp++;
                } else if(($support_xuy >= $request->min_support) && ($nilai_conf < $request->min_conf)){
                    $fn++;
                } else if(($support_xuy < $request->min_support) && ($nilai_conf >= $request->min_conf)){
                    $fp++;
                } else {
                    $tn++;
                }
                $array = array(
                    "item" => $arr[$k][0]." => ".$arr[$k][1]." - ".$arr[$k][2],
                    "support_x" => $support_x,
                    "support_xuy" => $support_xuy,
                    "conf" => $nilai_conf,
                );
                array_push($temp, $array);
                $array = array();
            }
        } else {
            $temp = [];
        }

        return datatables()
            ->of($temp)
            ->with([
                'TP' => $tp,
                'TN' => $tn,
                'FP' => $fp,
                'FN' => $fn,
            ])
            ->tojson();
        // return datatables()->of($arr)->tojson();
    }


    /**
     * Mulai Apriori (Max 3 Itemset)
     */
    public function cSatu(Request $request)
    {
        // Data Transaksi
        $data_barang = $this->getBarang($request->tanggal_mulai, $request->tanggal_akhir);
        // $data_transaksi = $this->getBarang('2018-12-01 00:00:00', '2018-12-09 23:59:59'); // Data Demo

        return datatables()->of($data_barang)->toJson();
    }

    public function cDua(Request $request)
    {
        $result = array();

        $data_barang = $this->getBarang($request->tanggal_mulai, $request->tanggal_akhir);
        // $data_barang = $this->getBarang('2018-12-01 00:00:00', '2018-12-09 23:59:59'); // Data Demo
        $data_belian = $this->getTransactionItem($request->tanggal_mulai, $request->tanggal_akhir);
        // $data_belian = $this->getTransactionItem('2018-12-01 00:00:00', '2018-12-09 23:59:59'); // Data Demo

        /**
         * Data Barang (yang memenuhi nilai min support)
         */
        $barang = $this->getBarangWithSupport($data_barang, $request->min_support);
        // $barang = $this->getBarangWithSupport($data_barang, '50'); // Data Demo

        /**
         * Data Belian
         *
         * Convert object to array
         */
        $belian = $this->getItemBelian($data_belian);

        /**
         * Buat Kombinasi untuk 2 Item Set
         */
        $result = $this->createTwoItemSet($barang, $belian);
        if($result == 0){
            $result = [];
        }

        // return response()->json($result);
        return datatables()->of($result)->toJson();
    }

    public function cTiga(Request $request)
    {
        $result = array();

        $data_barang = $this->getBarang($request->tanggal_mulai, $request->tanggal_akhir);
        // $data_barang = $this->getBarang('2018-12-01 00:00:00', '2018-12-09 23:59:59'); // Data Demo
        $data_belian = $this->getTransactionItem($request->tanggal_mulai, $request->tanggal_akhir);
        // $data_belian = $this->getTransactionItem('2018-12-01 00:00:00', '2018-12-09 23:59:59'); // Data Demo

        /**
         * Data Barang (yang memenuhi nilai min support)
         */
        $barang = $this->getBarangWithSupport($data_barang, $request->min_support);
        // $barang = $this->getBarangWithSupport($data_barang, '50'); // Data Demo

        /**
         * Data Belian
         *
         * Convert object to array
         */
        $belian = $this->getItemBelian($data_belian);

        /**
         * Buat Kombinasi untuk 2 Item Set
         */
        $result = $this->createThreeItemSet($barang, $belian, $request->min_support);
        // $result = $this->createThreeItemSet($barang, $belian, '50'); // Data Demo
        if($result == 0){
            $result = [];
        }

        // return response()->json($result);
        return datatables()->of($result)->toJson();
    }
}
