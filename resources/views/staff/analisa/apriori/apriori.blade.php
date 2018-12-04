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

                <div class="col-12 col-lg-6">{{-- Minimal Support --}}
                    <div class="form-group">
                        <label for="input-tanggal_akhir">Min. Support</label>
                        <div class="input-group">
                            <input type="number" name="min_support" class="form-control" value="3" min="0" id="input-min_support">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    %
                                </span>
                            </div>
                        </div>
                    </div>
                </div>{{-- /.Minimal Support --}}
            </div>
        </form>

        <hr>

        <div class="row">
            <div class="col-12 col-lg-6">{{-- 1 Itemset --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">I-1 (Itemset 1)</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered" id="itemsetSatu">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Jumlah</th>
                                    <th>Support</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>{{-- /.1 Itemset --}}
            <div class="col-12 col-lg-6">{{-- 2 Itemset --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">I-2 (Itemset 2)</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered" id="itemsetDua">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Jumlah</th>
                                    <th>Support</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>{{-- /.3 Itemset --}}
            <div class="col-12 col-lg-6">{{-- 3 Itemset --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">I-2 (Itemset 2)</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered" id="itemsetTiga">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Jumlah</th>
                                    <th>Support</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>{{-- /.3 Itemset --}}
        </div>
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
            defaultDate: '{{ date("Y-08-1 00:00:00") }}',
            maxDate : '{{ date("Y-m-d H:i:00") }}'
        });
        $('#input-tanggal_akhir').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD HH:mm',
            defaultDate: '{{ date("Y-08-31 H:i:00") }}',
            minDate : '{{ date("Y-08-1 H:i:00") }}',
            maxDate : '{{ date("Y-m-d H:i:00") }}'
        });

        var tSatu = $("#itemsetSatu").DataTable({
            responsive: true,
            processing: true,
            autoWidth: true,
            ajax: {
                method: "POST",
                data: function(d){
                    d.tanggal_mulai = document.getElementById("input-tanggal_mulai").value,
                    d.tanggal_akhir = document.getElementById("input-tanggal_akhir").value
                },
                url: "{{ url('penjualan/apriori') }}",
            },
            columns: [
                { data: null },
                { data: 'barang_nama' },
                { data: 'jumlah' },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: [0],
                    searchable: false,
                    orderable: false,
                }, {
                    targets: [3],
                    render: function(data, type, row) {
                        var jumlah = parseFloat(data.jumlah);
                        var total = parseFloat(data.total);

                        var support = Math.round(jumlah * 100)/total;
                        //var support = jumlah/total;
                        return support.toFixed(2)+"%";
                    }
                },
            ],
            pageLength: 5,
            aLengthMenu:[5,10,15,25,50],
            order: [3, 'desc'],
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            createdRow: function( row, data, dataIndex ) {
                //console.log(JSON.stringify(data));
                var jumlah = parseFloat(data.jumlah);
                var total = parseFloat(data.total);
                var support = Math.round(jumlah * 100)/total;

                var minsupport = parseFloat($("#input-min_support").val());

                if(support > minsupport){
                    $(row).addClass('bg-success');
                }
            }
        });
        tSatu.on( 'order.dt search.dt', function () {
            tSatu.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        }).draw();

        var tDua = $("#itemsetDua").DataTable({
            responsive: true,
            processing: true,
            autoWidth: true,
            ajax: {
                method: "POST",
                data: function(d){
                    d.min_support = document.getElementById("input-min_support").value,
                    d.tanggal_mulai = document.getElementById("input-tanggal_mulai").value,
                    d.tanggal_akhir = document.getElementById("input-tanggal_akhir").value
                },
                url: "{{ url('penjualan/apriori/dua') }}",
            },
            columns: [
                { data: null },
                { data: 'item' },
                { data: 'jumlah' },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: [0],
                    searchable: false,
                    orderable: false,
                },
                {
                    targets: [3],
                    render: function(data, type, row) {
                        var jumlah = parseFloat(data.jumlah);
                        var total = parseFloat(data.total);

                        var support = Math.round(jumlah * 100)/total;
                        //var support = jumlah/total;
                        return support.toFixed(2)+"%";
                    }
                },
            ],
            pageLength: 5,
            aLengthMenu:[5,10,15,25,50],
            order: [2, 'desc'],
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            createdRow: function( row, data, dataIndex ) {
                //console.log(JSON.stringify(data));
                var jumlah = parseFloat(data.jumlah);
                var total = parseFloat(data.total);
                var support = Math.round(jumlah * 100)/total;

                var minsupport = parseFloat($("#input-min_support").val());

                if(support > minsupport){
                    $(row).addClass('bg-success');
                }
            }
        });
        tDua.on( 'order.dt search.dt', function () {
            tDua.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        }).draw();

        var tTiga = $("#itemsetTiga").DataTable({
            responsive: true,
            processing: true,
            autoWidth: true,
            ajax: {
                method: "POST",
                data: function(d){
                    d.min_support = document.getElementById("input-min_support").value,
                    d.tanggal_mulai = document.getElementById("input-tanggal_mulai").value,
                    d.tanggal_akhir = document.getElementById("input-tanggal_akhir").value
                },
                url: "{{ url('penjualan/apriori/tiga') }}",
            },
            columns: [
                { data: null },
                { data: 'item' },
                { data: 'jumlah' },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: [0],
                    searchable: false,
                    orderable: false,
                },
                {
                    targets: [3],
                    render: function(data, type, row) {
                        var jumlah = parseFloat(data.jumlah);
                        var total = parseFloat(data.total);

                        var support = Math.round(jumlah * 100)/total;
                        //var support = jumlah/total;
                        return support.toFixed(2)+"%";
                    }
                },
            ],
            pageLength: 5,
            aLengthMenu:[5,10,15,25,50],
            order: [2, 'desc'],
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            createdRow: function( row, data, dataIndex ) {
                //console.log(JSON.stringify(data));
                var jumlah = parseFloat(data.jumlah);
                var total = parseFloat(data.total);
                var support = Math.round(jumlah * 100)/total;

                var minsupport = parseFloat($("#input-min_support").val());

                if(support > minsupport){
                    $(row).addClass('bg-success');
                }
            }
        });
        tTiga.on( 'order.dt search.dt', function () {
            tTiga.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        }).draw();

        //Linked 2 datetimepicker
        $("#input-tanggal_mulai").on("change.datetimepicker", function (e) {
            $('#input-tanggal_akhir').datetimepicker('minDate', e.date);
            tSatu.ajax.reload();
            tDua.ajax.reload();
            tTiga.ajax.reload();
        });
        $("#input-tanggal_akhir").on("change.datetimepicker", function (e) {
            $('#input-tanggal_mulai').datetimepicker('maxDate', e.date);
            tSatu.ajax.reload();
            tDua.ajax.reload();
            tTiga.ajax.reload();
        });

        //Linked to Min Support
        $("#input-min_support").on('change', function(e){
            //console.log("Min Support Change to : "+$(this).val());
            tSatu.ajax.reload();
            tDua.ajax.reload();
            tTiga.ajax.reload();
        });
    });
</script>
@endsection
