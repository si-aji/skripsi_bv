<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Apriori;

use App\Penjualan;
use App\PenjualanItem;

class AprioriController extends Controller
{
    public function cSatu(Request $request){
        // [$request->tanggal_awal, $request->tanggal_akhir]
        // ['2018-08-01', '2018-08-31']

        // $data = DB::table('tbl_penjualan_item')
        //         ->select('tbl_penjualan_item.barang_id', DB::raw('count(tbl_penjualan_item.barang_id) as jumlah'), 'tbl_barang.barang_nama')
        //         ->join('tbl_penjualan', 'tbl_penjualan.id', '=', 'tbl_penjualan_item.penjualan_id')
        //         ->join('tbl_barang', 'tbl_barang.id', '=', 'tbl_penjualan_item.barang_id')
        //         ->whereBetween('tbl_penjualan.penjualan_tgl', [$request->tanggal_mulai, $request->tanggal_akhir])
        //         ->groupBy('barang_id')
        //         ->get();

        $data = DB::select("
            SELECT
                COUNT(pi.barang_id) as jumlah,
                pi.barang_id,
                b.barang_nama,
                (
                    SELECT COUNT(*)
                        FROM
                            tbl_penjualan p
                        WHERE
                            penjualan_tgl BETWEEN '".$request->tanggal_mulai."' AND '".$request->tanggal_akhir."'
                ) as total
                FROM
                    tbl_penjualan_item pi
                        JOIN tbl_penjualan p
                        ON p.id = pi.penjualan_id
                        JOIN tbl_barang b
                        ON b.id = pi.barang_id
                WHERE
                    p.penjualan_tgl BETWEEN '".$request->tanggal_mulai."' AND '".$request->tanggal_akhir."'
                GROUP BY pi.barang_id
        ");

        // return response()->json($data);
        return datatables()->of($data)->toJson();
    }

    public function cDua(Request $request){
        // $result = array();

        $barang = array();
        $belian = array();

        $total_transaksi = 0;

        // $data = DB::select("
        //     SELECT
        //         COUNT(pi.barang_id) as jumlah,
        //         pi.barang_id,
        //         b.barang_nama,
        //         (
        //             SELECT COUNT(*)
        //                 FROM
        //                     tbl_penjualan p
        //                 WHERE
        //                     penjualan_tgl BETWEEN '2018-08-01' AND '2018-08-31'
        //         ) as total
        //         FROM
        //             tbl_penjualan_item pi
        //                 JOIN tbl_penjualan p
        //                 ON p.id = pi.penjualan_id
        //                 JOIN tbl_barang b
        //                 ON b.id = pi.barang_id
        //         WHERE
        //             p.penjualan_tgl BETWEEN '2018-08-01' AND '2018-08-31'
        //         GROUP BY pi.barang_id
        // ");
        $data = DB::select("
            SELECT
                COUNT(pi.barang_id) as jumlah,
                pi.barang_id,
                b.barang_nama,
                (
                    SELECT COUNT(*)
                        FROM
                            tbl_penjualan p
                        WHERE
                            penjualan_tgl BETWEEN '".$request->tanggal_mulai."' AND '".$request->tanggal_akhir."'
                ) as total
                FROM
                    tbl_penjualan_item pi
                        JOIN tbl_penjualan p
                        ON p.id = pi.penjualan_id
                        JOIN tbl_barang b
                        ON b.id = pi.barang_id
                WHERE
                    p.penjualan_tgl BETWEEN '".$request->tanggal_mulai."' AND '".$request->tanggal_akhir."'
                GROUP BY pi.barang_id
        ");

        // $data_belian = DB::select("
        //     SELECT
        //         GROUP_CONCAT(b.barang_nama) as barang
        //     FROM
        //         tbl_penjualan_item pi
        //             JOIN tbl_penjualan p
        //             ON p.id = pi.penjualan_id
        //             JOIN tbl_barang b
        //             ON b.id = pi.barang_id
        //     WHERE
        //         p.penjualan_tgl
        //             BETWEEN '2018-08-01' AND '2018-08-31'
        //     GROUP BY
        //         p.id
        // ");
        $data_belian = DB::select("
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
                    BETWEEN '".$request->tanggal_mulai."' AND '".$request->tanggal_akhir."'
            GROUP BY
                p.id
        ");

        //Array Barang
        foreach($data as $item){
            $total_transaksi = $item->total;
            // if(($item->jumlah * 100 / $item->total) > 7){
            if(($item->jumlah * 100 / $item->total) > $request->min_support){
                // $combine[] = $Apriori->combinations(($item));
                $barang_new = $item->barang_nama;
                array_push($barang, $barang_new);
            }
        }
        //Array Belian
        foreach($data_belian as $item){
            $belian_new = $item->barang;
            array_push($belian, $belian_new);
        }

        $item1 = count($barang) - 1;
        $item2 = count($barang);

        //Hitung Jumlah Item
        foreach ($barang as $value) {
            $total_per_item[$value] = 0;
            foreach($belian as $item_belian) {
                $data_item = (string)$value;
                if(strpos($item_belian, $data_item) !== false) {
                    $total_per_item[$value]++;
                }
            }
        }

        // Membuat Kombinasi 2 Item
        for($i = 0; $i < $item1; $i++) {
            for($j = $i+1; $j < $item2; $j++) {
                $item_pair = ucwords($barang[$i]).' - '.ucwords($barang[$j]);
                $item_array[$item_pair] = 0;
                foreach($belian as $item_belian) {
                    if((strpos($item_belian, $barang[$i]) !== false) && (strpos($item_belian, $barang[$j]) !== false)) {
                        $item_array[$item_pair]++;
                    }
                }
                $result[] = array("item"=>$item_pair, "jumlah"=>$item_array[$item_pair], "total"=>$total_transaksi);
            }
        }

        // return response()->json($result);
        return datatables()->of($result)->toJson();
    }

    public function cTiga(Request $request){
        $barang = array();
        $belian = array();
        $total_transaksi = 0;

        //Data Barang
        $dataBarang = DB::select("
            SELECT
                COUNT(pi.barang_id) as jumlah,
                pi.barang_id,
                b.barang_nama,
                (
                    SELECT COUNT(*)
                        FROM
                            tbl_penjualan p
                        WHERE
                            penjualan_tgl BETWEEN '".$request->tanggal_mulai."' AND '".$request->tanggal_akhir."'
                ) as total
                FROM
                    tbl_penjualan_item pi
                        JOIN tbl_penjualan p
                        ON p.id = pi.penjualan_id
                        JOIN tbl_barang b
                        ON b.id = pi.barang_id
                WHERE
                    p.penjualan_tgl BETWEEN '".$request->tanggal_mulai."' AND '".$request->tanggal_akhir."'
                GROUP BY pi.barang_id
        ");
        foreach($dataBarang as $item){
            $total_transaksi = $item->total;
            if(($item->jumlah * 100 / $item->total) > $request->min_support){
                // $combine[] = $Apriori->combinations(($item));
                $barang_new = $item->barang_nama;
                array_push($barang, $barang_new);
            }
        }

        //Data Transaksi
        $dataTransaksi = DB::select("
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
                    BETWEEN '".$request->tanggal_mulai."' AND '".$request->tanggal_akhir."'
            GROUP BY
                p.id
        ");
        foreach($dataTransaksi as $item){
            $belian_new = $item->barang;
            array_push($belian, $belian_new);
        }

        $item1 = count($barang) - 2;
        $item2 = count($barang) - 1;
        $item3 = count($barang);
        // Membuat Kombinasi 3 Item
        for($i = 0; $i < $item1; $i++) {
            for($j = $i+1; $j < $item2; $j++) {
                for($k = $j+1; $k < $item3; $k++) {
                    $item_pair = ucwords($barang[$i]).' - '.ucwords($barang[$j]).' - '.ucwords($barang[$k]);
                    $item_array[$item_pair] = 0;
                    foreach($belian as $item_belian) {
                        if((strpos($item_belian, $barang[$i]) !== false) && (strpos($item_belian, $barang[$j]) !== false) && (strpos($item_belian, $barang[$k]) !== false)) {
                            $item_array[$item_pair]++;
                        }
                    }
                    $result[] = array("item"=>$item_pair, "jumlah"=>$item_array[$item_pair], "total"=>$total_transaksi);
                }
            }
        }

        // return $result;
        return datatables()->of($result)->toJson();
    }
}
