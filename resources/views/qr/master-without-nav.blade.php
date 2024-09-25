<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-layout-style="detached" data-sidebar="light" data-topbar="dark" data-sidebar-size="lg" data-sidebar-image="none"  data-preloader="disable">

    <head>
    <meta charset="utf-8" />
    <title>@yield('title') | Asenso Turismo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">

  </head>

  <body data-bs-spy="scroll" data-bs-target="#navbar-example">

    <section class="section" id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5" style="margin-bottom: 0px !important;">
                        <Br />
                        <h3 class="mb-3 fw-semibold">QR Code Scanner</h3>
                        <p class="text-muted mb-4 ff-secondary" style="padding-bottom: 0px !important;margin-bottom: 0px !important;">Click "Scan QR Code" to begin scanning. If asked for camera permission,click "Allow" or "Continue".</p>
                    </div>
                    <div class="card">
                     <div class="card-body text-center">
                                    <form id="qrCodeForm" method="POST" action="{{ route('qr.verify') }}">
                                    @csrf
                                    <input type="hidden" name="qrcode" id="qrcodeInput">
                                    <button class="btn btn-warning w-100" type="button" id="scanQrButton">Scan QR Code</button>
                                </form>
                                <div id="reader" style="width: 304px; height: 400px; display: none;"></div>
                                   {{--  <form id="qrCodeForm" method="POST" action="{{ route('qr.verify') }}">
                                    @csrf
                                        <input type="hidden" name="qrcode" id="qrcodeInput">
                                        <button class="btn btn-soft-success w-100" id="scanQrButton">Scan QR Code</button>
                                    </form>
                                    <div id="reader" style="width: 300px; height: 300px; display: none;"></div> --}}
                                </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row gy-4">
                <!-- end col -->
                <div class="col-lg-12">
                    <div>
                        <div class="col" id="captureDiv">
                            <div class="card">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>

    <script>
        const html5QrCode = new Html5Qrcode("reader");

        document.getElementById('scanQrButton').addEventListener('click', () => {
            // Show the QR code reader
            document.getElementById('reader').style.display = 'block';

            // Start scanning only when the button is clicked
            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                (decodedText, decodedResult) => {
                    // Set the value of the hidden input field
                    document.getElementById('qrcodeInput').value = decodedText;

                    // Stop scanning after a successful read
                    html5QrCode.stop();

                    // Submit the form to verify
                    document.getElementById('qrCodeForm').submit();

                    // Hide the reader
                    document.getElementById('reader').style.display = 'none';
                },
                (errorMessage) => {
                    // Handle scan error (optional)
                    console.error(errorMessage);
                }
            ).catch(err => {
                // Handle start failure
                console.error("Failed to start scanning:", err);
            });
        });
    </script>
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/landing.init.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </body>
</html>
