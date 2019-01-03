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
    <link href="{{ asset('plugins/iCheck/all.css') }}" rel="stylesheet">{{-- iCheck --}}
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">{{-- DataTable --}}
    <link href="{{ asset('plugins/datetimePicker/css/tempusdominus-bootstrap-4.css') }}" rel="stylesheet">{{-- dateTimePicker --}}
@endsection

@section('staff_content')
<div class="card">
    <div class="card-header no-border">
        <h3 class="card-title"><i class="fa fa-money"></i> <span id="span_title">List Penjualan</span></h3>
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="row">
                            <div class="col-12 col-lg-4">{{-- Filter Tanggal Mulai --}}
                                <div class="form-group" class="mb-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <label for="filter_tanggal" class="mb-0">
                                                    <input type="hidden" id="input-filter_tanggal" name="input-filter_tanggal" value="Y" readonly>
                                                    <input type="checkbox" class="minimal" name="filter_tanggal" id="filter_tanggal" value="Y"> Start Date
                                                </label>
                                            </span>
                                        </div>
                                        <input type="text" name="tanggal_mulai" class="form-control datetimepicker-input" id="input-tanggal_mulai" data-toggle="datetimepicker" data-target="#input-tanggal_mulai">
                                    </div>
                                </div>
                            </div>{{-- /.Filter Tanggal Mulai --}}
                            <div class="col-12 col-lg-4">{{-- Filter Tanggal Akhir --}}
                                <div class="form-group" class="mb-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <label class="mb-0">End Date</label>
                                            </span>
                                        </div>
                                        <input type="text" name="tanggal_akhir" class="form-control datetimepicker-input" id="input-tanggal_akhir" data-toggle="datetimepicker" data-target="#input-tanggal_akhir">
                                    </div>
                                </div>
                            </div>{{-- /.Filter Tanggal Akhir --}}
                            <div class="col-12 col-lg-4">{{-- Filter Pembayaran Belum Lunas --}}
                                <div class="form-group" class="mb-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <input type="checkbox" class="minimal" name="filter_pembayaran" id="filter_pembayaran" value="Y">
                                            </span>
                                        </div>
                                        <input type="text" name="input-filter_pembayaran" class="form-control" id="input-filter_pembayaran" value="Belum Lunas" readonly>
                                    </div>
                                </div>
                            </div>{{-- /.Filter Pembayaran Belum Lunas --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <table class="table table-bordered table-hover table-striped" id="penjualanTable">
            <thead>
                <tr>
                    <th class="all">No</th>
                    <th class="all">Invoice</th>
                    <th class="desktop">Barang</th>
                    <th class="desktop">Nilai Transaksi</th>
                    <th class="desktop">Dibayar</th>
                    <th class="desktop">Tanggal Penjualan</th>
                    <th class="desktop">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/iCheck/icheck.js') }}"></script>{{-- iCheck --}}

    <script src="{{ asset('plugins/dataTables/datatables.js') }}"></script>{{-- DataTable --}}
    <script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/dataTables.responsive.js') }}"></script>{{-- DataTable Responsive --}}

    <script src="{{ asset('plugins/datetimePicker/js/tempusdominus-bootstrap-4.js') }}"></script>{{-- dateTimePicker --}}
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | List Penjualan";
        $("#mn-penjualan").closest('li').addClass('menu-open');
        $("#mn-penjualan").addClass('active');
        $("#sub-penjualan_list").addClass('active');

        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass   : 'iradio_flat-blue'
        });

        $("#filter_tanggal").prop('checked', true);
        $("#filter_tanggal").iCheck('update');
    });

    //Timepicker
    $('#input-tanggal_mulai').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm',
        defaultDate: moment('{{ date("Y-m-1 00:00:00") }}', 'YYYY-MM-DD HH:mm'),
        maxDate : moment('{{ date("Y-m-d H:i:s") }}', 'YYYY-MM-DD HH:mm')
    });
    $('#input-tanggal_akhir').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm',
        defaultDate: moment('{{ date("Y-m-d H:i:s") }}', 'YYYY-MM-DD HH:mm'),
        minDate : moment('{{ date("Y-m-1 00:00:00") }}', 'YYYY-MM-DD HH:mm'),
        maxDate : moment('{{ date("Y-m-d H:i:s") }}', 'YYYY-MM-DD HH:mm')
    });

    var tpenjualan = $("#penjualanTable").DataTable({
        responsive: true,
        processing: true,
        autoWidth: true,
        ajax: {
            method: "POST",
            data: function(d){
                d.filter_tanggal = document.getElementById("input-filter_tanggal").value,
                d.tanggal_mulai = document.getElementById("input-tanggal_mulai").value,
                d.tanggal_akhir = document.getElementById("input-tanggal_akhir").value
            },
            url: "{{ url('list/penjualan') }}",
        },
        columns: [
            { data: null },
            { data: 'penjualan_invoice' },
            { data: null },
            { data: null },
            { data: null },
            { data: 'penjualan_tgl' },
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
        },
        createdRow: function( row, data, dataIndex ) {
            //console.log(JSON.stringify(data));
            if(data.items['total'] != data.items['bayar']){
                $(row).addClass('bg-warning');
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

    //Update Table based on Tanggal Filter
    $("#filter_tanggal").on('ifChanged', function(){
        if($(this).prop('checked') === true){
            $("#input-filter_tanggal").val("Y");
        } else {
            $("#input-filter_tanggal").val("");
        }
        //console.log("Reload Table");

        tpenjualan.ajax.reload();
    });
    //Linked 2 datetimepicker
    $("#input-tanggal_mulai").on("change.datetimepicker", function (e) {
        $('#input-tanggal_akhir').datetimepicker('minDate', e.date);
        tpenjualan.ajax.reload();
    });
    $("#input-tanggal_akhir").on("change.datetimepicker", function (e) {
        $('#input-tanggal_mulai').datetimepicker('maxDate', e.date);
        tpenjualan.ajax.reload();
    });
    //Update Table based on Pembayaran Filter
    $("#filter_pembayaran").on('ifChanged', function(){
        if($(this).prop('checked') === true){
            //console.log("Belum Lunas");
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    return $(tpenjualan.row(dataIndex).node()).hasClass('bg-warning');
                }
            );
            tpenjualan.draw();
        } else {
            //console.log("Semua");
            $.fn.dataTable.ext.search.pop();
            tpenjualan.draw();
        }
    });

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
