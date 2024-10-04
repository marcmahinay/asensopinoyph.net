<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>

    <!-- Import the HTML5 QR Code library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        #qr-reader {
            width: 100%;
            max-width: 500px;
            margin: 0 auto 10px auto;

        }

        #qr-result {
            word-wrap: break-word;
            /* Allow long words to break and wrap */
            white-space: normal;
            /* Ensure text wraps normally */
        }

        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
            padding: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            font-family: Arial, sans-serif;
        }

        .alert-success strong {
            font-weight: bold;
        }

        .alert-success b {
            font-weight: bold;
        }

        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
            padding: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            font-family: Arial, sans-serif;
        }

        .alert-danger strong {
            font-weight: bold;
        }

        .alert-danger b {
            font-weight: bold;
        }

        .custom-card {
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            font-family: Arial, sans-serif;
        }

        .custom-card-header {
            background-color: #f8f9fa;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #ddd;
        }

        .custom-card-title {
            margin-bottom: 0;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .custom-card-body {
            padding: 1.25rem;
        }

        .custom-card-text {
            margin-bottom: 0.5rem;
            color: #6c757d;
        }

        .custom-card-img {
            width: 100%;
            height: auto;
        }

        .custom-card-footer {
            background-color: #f8f9fa;
            padding: 0.75rem 1.25rem;
            border-top: 1px solid #ddd;
        }

        .mb-0 {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <audio id="scan-sound" src="{{ asset('beep8333.mp3') }}" preload="auto"></audio>
    <section style="padding:0 20px 20px;">
        <div id="event" style="text-align: center;margin-top:5px; padding: 10px; margin-bottom:5px;">
            Event Name: {{ $event->event_name }}
        </div>
        <div id="qr-reader"></div>
        <div id="qr-result" style="text-align: center; margin-top:10px;">No QR code scanned yet</div>
    </section>

    {{-- <div class="custom-card">
        <div class="custom-card-header">
            <h4 class="custom-card-title mb-0">A day in the life of a professional fashion designer</h4>
        </div>

            <div id="qr-reader"></div>



        <div id="qr-result" class="custom-card-footer">
            <p class="card-text mb-0">No QR code scanned yet</p>
        </div>

    </div> --}}



    <script>
        let html5QrcodeScanner = new Html5Qrcode("qr-reader");
        // Function to handle the success of the QR code scan
        function onScanSuccess(decodedText, decodedResult) {
            // Handle the result here
            document.getElementById('scan-sound').play();
            document.getElementById('qr-result').classList.remove('alert-success', 'alert-danger');
            document.getElementById('qr-result').innerHTML = `<div>${decodedText}</div>`;

            fetch('/scan-qr-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
                    },
                    body: JSON.stringify({
                        qrCode: decodedText,
                        event_id: {{ $event->id }}
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Handle the response data
                    if (data.name) data.name = `${data.name} <br>`
                    else data.name = '';
                    document.getElementById('qr-result').innerHTML = data.name + `${data.message}`;
                    document.getElementById('qr-result').className = data.success ? 'alert-success' : 'alert-danger';
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Function to handle the error of the QR code scan

        function onScanError(errorMessage) {
            console.warn(`QR Code scan error: ${errorMessage}`);
        }
        /*

            // Initialize the QR Code reader
            let html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", {
                    fps: 1,
                    qrbox: 250,
                }, // fps = frames per second
            );
            html5QrcodeScanner.render(onScanSuccess, onScanError); */

        html5QrcodeScanner.start({
                facingMode: "environment"
            }, {
                fps: 1,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            (decodedText, decodedResult) => {
                // Set the value of the hidden input field
                onScanSuccess(decodedText, decodedResult);

            },
            (errorMessage) => {
                // Handle scan error (optional)
                console.error(errorMessage);
            }
        ).catch(err => {
            // Handle start failure
            console.error("Failed to start scanning:", err);
        });
    </script>

</body>

</html>
