@extends('layouts.app')
@section('container')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css">
<link rel="stylesheet" href="{{ url('assets/css/datepicker/bootstrap-datepicker.css') }}" type="text/css">
<link rel="stylesheet" href="{{ url('assets/css/datepicker/bootstrap-datepicker.min.css') }}" type="text/css">

<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="{{ url('assets/js/custom/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('assets/js/custom/datepicker/bootstrap-datepicker.min.js') }}"></script>

<style type="text/css">
    table.dataTable tr th.select-checkbox.selected::after {
        content: "✔";
        margin-top: -11px;
        margin-left: -6px;
        text-align: center;
        text-shadow: rgb(255, 255, 255) 1px 1px, rgb(255, 255, 255) -1px -1px, rgb(255, 255, 255) 1px -1px, rgb(255, 255, 255) -1px 1px;
    }
</style>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <ul class="nav nav-tabs nav-line-tabs nav-stretch nav-line-tabs-2x fs-6 border-transparent">
            <li class="nav-item">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab"
                    href="#success">Success</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary" data-bs-toggle="tab" href="#failed">Failed</a>
            </li>
        </ul>
        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab panel-->
            <div class="tab-pane fade active show" id="success" role="tabpanel">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="d-flex align-items-center">
                                Invoice WhatsApp History
                            </h2>
                        </div>
                        <form method="POST" class="form" id="searchForm" novalidate="novalidate" autocomplete="off">
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                <!--begin::Toolbar-->
                                {{ csrf_field() }}
                                <div class="input-group w-300px">
                                    <input type="text" name="start_date" id="start_date"
                                        class="form-control start-success" data-date-format="dd/mm/yyyy"
                                        value="{{ date('d/m/Y') }}" />
                                    <span class="input-group-text">
                                        to
                                    </span>
                                    <input type="text" name="end_date" id="end_date" class="form-control end-success"
                                        data-date-format="dd/mm/yyyy" value="{{ date('d/m/Y') }}" />
                                </div>
                                <!--begin::Search-->
                                <button type="button" id="btnSearchSuccess" class="btn btn-light-primary"
                                    title="Search">
                                    <span class="indicator-label">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        {{-- <span>Search</span> --}}
                                    </span>
                                </button>
                                <!--end::Search-->
                                <div class="form-floating w-100px">
                                <select name="status" data-control="select2"data-kt-table-widget-4="filter_status" data-hide-search="true" id="status" 
                                class="form-select form-select-transparent" data-placeholder="Choose a Status">
                                    <option value="all">All</option>
                                    <option value="Y">Sent</option>
                                    <option value="D">Delivered</option>
                                    <option value="R">Read</option>
                                </select>
                                <label for="status">Choose Status</label>
                                </div>
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
                            <div class="col-lg-2">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mt-3">Choose Project</label>
                                <!--end::Label-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-4">
                                <select name="comboProjectSuccess" id="comboProjectSuccess"
                                    class="form-select form-select-solid border" data-control="select2"
                                    data-placeholder="Choose a Project">
                                    {!! $comboProject !!}
                                </select>
                            </div>
                            <!--end::Col-->
                            <div class="col-lg-2 mx-auto">
                                
                            </div>
                        </div>
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_success">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-75px">Entity Cd</th>
                                        <th class="min-w-75px">Project No</th>
                                        <th class="min-w-125px">Debtor Acct</th>
                                        <th class="min-w-125px">Name</th>
                                        <th class="min-w-125px">No. Telp</th>
                                        <th class="min-w-125px">Doc No</th>
                                        <th class="min-w-75px">Status</th>
                                        <th class="min-w-75px">Send Date</th>
                                        <th class="text-end min-w-50px">Actions</th>
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
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div class="tab-panel fade" id="failed" role="tabpanel">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="d-flex align-items-center">
                                Invoice WhatsApp History
                            </h2>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Form-->
                        <form method="POST" class="form" id="searchForm" novalidate="novalidate" autocomplete="off">
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                <!--begin::Toolbar-->
                                {{ csrf_field() }}
                                <div class="input-group w-300px">
                                    <input type="text" name="start_date" id="start_date"
                                        class="form-control start-failed" data-date-format="dd/mm/yyyy"
                                        value="{{ date('d/m/Y') }}" />
                                    <span class="input-group-text">
                                        to
                                    </span>
                                    <input type="text" name="end_date" id="end_date" class="form-control end-failed"
                                        data-date-format="dd/mm/yyyy" value="{{ date('d/m/Y') }}" />
                                </div>
                                <!--begin::Search-->
                                <button type="button" id="btnSearchFailed" class="btn btn-light-primary" title="Search">
                                    <span class="indicator-label">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        {{-- <span>Search</span> --}}
                                    </span>
                                </button>
                                <!--end::Search-->
                                <!--begin::Resend-->
                                <button type="button" id="btnResend" class="btn btn-light-primary me-3">
                                    <i class="fa-solid fa-rotate-left me-2"></i>
                                    Resend WhatsApp
                                </button>
                                <!--end::Resend-->
                            </div>
                            <!--end::Card toolbar-->
                        </form>
                        <!--end::Form-->
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
                                <select name="comboProjectFailed" id="comboProjectFailed"
                                    class="form-select form-select-solid border" data-control="select2"
                                    data-placeholder="Choose a Project">
                                    {!! $comboProject !!}
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_failed">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-30px"></th>
                                        <th class="min-w-75px">Entity Cd</th>
                                        <th class="min-w-75px">Project No</th>
                                        <th class="min-w-125px">Debtor Acct</th>
                                        <th class="min-w-125px">Name</th>
                                        <th class="min-w-125px">No. Telp</th>
                                        <th class="min-w-125px">Doc No</th>
                                        <th class="min-w-75px">Status</th>
                                        <th class="min-w-75px">Send Date</th>
                                        <th class="text-end min-w-50px">Actions</th>
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
            <!--end::Tab panel-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::Post-->
</div>

<!--begin::Javascript-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#status').change(function() {
            tblsuccess.ajax.reload(null, true);
        });
    });

    $(document).ready(function() {
        $('.start-success').datepicker({
            orientation: "bottom auto"
        });
        $('.end-success').datepicker({
            orientation: "bottom auto"
        });
        $('.start-failed').datepicker({
            orientation: "bottom auto"
        });
        $('.end-failed').datepicker({
            orientation: "bottom auto"
        });
        $('#comboProjectSuccess').trigger('change');
        $('#comboProjectFailed').trigger('change');
    });

    var tblsuccess;
    tblsuccess = $('#table_success').DataTable({
        processing: true,
        serverSide: false,
        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, 'All']
        ],
        ordering: false,
        ajax: {
            url : "{{ route('table.history.whatsapp.invoice.success') }}",
            type : "POST",
            data : {
                _token : "{{ csrf_token() }}",
                status : function (d) {
                    var search = $('#status').val();
                    var b = "";
                    if (search == null || search == "") {
                        return b;
                    } else {
                        return search;
                    }
                },
                start_date : function (d) {
                    var a = $('.start-success').val();
                    var b = "";
                    if (a == null) {
                        return b;
                    } else {
                        return a;
                    }
                },
                end_date : function (d) {
                    var a = $('.end-success').val();
                    var b = "";
                    if (a == null) {
                        return b;
                    } else {
                        return a;
                    }
                },
                project : function (d) {
                    var a = $('#comboProjectSuccess').find(':selected').val();
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
            { data: 'cust_name', name: 'cust_name' },
            { data: 'wa_no', name: 'wa_no' },
            { data: 'doc_no', name: 'doc_no' },
            { data: 'send_flag', name: 'send_flag',
                render: function (data, type, row) {
                    if (data == 'Y') {
                        color = 'badge-light-info';
                        descs = 'Sent';
                    } else if (data == 'D') {
                        color = 'badge-light-primary';
                        descs = 'Delivered';
                    } else if (data == 'R') {
                        color = 'badge-light-success';
                        descs = 'Read';
                    } else {
                        color = 'badge-light-danger';
                        descs = 'Failed';
                    }
                    return '<span class="badge py-3 px-4 fs-7 '+color+'">'+descs+'</span>';
                }
            },
            { data: 'send_date', name: 'send_date' },
            { data: null, className: 'details-control text-end', 
                defaultContent: '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-table-widget-4="expand_row">'+
                    '<i class="fa-solid fa-caret-down"></i>'+
                '</button>', 
                orderable: false,
            }
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(5, {page:'current'} )
                .data()
                .each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="6"><strong>'+group+'</strong></td></tr>'
                    );
 
                    last = group;
                }
            });
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-sm btn-primary',
                text: ' <i class="ki-duotone ki-exit-down fs-2 me-3"><span class="path1"></span><span class="path2"></span></i>Export Report',
                buttons: [
                    {
                        extend: 'excel',
                        title: function() {
                            var startDate = $('#start_date').val();
                            var endDate = $('#end_date').val();
                            return 'Log Invoice History '+ startDate + '-' + endDate;
                        },
                        filename: function() {
                            var startDate = $('#start_date').val();
                            var endDate = $('#end_date').val();
                            return 'Log Invoice History'+'_'+ startDate + '_' + endDate;
                        },
                        footer: true,
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                }
            },
        ]
    });

    $('#table_success tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tblsuccess.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            var data = row.data();
            row.child( detail(data) ).show();
            tr.addClass('shown');
        }
    });
    
    var tblfailed;
    tblfailed = $('#table_failed').DataTable({
        processing: true,
        serverSide: false,
        // paging: false,
        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, 'All']
        ],
        ordering: false,
        ajax: {
            url : "{{ route('table.history.whatsapp.invoice.failed') }}",
            type : "POST",
            data : {
                _token : "{{ csrf_token() }}",
                start_date : function (d) {
                    var a = $('.start-failed').val();
                    var b = "";
                    if (a == null) {
                        return b;
                    } else {
                        return a;
                    }
                },
                end_date : function (d) {
                    var a = $('.end-failed').val();
                    var b = "";
                    if (a == null) {
                        return b;
                    } else {
                        return a;
                    }
                },
                "project": function (d) {
                    var a = $('#comboProjectFailed').find(':selected').val();
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
            { data: null, className: 'select-checkbox', defaultContent: '', orderable: false },
            { data: 'entity_cd', name: 'entity_cd' },
            { data: 'project_no', name: 'project_no' },
            { data: 'debtor_acct', name: 'debtor_acct' },
            { data: 'cust_name', name: 'cust_name' },
            { data: 'wa_no', name: 'wa_no' },
            { data: 'doc_no', name: 'doc_no'},
            { data: 'send_flag', name: 'send_flag',
                render: function (data, type, row) {
                    if (data == 'E') {
                        color = 'badge-light-secondary';
                        descs = 'No WhatsApp Number';
                    } else if (data == 'M') {
                        color = 'badge-light-warning';
                        descs = 'No File';
                    } else {
                        color = 'badge-light-danger';
                        descs = 'Failed';
                    }
                    return '<span class="badge py-3 px-4 fs-7 '+color+'">'+descs+'</span>';
                }
            },
            { data: 'send_date', name: 'send_date' },
            { data: null, className: 'details-control text-end', 
                defaultContent: '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-table-widget-4="expand_row">'+
                    '<i class="fa-solid fa-caret-down"></i>'+
                '</button>', 
                orderable: false,
            }
        ],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(6, {page:'current'} )
                .data()
                .each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="6"><strong>'+group+'</strong></td></tr>'
                    );
 
                    last = group;
                }
            });
        },
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-sm btn-primary',
                text: ' <i class="ki-duotone ki-exit-down fs-2 me-3"><span class="path1"></span><span class="path2"></span></i>Export Report',
                buttons: [
                    {
                        extend: 'excel',
                        title: function() {
                            var startDate = $('#start_date').val();
                            var endDate = $('#end_date').val();
                            return 'Log Failed Invoice History '+ startDate + '-' + endDate;
                        },
                        filename: function() {
                            var startDate = $('#start_date').val();
                            var endDate = $('#end_date').val();
                            return 'Log Failed Invoice History'+'_'+ startDate + '_' + endDate;
                        },
                        footer: true,
                        exportOptions: {
                            columns: [1, 3, 4, 5, 6, 7]
                        }
                    }
                ],
                init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                }
            },
        ]
    });

    tblfailed.on("click", "th.select-checkbox", function()
    {
        if ($("th.select-checkbox").hasClass("selected")) {
            tblfailed.rows().deselect();
            $("th.select-checkbox").removeClass("selected");
        } else {
            var numRowsToSelect = 100;

            var rowsToSelect = [];
            for (var i = 0; i < numRowsToSelect; i++) {
                rowsToSelect.push(i);
            }

            tblfailed.rows(rowsToSelect).select();
            $("th.select-checkbox").addClass("selected");
        }
    }).on("select deselect", function() {
        ("Some selection or deselection going on")
        if (tblfailed.rows({
                selected: true
            }).count() !== tblfailed.rows().count()) {
            $("th.select-checkbox").removeClass("selected");
        } else {
            $("th.select-checkbox").addClass("selected");
        }
    });

    tblfailed.on("click", "td.select-checkbox", function()
    {
        var row = $(this).closest("tr");
        var dataTableRows = tblfailed.rows({selected: true}).count();

        if (dataTableRows >= 100)
        {
            if (row.hasClass("selected")) {
                tblfailed.rows(this).deselect();
            } else {
                Swal.fire({
                    title: "Error",
                    icon: "error",
                    text: "Sorry, only 100 rows are allowed for a single process.",
                    confirmButtonText: "OK"
                });
            }
            return false;
        }
    });

    $('#table_failed tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tblfailed.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            var data = row.data();
            row.child( detail(data) ).show();
            tr.addClass('shown');
        }
    });

    function detail ( d ) {
        //TABLE AR WHATSAPP DETAIL
        $.getJSON("{{ url('show-table-history-whatsapp-invoice-detail') }}" + "/" + d.rowID, function (data) {
            if (data != null && data.length > 0) {
                $.each(data, function( key, val ) {
                    var year = val.doc_date.substr(0,4);
                    var month= val.doc_date.substr(5,2);
                    var day = val.doc_date.substr(8,2);
                    var doc_date = day+"/"+month+"/"+year;

                    $('#bodydetail'+d.rowID).append(
                        '<tr>'+
                            '<td class="ps-9">'+val.descs+'</td>'+
                            '<td>'+val.type_doc+'</td>'+
                            '<td class="text-end">'+number_format(val.amount)+'</td>'+
                            '<td class="text-end">'+'<a href="#" onclick=previewFile("'+val.file_name+'") class="btn btn-icon-danger btn-text-danger" title="'+val.file_name+'"><i class="ki-duotone ki-document fs-1"><span class="path1"></span><span class="path2"></span></i></a></td>'+
                        '</tr>'
                    )
                });
            } else {
                $('#bodydetail'+d.rowID).append(
                    '<tr>'+
                        '<td colspan="4" class="fs-6 fw-bold text-center">No data available in table</td>'+
                    '</tr>'
                )
            }
        });

        var html =
            '<div class="card card-xxl-stretch mb-5 mb-xl-10">'+
                '<div class="table-responsive">'+
                    '<table id="tblinvoicehistorydetail" class="table table-row-bordered align-middle gy-5">'+
                        '<thead>'+
                            '<tr class="fw-semibold fs-6 text-gray-800">'+
                                '<th class="min-w-90px ps-9">Descs</th>'+
                                '<th class="min-w-90px">Type Doc</th>'+
                                '<th class="min-w-100px text-end">Doc Amount</th>'+
                                '<th class="min-w-90px text-end">File Name</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody class="fs-8" id="bodydetail'+d.rowID+'">'+

                        '</tbody>'+
                    '</table>'+
                '</div>'+
            '</div>';
        return html;
    }

    $('#comboProjectSuccess').change(function (event) {
        event.preventDefault();
        if (event.handled !== true) {
            event.handled = true;

            tblsuccess.ajax.reload(null, true);
        }
    });

    $('#comboProjectFailed').change(function (event) {
        event.preventDefault();
        if (event.handled !== true) {
            event.handled = true;

            tblfailed.ajax.reload(null, true);
        }
    });

    function loading(event) {
        const loadingDiv = document.getElementById('kt_body');

        if (event == true) {
            // Show loading indication
            loadingDiv.setAttribute('data-kt-app-page-loading', 'on');
        
            loadingDiv.setAttribute('data-kt-app-page-loading-enabled', 'true');
        } else {
            // Remove loading indication
            loadingDiv.removeAttribute('data-kt-app-page-loading');

            loadingDiv.removeAttribute('data-kt-app-page-loading-enabled');
        }
    }

    $(document).on('click', '#btnResend', function(event)
    {
        var dataTableRows = tblfailed.rows({selected: true}).data().toArray();
        var filteredData = dataTableRows.filter(function (row) {
            return row.send_flag === 'E';
        });
        var filteredDataFlag = dataTableRows.filter(function (row) {
            return row.send_flag === 'F' || row.send_flag === 'M';
        });

        if (dataTableRows.length == 0)
        {
            Swal.fire({
                title: "Error",
                icon: "error",
                text: "Please select at least one or select all of them.",
                confirmButtonText: "OK"
            });
            return false;
        }

        Swal.fire({
            title: 'Are you sure you want to send the selected data?',
            html: '<b>Total Data Send : ' + dataTableRows.length + '</b>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6576ff',
            cancelButtonColor: '#e85347',
            confirmButtonText: 'Yes, send it!'
        }).then(function(a) {
            if (a.isConfirmed == true)
            {
                if (filteredDataFlag.length == 0)
                {
                    Swal.fire({
                        title: "Information",
                        icon: "info",
                        text: "Sorry it can`t be processed, because this data doesn`t have a whatsapp number.",
                        confirmButtonText: "OK"
                    });
                    return false;
                } else {
                    // Show loading indication
                    loading(true);
                    var datafrm = $('#popupSendForm').serializeArray();
                    
                    $.ajax({
                        url  : '{{ route("submit.resend.invoice.whatsapp") }}',
                        data : {
                            _token: "{{ csrf_token() }}",
                            models: filteredDataFlag,
                        },
                        type : 'POST',
                        dataType: 'json',
                        success: function(event, data)
                        {
                            if(event.Error == false)
                            {
                                loading(false);

                                Swal.fire({
                                    title: "Information",
                                    icon: "success",
                                    text: event.Pesan,
                                    confirmButtonText: "OK"
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                loading(false);

                                Swal.fire({
                                    title: "Information",
                                    icon: "error",
                                    text: event.Pesan,
                                    confirmButtonText: "OK"
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                            loading(false);

                            if ('responseJSON' in jqXHR) {
                                Swal.fire({
                                    title: "Error",
                                    icon: "error",
                                    text: textStatus+' : '+jqXHR.responseJSON.message,
                                    confirmButtonText: "OK"
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    icon: "error",
                                    text: textStatus+' : '+jqXHR.statusText,
                                    confirmButtonText: "OK"
                                });
                            }
                        }
                    });   
                }
            };
        });
    });

    function previewFile(datas) {
        file_path = "{{ env('ROOT_INVOICE_FILE_PATH_GAK') }}";

        window.open(file_path + 'invoice/' + datas, '__blank');
    }

    $('#btnSearchSuccess').click(function (event) {
        event.preventDefault();
        if (event.handled !== true) {
            event.handled = true;

            tblsuccess.ajax.reload(null, true);
        }
    });

    $('#btnSearchFailed').click(function (event) {
        event.preventDefault();
        if (event.handled !== true) {
            event.handled = true;

            tblfailed.ajax.reload(null, true);
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