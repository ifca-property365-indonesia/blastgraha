@extends('layouts.app')
@section('container')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<!--begin::Toolbar-->
<div class="toolbar py-3 py-lg-6" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class=" container-xxl  d-flex flex-stack flex-wrap gap-2">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <span class="text-gray-600 text-hover-primary">
                        Dashboard
                    </span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    WhatsApp Statistics
                </li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="{{ route('dash') }}"
                class="btn btn-flex bg-body btn-color-primary opacity-75-hover h-35px h-lg-40px px-5 mr-5 me-3">
                <i class="ki-duotone ki-arrow-left fs-4 m-0">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <span class="me-4">
                    <span class="text-primary fw-semibold me-1">Back</span>
                </span>
            </a>
            <!--end::Button-->

            <!--start::Select2-->
            <select class="form-select form-select-transparent" data-control="select2" data-hide-search="true"
                data-placeholder="Type Blast" id="type_blast" name="type_blast">
                <option value="invoice">Invoice</option>
            </select>
            <!--end::Select2-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Row-->
        <div class="row g-5 g-lg-10">
            <!--begin::Col-->
            <div class="col-xxl-3 col-md-3 mb-5 mb-lg-10">
                <!--begin::Mixed Widget 1-->
                <div class="card card-xxl-stretch shadow">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="fw-bold fs-1" data-kt-countup="true" data-kt-countup-value=""
                                    id="div_pending">
                                </div>
                                <div class="fw-semibold fs-6">Pending</div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-center rounded-circle w-50px h-50px bg-light-warning border-clarity-warning"
                                    style="border: 1px solid var(--bs-warning-clarity)">
                                    <i class="fa-regular fa-clock text-warning fs-2qx lh-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-3 col-md-3 mb-5 mb-lg-10">
                <!--begin::Mixed Widget 2-->
                <div class="card card-xxl-stretch shadow">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="fw-bold fs-1" data-kt-countup="true" data-kt-countup-value=""
                                    id="div_processed">
                                </div>
                                <div class="fw-semibold fs-6">Processed</div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-center rounded-circle w-50px h-50px bg-light-primary border-clarity-primary"
                                    style="border: 1px solid var(--bs-primary-clarity)">
                                    <i class="fa-regular fa-clock text-primary fs-2qx lh-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 2-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-3 col-md-3 mb-5 mb-lg-10">
                <!--begin::Mixed Widget 3-->
                <div class="card card-xxl-stretch shadow">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="fw-bold fs-1" data-kt-countup="true" data-kt-countup-value=""
                                    id="div_delivered">
                                </div>
                                <div class="fw-semibold fs-6">Delivered</div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-center rounded-circle w-50px h-50px bg-light-success border-clarity-success"
                                    style="border: 1px solid var(--bs-success-clarity)">
                                    <i class="fa-solid fa-envelope-circle-check text-success fs-2qx lh-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 3-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-3 col-md-3 mb-5 mb-lg-10">
                <!--begin::Mixed Widget 4-->
                <div class="card card-xxl-stretch shadow">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="fw-bold fs-1" data-kt-countup="true" data-kt-countup-value=""
                                    id="div_rejected">
                                </div>
                                <div class="fw-semibold fs-6">Rejected</div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-center rounded-circle w-50px h-50px bg-light-danger border-clarity-danger"
                                    style="border: 1px solid var(--bs-danger-clarity)">
                                    <i class="fa-regular fa-circle-xmark text-danger fs-2qx lh-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 4-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row g-5 g-lg-10">
            <!--begin::Col-->
            <div class="col-xxl-12 col-md-12 mb-5 mb-lg-10">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">WhatsApp Statistics by Filter Date</span>
                        </h3>
                        <div class="card-toolbar">
                            <div class="input-group mb-3">
                                <span class="input-group-text cursor-pointer">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-calendar">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                </span>
                                <input type="text" class="form-control" placeholder="Pick date range" id="date_range"
                                    name="date_range" />
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-4">
                        <!--begin::Chart container-->
                        <div id="div_whatsapp_by_date">
                            <canvas id="whatsapp_by_date_chart"></canvas>
                        </div>
                        <!--end::Chart container-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row g-5 g-lg-10">
            <!--begin::Col-->
            <div class="col-xxl-12 col-md-12 mb-5 mb-lg-10">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold fs-3 mb-1">WhatsApp Statistics by Quota per Month</span>
                        </h3>
                        <!--begin::Form-->
                        <form method="POST" class="form" id="searchForm" novalidate="novalidate" autocomplete="off">
                            {{ csrf_field() }}
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                <div class="w-100 mw-150px fv-row">
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid mr-5 required" name="year"
                                        id="year" placeholder="Year" value="{{ now()->year }}">
                                    <!--end::Input-->
                                </div>
                                <!--begin::Search-->
                                <button type="button" id="btnSearch" class="btn btn-sm btn-primary">
                                    <span class="indicator-label">
                                        <i class="fa-solid fa-magnifying-glass me-3"></i>
                                        <span>Search</span>
                                    </span>
                                </button>
                                <!--end::Search-->
                            </div>
                            <!--end::Card toolbar-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-4">
                        <!--begin::Chart container-->
                        <div id="div_whatsapp_by_month">
                            <canvas id="whatsapp_by_month_chart"></canvas>
                        </div>
                        <!--end::Chart container-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Post-->
</div>
<!--begin::Javascript-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#date_range').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            }
        });

        var type_blast = $('#type_blast').val();
        var date_range = $('#date_range').val();
        var split = date_range.split(" - ");
        var start_date = split[0];
        var end_date = split[1];

        loading(true);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "{{ route('dash.whatsapp.get.graph') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                type_blast: type_blast,
                start_date: start_date,
                end_date: end_date,
            },
            success: function(data) {
                loading(false);

                $('#div_pending').html(data.count.pending);
                $('#div_processed').html(data.count.process);
                $('#div_delivered').html(data.count.deliver);
                $('#div_rejected').html(data.count.reject);

                $('#div_pending').attr('data-kt-countup-value', data.count.pending);
                $('#div_processed').attr('data-kt-countup-value', data.count.process);
                $('#div_delivered').attr('data-kt-countup-value', data.count.deliver);
                $('#div_rejected').attr('data-kt-countup-value', data.count.reject);

                $("#whatsapp_by_date_chart").remove();
                $("#div_whatsapp_by_date").append('<canvas id="whatsapp_by_date_chart"></canvas>');
                const ctx = document.getElementById('whatsapp_by_date_chart').getContext("2d");

                new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
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

        const form = document.getElementById('searchForm');

        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    year: {
                        validators: {
                            integer: {
                                message: 'The value is not an integer',
                                thousandsSeparator: '',
                                decimalSeparator: '.',
                            },
                            notEmpty: {
                                message: 'This field is required.'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        $('#btnSearch').click(function (event) {
            event.preventDefault();
            if (event.handled !== true) {
                event.handled = true;

                if (validator) {
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            loading(true);

                            var datafrm = $('#searchForm').serializeArray();

                            $.ajax({
                                type: 'POST',
                                dataType: 'json',
                                url: "{{ route('dash.whatsapp.get.graph.month') }}",
                                data: datafrm,
                                success: function(alldt){
                                    loading(false);
                                    
                                    $("#whatsapp_by_month_chart").remove();
                                    $("#div_whatsapp_by_month").append('<canvas id="whatsapp_by_month_chart"></canvas>');
                                    const ctx = document.getElementById('whatsapp_by_month_chart').getContext("2d");

                                    // cara buat garis pembatas pada chart
                                    const horizontalDottedLine = {
                                        id: 'horizontalDottedLine',
                                        beforeDatasetsDraw(chart, args, options) {
                                            const {
                                                ctx, chartArea: { top, right, bottom, left, width, height },
                                                scales: { x, y } 
                                            } = chart;
                                            ctx.save();

                                            // draw line
                                            ctx.strokeStyle = 'red';
                                            ctx.setLineDash([10, 5]);
                                            ctx.strokeRect(left, y.getPixelForValue(1000), width, 0);
                                            ctx.restore();
                                        }
                                    }

                                    new Chart(ctx, {
                                        type: 'bar',
                                        data: alldt,
                                        options: {
                                            responsive: true,
                                            scales: {
                                                x: {
                                                    stacked: true,
                                                },
                                                y: {
                                                    beginAtZero: true,
                                                    stacked: true,
                                                },
                                            }
                                        },
                                        // plugins: [horizontalDottedLine]
                                    });
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
                    })
                }
            }
        });
    });

    $('#type_blast').change(function() {
        var type_blast = $(this).val();
        var date_range = $('#date_range').val();
        var split = date_range.split(" - ");
        var start_date = split[0];
        var end_date = split[1];

        loading(true);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "{{ route('dash.whatsapp.get.graph') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                type_blast: type_blast,
                start_date: start_date,
                end_date: end_date,
            },
            success: function(data) {
                loading(false);

                $('#div_pending').html(data.count.pending);
                $('#div_processed').html(data.count.process);
                $('#div_delivered').html(data.count.deliver);
                $('#div_rejected').html(data.count.reject);

                $('#div_pending').attr('data-kt-countup-value', data.count.pending);
                $('#div_processed').attr('data-kt-countup-value', data.count.process);
                $('#div_delivered').attr('data-kt-countup-value', data.count.deliver);
                $('#div_rejected').attr('data-kt-countup-value', data.count.reject);

                $("#email_by_date_chart").remove();
                $("#div_email_by_date").append('<canvas id="email_by_date_chart"></canvas>');
                const ctx = document.getElementById('email_by_date_chart').getContext("2d");

                new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
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
    });

    $("#date_range").change(function() {
        var type_blast = $('#type_blast').val();
        var date_range = this.value;
        var split = date_range.split(" - ");
        var start_date = split[0];
        var end_date = split[1];

        loading(true);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "{{ route('dash.whatsapp.get.graph') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                type_blast: type_blast,
                start_date: start_date,
                end_date: end_date,
            },
            success: function(data) {
                loading(false);

                $('#div_pending').html(data.count.pending);
                $('#div_processed').html(data.count.process);
                $('#div_delivered').html(data.count.deliver);
                $('#div_rejected').html(data.count.reject);

                $('#div_pending').attr('data-kt-countup-value', data.count.pending);
                $('#div_processed').attr('data-kt-countup-value', data.count.process);
                $('#div_delivered').attr('data-kt-countup-value', data.count.deliver);
                $('#div_rejected').attr('data-kt-countup-value', data.count.reject);

                $("#email_by_date_chart").remove();
                $("#div_email_by_date").append('<canvas id="email_by_date_chart"></canvas>');
                const ctx = document.getElementById('email_by_date_chart').getContext("2d");

                new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
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
</script>
<!--end::Javascript-->
@endsection