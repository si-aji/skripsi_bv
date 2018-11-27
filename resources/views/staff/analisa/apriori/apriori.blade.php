@extends('layouts.staff')

{{--  Require CSS for this Page  --}}
@section('plugin_css')
    <link href="{{ asset('plugins/dataTables/datatables.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datetimePicker/css/tempusdominus-bootstrap-4.css') }}" rel="stylesheet">{{-- dateTimePicker --}}
@endsection

{{-- Content Header --}}
@section('staff_content_title')
    <h1 class="m-0 text-dark">Apriori</h1>
@endsection
@section('staff_content_breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/staff') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/staff/analisa') }}">Analisa</a></li>
        <li class="breadcrumb-item active">Apriori</li>
    </ol>
@endsection{{-- Content Header --}}

@section('staff_content')
<div class="card">
    <div class="card-header no-border">
        <h3 class="card-title"><i class="fa fa-th"></i> <span id="span_title">Analisa Apriori (Data Mining)</span></h3>
    </div>

    <div class="card-body">
        <form id="aprioriForm" role="form">
            <div class="row">
                <div class="col-12 col-lg-6">{{-- Tanggal Mulai --}}
                    <div class="form-group">
                        <label for="input-tanggal_mulai">Tanggal Mulai</label>
                        <input type="text" name="tanggal_mulai" class="form-control datetimepicker-input" id="input-tanggal_mulai" data-toggle="datetimepicker" data-target="#input-tanggal_mulai">
                    </div>
                </div>{{-- /.Tanggal Mulai --}}

                <div class="col-12 col-lg-6">{{-- Tanggal Akhir --}}
                    <div class="form-group">
                        <label for="input-tanggal_akhir">Tanggal Akhir</label>
                        <input type="text" name="tanggal_akhir" class="form-control datetimepicker-input" id="input-tanggal_akhir" data-toggle="datetimepicker" data-target="#input-tanggal_akhir">
                    </div>
                </div>{{-- /.Tanggal Akhir --}}
            </div>
        </form>

        <hr>

        <table class="table table-bordered table-hover table-striped" id="penjualanTable">
            <thead>
                <tr>
                    <th class="all">No</th>
                    <th class="all">Invoice</th>
                    <th class="desktop">Barang</th>
                    <th class="desktop">Tanggal Transaksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

{{--  Require Js for this page  --}}
@section('plugins_js')
    <script src="{{ asset('plugins/dataTables/datatables.js') }}"></script>
    <script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/datatables.responsive.js') }}"></script>
    <script src="{{ asset('plugins/datetimePicker/js/tempusdominus-bootstrap-4.js') }}"></script>{{-- dateTimePicker --}}
    <script src="{{ asset('plugins/select2/select2.js') }}"></script>{{-- select2 --}}
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        document.title = "BakulVisor | Apriori";
        $("#mn-apriori").addClass('active');

        //Timepicker
        $('#input-tanggal_mulai').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD HH:mm',
            defaultDate: '{{ date("Y-m-1 00:00:00") }}',
            maxDate : '{{ date("Y-m-d H:i:00") }}'
        });
        $('#input-tanggal_akhir').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD HH:mm',
            defaultDate: '{{ date("Y-m-d H:i:00") }}',
            minDate : '{{ date("Y-m-1 H:i:00") }}',
            maxDate : '{{ date("Y-m-d H:i:00") }}'
        });

        var tpenjualan = $("#penjualanTable").DataTable({
            responsive: true,
            processing: true,
            autoWidth: true,
            ajax: {
                method: "POST",
                data: function(d){
                    d.tanggal_mulai = document.getElementById("input-tanggal_mulai").value,
                    d.tanggal_akhir = document.getElementById("input-tanggal_akhir").value
                },
                url: "{{ url('list/penjualan/date') }}",
            },
            columns: [
                { data: null },
                { data: 'penjualan_invoice' },
                { data: null },
                { data: 'penjualan_tgl' },
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
                }
            ],
            pageLength: 10,
            aLengthMenu:[5,10,15,25,50],
            order: [3, 'desc'],
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

        //Linked 2 datetimepicker
        $("#input-tanggal_mulai").on("change.datetimepicker", function (e) {
            $('#input-tanggal_akhir').datetimepicker('minDate', e.date);
            tpenjualan.ajax.reload();
        });
        $("#input-tanggal_akhir").on("change.datetimepicker", function (e) {
            $('#input-tanggal_mulai').datetimepicker('maxDate', e.date);
            tpenjualan.ajax.reload();
        });
    });
</script>
@endsection
