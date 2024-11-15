<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="" />
    <title>IFCA Software</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:title" content="IFCA Software" />
    <meta property="og:site_name" content="IFCA Software" />
    <link rel="shortcut icon" href="{{ url('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ url('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="auth-bg">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Body-->
            <div class="scroll-y flex-column-fluid px-1 py-1" data-kt-scroll="true" data-kt-scroll-activate="true"
                data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav"
                data-kt-scroll-offset="1px" data-kt-scroll-save-state="true"
                style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
                <!--begin::Email template-->
                <style>
                    html,
                    body {
                        padding: 0;
                        margin: 0;
                        font-family: Inter, Helvetica, "sans-serif";
                    }

                    a:hover {
                        color: #009ef7;
                    }
                </style>
                <div id="#kt_app_body_content"
                    style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
                    <div
                        style="background-color:#ffffff; padding: 35px 0 24px 0; border-radius: 22px; margin:40px auto; max-width: 600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
                            style="border-collapse:collapse">
                            <tbody>
                                <tr>
                                    <td align="center" valign="center" style="text-align:center; padding-bottom: 5px">
                                        <!--begin:Email content-->
                                        <div style="text-align:center; margin:0 60px 30px 50px">
                                            <!--begin:Text-->
                                            <div
                                                style="font-size: 14px; font-weight: 500; margin-bottom: 42px; font-family:Arial,Helvetica,sans-serif">
                                                <p
                                                    style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">
                                                    INVOICE BILL</p>
                                            </div>
                                            <!--end:Text-->
                                            <!--begin:Order-->
                                            <div style="margin-bottom: 15px">
                                                <!--begin:Title-->
                                                <h4
                                                    style="text-align:right; color:#181C32; font-size: 15px; font-weight:600; margin-bottom: 35px">
                                                    NO : {{ $doc_no }}</h4>
                                                <!--end:Title-->
                                                <!--begin:Items-->
                                                <div style="padding-bottom:9px">
                                                    <!--begin:Item-->
                                                    <div
                                                        style="display:flex; justify-content: start; color:#5a5b61; font-size: 14px; font-weight:600; margin-bottom:8px; gap: 10px;">
                                                        <!--begin:Description-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif;">
                                                            Debtor Name </div>
                                                        <!--end:Description-->
                                                        <!--begin:Description-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif;">
                                                            : </div>
                                                        <!--end:Description-->
                                                        <!--begin:Total-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif;">
                                                            {{ $name }}
                                                        </div>
                                                        <!--end:Total-->
                                                    </div>
                                                    <!--end:Item-->
                                                    <!--begin:Item-->
                                                    <div
                                                        style="display:flex; justify-content: start; color:#5a5b61; font-size: 14px; font-weight:600; margin-bottom:8px; gap: 10px;">
                                                        <!--begin:Description-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif">
                                                            Lot No </div>
                                                        <!--end:Description-->
                                                        <!--begin:Description-->
                                                        <div
                                                            style="font-family:Arial,Helvetica,sans-serif; margin-left:42px">
                                                            : </div>
                                                        <!--end:Description-->
                                                        <!--begin:Total-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif;">
                                                            {{ $lot_no }}
                                                        </div>
                                                        <!--end:Total-->
                                                    </div>
                                                    <!--end:Item-->
                                                    <!--begin:Item-->
                                                    <div
                                                        style="display:flex; justify-content: start; color:#5a5b61; font-size: 14px; font-weight:600; margin-bottom:50px; gap: 10px;">
                                                        <!--begin:Description-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif">
                                                            Descs </div>
                                                        <!--end:Description-->
                                                        <!--begin:Description-->
                                                        <div
                                                            style="font-family:Arial,Helvetica,sans-serif; margin-left:44px">
                                                            : </div>
                                                        <!--end:Description-->
                                                        <!--begin:Total-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif;">
                                                            {{ $descs }}
                                                        </div>
                                                        <!--end:Total-->
                                                    </div>
                                                    <!--end:Item-->
                                                    <!--begin:Item-->
                                                    <div
                                                        style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:700; margin-bottom:8px">
                                                        <!--begin:Description-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif">Amount</div>
                                                        <!--end:Description-->
                                                        <!--begin:Total-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif">{{ $amount }}
                                                        </div>
                                                        <!--end:Total-->
                                                    </div>
                                                    <!--end:Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed border-dark"
                                                        style="margin:15px 0"></div>
                                                    <!--end::Separator-->
                                                    <!--begin:Item-->
                                                    <div
                                                        style="display:flex; justify-content: space-between; color:#1e6dad; font-size: 14px; font-weight:700">
                                                        <!--begin:Description-->
                                                        <div style="font-family:Arial,Helvetica,sans-serif">Total
                                                            Payment
                                                        </div>
                                                        <!--end:Description-->
                                                        <!--begin:Total-->
                                                        <div
                                                            style="color:#1e6dad; font-weight:700; font-family:Arial,Helvetica,sans-serif">
                                                            {{ $amount }}</div>
                                                        <!--end:Total-->
                                                    </div>
                                                    <!--end:Item-->
                                                </div>
                                                <!--end:Items-->
                                            </div>
                                            <!--end:Order-->
                                            <!--begin:Action-->
                                            <a href="{{ $link }}" target="_blank"
                                                style="background-color:#1e6dad; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; margin-bottom: 30px;">Continue
                                                Payment</a>
                                            <!--begin:Action-->
                                            <div style="display:flex; justify-content: start; color:#5a5b61; font-size: 12px; font-weight:600">
                                            Note: The Payment Gateway's fee will be charged based on the payment method.
                                            </div>
                                        </div>
                                        <!--end:Email content-->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="center"
                                        style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                        <p>&copy; IFCA Software
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Email template-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
</body>
<!--end::Body-->

</html>