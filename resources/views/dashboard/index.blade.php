@extends('layouts.app')
@section('container')
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Row-->
        <div class="row g-5 g-lg-10">
            <!--begin::Col-->
            <div class="col-xxl-4 col-md-4 mb-5 mb-lg-10">
                <!--begin::Mixed Widget 1-->
                <div class="card h-md-100">
                    <!--begin::Body-->
                    <div class="card-body p-0">
                        <!--begin::Header-->
                        <div class="px-9 pt-7 card-rounded h-275px w-100 bg-info">
                            <!--begin::Heading-->
                            <div class="d-flex flex-stack">
                                <h3 class="m-0 text-white fw-bold fs-3">Blast Quota Balance</h3>
                            </div>
                            <!--end::Heading-->
                            <!--begin::Balance-->
                            <div class="d-flex text-center flex-column text-white pt-8">
                                <span class="fw-semibold fs-7">
                                    {{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y') }}
                                </span>
                                <span class="fw-bold fs-2x pt-1">
                                    {{ \Carbon\Carbon::now('Asia/Jakarta')->format('F') }}
                                </span>
                            </div>
                            <!--end::Balance-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Items-->
                        <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1"
                            style="margin-top: -100px">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-45px w-40px me-5">
                                    <span class="symbol-label bg-lighten">
                                        <span class="indicator-label">
                                            <i class="ki-duotone ki-whatsapp fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Description-->
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <!--begin::Title-->
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <span class="fs-5 text-gray-800 text-hover-primary fw-bold">WhatsApp</span>
                                        <div class="text-gray-500 fw-semibold fs-7" data-kt-countup="true"
                                            data-kt-countup-value="{{ $data_kuota_whatsapp['saldo'] }}">
                                            {{ $data_kuota_whatsapp['saldo'] }}
                                        </div>
                                        <span class="text-gray-500 fw-semibold fs-7">
                                            /{{ $data_kuota_whatsapp['total_kuota'] }}
                                        </span>
                                    </div>
                                    <!--end::Title-->
                                    <!--begin::Label-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Actions-->
                                        <a href="{{ route('dash.whatsapp.quota') }}"
                                            class="d-flex align-items-center text-primary opacity-75-hover fs-6 fw-semibold">
                                            View Detail
                                            <i class="ki-duotone ki-double-right fs-4 ms-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </a>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Description-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Items-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Post-->
</div>

@endsection