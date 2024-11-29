<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-gray-900 order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">{{ now()->year }} &copy;</span>
            <a href="http://id.ifca.co.id/" target="_blank" class="text-gray-800 text-hover-primary">IFCA
                Software</a>
        </div>
        <!--end::Copyright-->

        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <li class="menu-item">
                @if (env('PAYMENT_MODE_GAK') == 'sandbox')
                <span class="badge py-3 px-2 fs-7 badge-light-warning">SANDBOX MODE</span>
                @else
                <span class="menu-link px-2">
                    <span class="badge py-3 px-2 fs-7 badge-light-primary">PRODUCTION MODE</span>
                </span>
                @endif
            </li>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Container-->
</div>