{{-- resources/views/admin/ip-allocation/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Allocation Form - {{ $allocation->ipAddress->ip_address }}</title>

    <style>
        /* Base Styles */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        /* A4 Page Setup */
        .document-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px 50px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Header */
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            color: #1e3a8a;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #6b7280;
        }

        /* Action Buttons (Hidden on Print) */
        .action-bar {
            max-width: 800px;
            margin: 0 auto 15px auto;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-print { background: #2563eb; color: white; }
        .btn-back { background: #e5e7eb; color: #374151; }

        /* Tables */
        .section-title {
            background-color: #f3f4f6;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 14px;
            border-left: 4px solid #2563eb;
            margin: 20px 0 10px 0;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            font-size: 14px;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            width: 35%;
            color: #4b5563;
        }

        /* Terms and Conditions */
        .terms {
            font-size: 12px;
            line-height: 1.6;
            color: #4b5563;
            margin-bottom: 40px;
        }
        .terms ul {
            padding-left: 20px;
            margin-top: 5px;
        }

        /* Signatures */
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .sign-box {
            width: 45%;
        }
        .sign-line {
            border-bottom: 1px solid #374151;
            height: 60px;
            margin-bottom: 5px;
        }
        .sign-label {
            font-size: 14px;
            font-weight: bold;
            color: #111827;
        }
        .sign-sub {
            font-size: 12px;
            color: #6b7280;
        }

        /* Print Specific CSS */
        @media print {
            body { background: white; padding: 0; }
            .document-container { box-shadow: none; padding: 0; max-width: 100%; margin: 0; }
            .action-bar, .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="action-bar no-print">
        {{-- <a href="javascript:history.back()" class="btn btn-back">← Back</a> --}}
        <button onclick="window.print()" class="btn btn-print">🖨️ Print Form</button>
    </div>

    <div class="document-container">

        <div class="header">
            <h1>IP Address Allocation & Acknowledgment</h1>
            <p>{{ \App\Models\Setting::get('general.company_name') ?? config('app.name') }} - IT Department</p>
            <p>Document Ref: <strong>IP-ALLOC-{{ str_pad($allocation->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
        </div>

        <div class="section-title">User Information</div>
        <table>
            <tbody>
                <tr>
                    <th>Employee Name</th>
                    <td>{{ $allocation->user->name }}</td>
                </tr>
                <tr>
                    <th>Employee ID / Email</th>
                    <td>{{ $allocation->user->email }}</td>
                </tr>
                <tr>
                    <th>Department / Designation</th>
                    <td>{{ $allocation->user->department?->name ?? 'N/A' }} / {{ $allocation->user->designation ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Network & Device Configuration</div>
        <table>
            <tbody>
                <tr>
                    <th>Allocated IP Address</th>
                    <td><strong>{{ $allocation->ipAddress->ip_address }}</strong> ({{ $allocation->ipAddress->network_type }})</td>
                </tr>
                <tr>
                    <th>Subnet Mask / Gateway</th>
                    <td>{{ $allocation->ipAddress->subnet_mask ?? 'Default' }} / {{ $allocation->ipAddress->gateway ?? 'Default' }}</td>
                </tr>
                <tr>
                    <th>MAC Address (Ethernet)</th>
                    <td>{{ $allocation->ethernet_mac ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <th>MAC Address (WiFi)</th>
                    <td>{{ $allocation->wifi_mac ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Device Name / Type</th>
                    <td>{{ $allocation->device_name ?: 'N/A' }} / {{ $allocation->device_type ?: 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Allocation Date</th>
                    <td>{{ $allocation->date_allocated ? $allocation->date_allocated->format('d F Y') : date('d F Y') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Acceptable Use Policy (AUP)</div>
        <div class="terms">
            By signing this document, the recipient agrees to the following terms and conditions regarding the allocated IP address and network access:
            <ul>
                <li>The assigned IP address is for official company business only and must not be used on unauthorized personal devices.</li>
                <li>The user shall not attempt to change, modify, or spoof the IP address or MAC address provided in this document.</li>
                <li>The user is responsible for all network traffic originating from this IP address.</li>
                <li>The IT Department reserves the right to monitor network activity, revoke this IP allocation, or reassign it at any time without prior notice.</li>
                <li>Any violation of these terms may result in immediate revocation of network privileges and disciplinary action.</li>
            </ul>
        </div>

        <div class="signatures">
            <div class="sign-box">
                <div class="sign-line"></div>
                <div class="sign-label">Employee Signature</div>
                <div class="sign-sub">Name: {{ $allocation->user->name }}</div>
                <div class="sign-sub">Date: ________________________</div>
            </div>

            <div class="sign-box">
                <div class="sign-line"></div>
                <div class="sign-label">IT Administrator / Authorized Signatory</div>
                <div class="sign-sub">Name: {{ $allocation->allocatedBy?->name ?? auth()->user()->name }}</div>
                <div class="sign-sub">Date: ________________________</div>
            </div>
        </div>

    </div>

</body>
</html>
