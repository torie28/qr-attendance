<!DOCTYPE html>
<html>
<head>
    <title>QR Code Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Test QR Code
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ route('qr.test') }}" alt="QR Code" class="img-fluid">
                        <p class="mt-3">This is a test QR code</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>