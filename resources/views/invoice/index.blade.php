@extends('layouts.app')
@section('container')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

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
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2 class="d-flex align-items-center">
                        Invoice List
                    </h2>
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                        <!--begin::Send-->
                        <button type="button" id="btnSend" class="btn btn-light-primary me-3">
                            <i class="fa-regular fa-paper-plane me-2"></i>
                            Send
                        </button>
                        <!--end::Send-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
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
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_invoice">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-30px"></th>
                                <th class="min-w-75px">Entity Cd</th>
                                <th class="min-w-75px">Project No</th>
                                <th class="min-w-125px">Entity Name</th>
                                <th class="min-w-125px">Debtor Acct</th>
                                <th class="min-w-125px">Name</th>
                                <th class="min-w-125px">Business Id</th>
                                <th class="min-w-125px">WhatsApp No</th>
                                <th class="min-w-125px">Doc No</th>
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
    <!--end::Post-->
</div>

<!--begin::Javascript-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#comboProject').trigger('change');
    });

    var tblinvoice;
    tblinvoice = $('#table_invoice').DataTable({
        processing: true,
        serverSide: false,
        // paging: false,
        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, 'All']
        ],
        ordering: false,
        ajax: {
            url: "{{ route('table.invoice') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
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
            { data: null, className: 'select-checkbox', defaultContent: '', orderable: false },
            { data: 'entity_cd', name: 'entity_cd' },
            { data: 'project_no', name: 'project_no' },
            { data: 'entity_induk_name', name: 'entity_induk_name' },
            { data: 'debtor_acct', name: 'debtor_acct' },
            { data: 'cust_name', name: 'cust_name' },
            { data: 'business_id', name: 'business_id' },
            { data: 'wa_no', name: 'wa_no' },
            { data: 'doc_no', name: 'doc_no' },
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
        dom: 'lfrtip'
    });

    tblinvoice.on("click", "th.select-checkbox", function()
    {
        if ($("th.select-checkbox").hasClass("selected")) {
            tblinvoice.rows().deselect();
            $("th.select-checkbox").removeClass("selected");
        } else {
            var numRowsToSelect = 100;

            var rowsToSelect = [];
            for (var i = 0; i < numRowsToSelect; i++) {
                rowsToSelect.push(i);
            }

            tblinvoice.rows(rowsToSelect).select();
            $("th.select-checkbox").addClass("selected");
        }
    }).on("select deselect", function() {
        ("Some selection or deselection going on")
        if (tblinvoice.rows({
                selected: true
            }).count() !== tblinvoice.rows().count()) {
            $("th.select-checkbox").removeClass("selected");
        } else {
            $("th.select-checkbox").addClass("selected");
        }
    });

    tblinvoice.on("click", "td.select-checkbox", function()
    {
        var row = $(this).closest("tr");
        var dataTableRows = tblinvoice.rows({selected: true}).count();

        if (dataTableRows >= 100)
        {
            if (row.hasClass("selected")) {
                tblinvoice.rows(this).deselect();
            } else {
                Swal.fire({
                    title: "Error",
                    icon: "error",
                    text: "Sorry, only 10 rows are allowed for a single process.",
                    confirmButtonText: "OK"
                });
            }
            return false;
        }
    });

    $('#table_invoice tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tblinvoice.row( tr );

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
        //TABLE AR EMAIL DETAIL
        $.getJSON("{{ url('show-table-invoice-detail') }}" + "/" + d.doc_no, function (data) {
            if (data != null && data.length > 0) {
                $.each(data, function( key, val ) {
                    var year = val.doc_date.substr(0,4);
                    var month= val.doc_date.substr(5,2);
                    var day = val.doc_date.substr(8,2);
                    var doc_date = day+"/"+month+"/"+year;

                    $('#bodydetail'+d.doc_no).append(
                        '<tr>'+
                            '<td class="ps-9">'+val.descs+'</td>'+
                            '<td>'+val.type_doc+'</td>'+
                            '<td class="text-end">'+number_format(val.amount)+'</td>'+
                            '<td>'+'<a href="#" onclick=previewFile("'+val.file_name+'") class="btn btn-icon-danger btn-text-danger" title="'+val.file_name+'"><i class="ki-duotone ki-document fs-1"><span class="path1"></span><span class="path2"></span></i></a></td>'+
                        '</tr>'
                    )
                });
            } else {
                $('#bodydetail'+d.doc_no).append(
                    '<tr>'+
                        '<td colspan="4" class="fs-6 fw-bold text-center">No data available in table</td>'+
                    '</tr>'
                )
            }
        });

        var html =
            '<div class="card card-xxl-stretch mb-5 mb-xl-10">'+
                '<div class="table-responsive">'+
                    '<table id="tblinvoicedetail" class="table table-row-bordered align-middle gy-5">'+
                        '<thead>'+
                            '<tr class="fw-semibold fs-6 text-gray-800">'+
                                '<th class="min-w-90px ps-9">Descs</th>'+
                                '<th class="min-w-90px">Type Doc</th>'+
                                '<th class="min-w-100px text-end">Doc Amount</th>'+
                                '<th class="min-w-90px">File Name</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody class="fs-8" id="bodydetail'+d.doc_no+'">'+

                        '</tbody>'+
                    '</table>'+
                '</div>'+
            '</div>';
        return html;
    }

    $('#comboProject').change(function (event) {
        event.preventDefault();
        if (event.handled !== true) {
            event.handled = true;

            tblinvoice.ajax.reload(null, true);
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

    $(document).on('click', '#btnSend', function(event)
    {
        var dataTableRows = tblinvoice.rows({selected: true}).data().toArray();

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

        $('#modaldialog').removeClass('modal-sm');
        $('#modaldialog').addClass('modal-lg');
        $('#modaltitle').html('Send invoice');
        $('#modalbody').load("{{ route('index.popup.send.invoice') }}");
        $('#modal').modal({
            'backdrop': 'static',
            'keyboard': false
        });
        $('#modal').data('models', dataTableRows);
        $('#modal').modal('show');
    });
    
    function previewFile(datas) {
        file_path = "{{ env('ROOT_INVOICE_FILE_PATH') }}";

        window.open(file_path + 'invoice/' + datas, '__blank');
    }

    function deleteFile(doc_no) {
        Swal.fire({
            title: 'Are you sure you want to delete this selected data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6576ff',
            cancelButtonColor: '#e85347',
            confirmButtonText: 'Yes, delete it!'
        }).then(function(a) {
            if (a.isConfirmed == true)
            {
                loading(true);

                $.ajax({
                    url  : '{{ route("delete.invoice") }}',
                    data : {
                        _token: "{{ csrf_token() }}",
                        doc_no: doc_no
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
                                title: "Error",
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
            } else { }
        })
    }

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