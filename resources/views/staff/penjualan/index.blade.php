@extends('layouts.staff')

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Penjualan</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item active">Penjualan</li>
    </ol>
@endsection{{-- Content Header --}}

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">{{-- DataTable --}}
@endsection

@section('staff_content')
<div class="card">
    <div class="card-header no-border">
        <h3 class="card-title"><i class="fa fa-money"></i> <span id="span_title">List Penjualan</span></h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="penjualanTable">
            <thead>
                <tr>
                    <th class="all">No</th>
                    <th class="all">Invoice</th>
                    <th class="desktop">Barang</th>
                    <th class="desktop">Nilai Transaksi</th>
                    <th class="desktop">Dibayar</th>
                    <th class="desktop">Dibuat Tanggal</th>
                    <th class="desktop">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/dataTables/datatables.js') }}"></script>{{-- DataTable --}}
    <script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/datatables.responsive.js') }}"></script>{{-- DataTable Responsive --}}
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | List Penjualan";
        $("#mn-penjualan").closest('li').addClass('menu-open');
        $("#mn-penjualan").addClass('active');
        $("#sub-penjualan_list").addClass('active');
    });

    var tpenjualan = $("#penjualanTable").DataTable({
        responsive: true,
        processing: true,
        autoWidth: true,
        ajax: {
            method: "GET",
            url: "{{ url('list/penjualan') }}",
        },
        columns: [
            { data: null },
            { data: 'penjualan_invoice' },
            { data: null },
            { data: null },
            { data: null },
            { data: 'created_at' },
            { data: null },
        ],
        columnDefs: [
            {
                targets: [0],
                searchable: false,
                orderable: false,
            }, {
                targets: [2],
                render: function(data, type, row) {
                    return data.items['barang'];
                }
            }, {
                targets: [3],
                render: function(data, type, row) {
                    var angka = parseInt(data.items['total']);
                    return idr_curr(angka);
                }
            }, {
                targets: [4],
                render: function(data, type, row) {
                    var angka = parseInt(data.items['bayar']);
                    return idr_curr(angka);
                }
            }, {
                targets: [6],
                render: function(data, type, row) {
                    var id = "'"+data.id+"'";
                    var invoice_url = data.invoice_url;
                    return generateButton(id, invoice_url);
                }
            }
        ],
        pageLength: 10,
        aLengthMenu:[5,10,15,25,50],
        order: [5, 'desc'],
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        }
    });
    tpenjualan.on( 'order.dt search.dt', function () {
        tpenjualan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
    function generateButton(id, invoice_url){
        var edit = '<a href="{{ url("staff/penjualan") }}/'+invoice_url+'/edit" class="btn btn-warning text-white"><i class="fa fa-edit"></i></a>';
        var show = '<a href="{{ url("staff/penjualan/invoice") }}/'+invoice_url+'" class="btn btn-primary text-white"><i class="fa fa-eye"></i></a>';
        var hapus = '<a class="btn btn-danger text-white" onclick="formDelete('+id+')"><i class="fa fa-trash"></i></a>';

        return "<div class='btn-group'>"+edit+show+hapus+"</div>";
    }

    //Action
    function formDelete(id){
        var penjualan_id = id;
        var url_link = '{{ url('staff/penjualan') }}/'+penjualan_id;

        swal({
            title: "Warning!",
            text: "This data will be deleted. All data related to this transaction will be deleted, this action cannot be undo! Please type 'delete' to start process!",
            icon: "warning",
            buttons: true,
            content: "input",
            dangerMode: true,
        }).then((value) => {
            if (value == "delete") {
                $.ajax({
                    method: 'POST',
                    url: url_link,
                    data: {'_method': 'delete'},
                    cache: false,
                    success: function(result){
                        console.log(result);
                        //Re-Draw dataTable
                        $("#penjualanTable").DataTable().ajax.reload(null, false);
                        //Show alert
                        topright_notify(result.message);
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log(jqXHR);
                    }
                });
            } else {
                swal({
                    icon: "error",
                    title: "Failed!",
                    text: "Invalid, please try again. Please type 'delete' to start the process.",
                });
            }
        });
    }
</script>
@endsection
