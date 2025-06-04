<!DOCTYPE html>
<html>

<head>
    <title>Certificate of Completion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: 'Georgia', serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .certificate {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 40px 30px;
            margin: 0 auto;
            max-width: 800px;
            background-color: #fff;
            border: 10px double #0d6efd;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 36px;
            color: #0d6efd;
            margin: 10px 0;
        }

        .subtitle {
            font-size: 18px;
            color: #555;
            margin-top: 10px;
        }

        .recipient {
            font-size: 28px;
            font-weight: bold;
            margin: 12px 0 20px;
            color: #222;
        }

        h3 {
            font-size: 22px;
            color: #333;
            margin: 10px 0;
        }

        .info {
            font-size: 16px;
            margin: 8px 0;
            color: #444;
        }

        .signature-section {
            display: flex;
            justify-content: center;
            /* or space-between, space-around */
            align-items: flex-start;
            flex-wrap: wrap;
            /* ensures responsive fallback */
            gap: 50px;
            /* spacing between signatures */
            margin-top: 30px;
        }
        .sign-label {
            margin-top: 8px;
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        @media print {
            body {
                background: none;
            }

            .certificate {
                box-shadow: none;
                border-width: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="certificate">
        <img src="images/logo.png" alt="Logo" class="logo">
        <h1>Certificate of Completion</h1>
        <div class="subtitle">This is to certify that</div>
        <div class="recipient">{{ $certificate->students->Name }}</div>
        <div class="subtitle">has successfully completed the course</div>
        <h3>{{ $certificate->courses->Course_Name }}</h3>
        <div class="info">Under the guidance of: <strong>{{ $certificate->users->name }}</strong></div>
        <div class="info">Date: {{ \Carbon\Carbon::now()->format('F d, Y') }}</div>
        <div class="info">Institute Name: Learn Hub</div>
        <div class="container mt-1">
            <div class="row justify-content-center">
                <div class="text-center">
                    @if ($certificate->users->profile_photo_path)
                    <img src="{{ public_path('storage/' . $certificate->users->profile_photo_path) }}" style="width: 100px; height: 100px; object-fit: cover;">
                    @else    
                    <img src="images/sign.png" alt="Instructor Signature" class="img-fluid" style="width: 40px; height: 40px; object-fit: cover;">
                    @endif
                    <div class="sign-label">Instructor Profile Image</div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
