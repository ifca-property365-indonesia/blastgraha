@extends('layouts.app')
@section('container')
<link rel="stylesheet" href="{{ url('assets/css/datepicker/bootstrap-datepicker.css') }}" type="text/css">
<link rel="stylesheet" href="{{ url('assets/css/datepicker/bootstrap-datepicker.min.css') }}" type="text/css">

<script src="{{ url('assets/js/custom/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('assets/js/custom/datepicker/bootstrap-datepicker.min.js') }}"></script>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2 class="d-flex align-items-center">
                        Payment History
                    </h2>
                </div>
                <form method="POST" class="form" id="searchForm" novalidate="novalidate" autocomplete="off">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Toolbar-->
                        {{ csrf_field() }}
                        <div class="input-group w-300px">
                            <input type="text" name="start_date" id="start_date" class="form-control"
                                data-date-format="dd/mm/yyyy" value="{{ date('d/m/Y') }}" />
                            <span class="input-group-text">
                                to
                            </span>
                            <input type="text" name="end_date" id="end_date" class="form-control"
                                data-date-format="dd/mm/yyyy" value="{{ date('d/m/Y') }}" />
                        </div>
                        <!--begin::Search-->
                        <button type="button" id="btnSearch" class="btn btn-light-primary" title="Search">
                            <span class="indicator-label">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                {{-- <span>Search</span> --}}
                            </span>
                        </button>
                        <!--end::Search-->
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </form>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Input group-->
                <div class="row mb-3">
                    <!--begin::Col-->
                    <div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-12">
                        <!--begin::Label-->
                        <label class="fw-semibold fs-6 mt-3">Choose Project</label>
                        <!--end::Label-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-4 col-lg-8 col-md-8 col-sm-8 col-8">
                        <select name="comboProject" id="comboProject" class="form-select form-select-solid border"
                            data-control="select2" data-placeholder="Choose a Project">
                            {!! $comboProject !!}
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_pay_history">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-75px">Entity Cd</th>
                                <th class="min-w-75px">Project No</th>
                                <th class="min-w-75px">Debtor Acct</th>
                                <th class="min-w-100px">Debtor Name</th>
                                <th class="min-w-75px">Unit No</th>
                                <th class="min-w-100px">Transaction Id</th>
                                <th class="min-w-75px">Payment Date</th>
                                <th class="min-w-75px">Payment Total</th>
                                <th class="min-w-50px">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">

                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Table container-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Post-->
</div>

<!--begin::Javascript-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#start_date').datepicker({
            orientation: "bottom auto"
        });
        $('#end_date').datepicker({
            orientation: "bottom auto"
        });
        $('#comboProject').trigger('change');
    });

    var tblpayhistory;
    tblpayhistory = $('#table_pay_history').DataTable({
        processing: true,
        serverSide: false,
        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, 'All']
        ],
        ajax: {
            url : "{{ route('table.payment.history') }}",
            type : "POST",
            data : {
                _token : "{{ csrf_token() }}",
                start_date : function (d) {
                    var a = $('#start_date').val();
                    var b = "";
                    if (a == null) {
                        return b;
                    } else {
                        return a;
                    }
                },
                end_date : function (d) {
                    var a = $('#end_date').val();
                    var b = "";
                    if (a == null) {
                        return b;
                    } else {
                        return a;
                    }
                },
                "project": function (d) {
                    var a = $('#comboProject').find(':selected').val();
                    var b = "all";
                    if (a == null || a == '') {
                        return b;
                    } else {
                        return a;
                    }
                },
            }
        },
        columns: [
            { data: 'entity_cd', name: 'entity_cd' },
            { data: 'project_no', name: 'project_no' },
            { data: 'debtor_acct', name: 'debtor_acct' },
            { data: 'debtor_name', name: 'debtor_name' },
            { data: 'lot_no', name: 'lot_no' },
            { data: 'transaction_id', name: 'transaction_id' },
            { data: 'payment_date', name: 'payment_date',
                render: function (data, type, row) {
                    var year = data.substr(0,4);
                    var month= data.substr(5,2);
                    var day = data.substr(8,2);
                    var time = data.substr(11,8);
                    return day+"/"+month+"/"+year+" "+time;
                }
            },
            { data: 'payment_total', name: 'payment_total',
                render: function (data, type, row) {
                    return "Rp. " + number_format(data);
                }    
            },
            { data: 'payment_status', name: 'payment_status',
                render: function (data, type, row) {
                    if (data == 'PAID' || data == 'CAPTURED') {
                        descs = data;
                        color = 'badge-light-success';
                    } else {
                        descs = data;
                        color = 'badge-light-danger';
                    }

                    return '<span class="badge py-3 px-4 fs-7 '+color+'">'+ descs +'</span>';
                }
            }
        ],
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-sm btn-primary',
                text: ' <i class="ki-duotone ki-exit-down fs-2 me-3"><span class="path1"></span><span class="path2"></span></i>Export Report',
                buttons: [
                    {
                        extend: 'csv',
                        filename: function() {
                            var startDate = $('#start_date').val();
                            var endDate = $('#end_date').val();
                            return 'Payment History'+'_'+ startDate + '_' + endDate;
                        },
                        footer: true
                    }
                ],
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                }
            },
        ]
    });

    $('#btnSearch').click(function (event) {
        event.preventDefault();
        if (event.handled !== true) {
            event.handled = true;

            tblpayhistory.ajax.reload(null, true);
        }
    });

    $('#comboProject').change(function (event) {
        event.preventDefault();
        if (event.handled !== true) {
            event.handled = true;

            tblpayhistory.ajax.reload(null, true);
        }
    });

    function number_format (number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
</script>
<!--end::Javascript-->
@endsection