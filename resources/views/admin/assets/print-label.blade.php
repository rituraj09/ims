<!DOCTYPE html>
<html>

<head>
    <title>Asset Label - {{ $asset->asset_tag }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .label-container {
            width: 90mm;
            min-height: 55mm;
            margin: auto;
            background: #fff;
            border: 2px solid #000;
            padding: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }

        .header h2 {
            font-size: 14px;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 10px;
        }

        .asset-tag {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .asset-name {
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .details {
            font-size: 10px;
            line-height: 1.6;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .qr-section {
            text-align: center;
            margin-top: 10px;
        }

        .footer {
            margin-top: 5px;
            text-align: center;
            font-size: 9px;
            color: #555;
        }

        .print-btn {
            text-align: center;
            margin-bottom: 15px;
        }

        @media print {

            body {
                background: #fff;
                padding: 0;
            }

            .print-btn {
                display: none;
            }

            .label-container {
                border: 1px solid #000;
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="print-btn">
        <button onclick="window.print()">
            Print Label
        </button>
    </div>

    <div class="label-container">

        <div class="header">
            <h2>{{ config('app.name') }}</h2>
            <p>Asset Management System</p>
        </div>

        <div class="asset-tag">
            {{ $asset->asset_tag }}
        </div>

        <div class="asset-name">
            {{ $asset->name }}
        </div>

        <div class="details">

            <div class="row">
                <span><strong>Category:</strong></span>
                <span>{{ $asset->category?->name }}</span>
            </div>

            @if ($asset->sub_category_name)
                <div class="row">
                    <span><strong>Sub Category:</strong></span>
                    <span>{{ $asset->sub_category_name }}</span>
                </div>
            @endif

            <div class="row">
                <span><strong>Brand:</strong></span>
                <span>{{ $asset->make_brand ?: '-' }}</span>
            </div>

            <div class="row">
                <span><strong>Model:</strong></span>
                <span>{{ $asset->model ?: '-' }}</span>
            </div>

            <div class="row">
                <span><strong>Serial:</strong></span>
                <span>{{ $asset->serial_no ?: '-' }}</span>
            </div>

        </div>

        <div class="qr-section">

            {!! QrCode::size(100)->generate(route('admin.assets.show', $asset->id)) !!}

        </div>

        <div class="footer">
            Scan QR Code to view asset details
        </div>

    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>
