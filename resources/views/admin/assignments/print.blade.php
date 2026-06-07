{{-- resources/views/admin/assignments/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ strtoupper($assignment->transaction_type) }} Form - {{ $assignment->form_no }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #000;
            background: #fff;
        }

        .page {
            max-width: 210mm;
            margin: 0 auto;
            padding: 15mm;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 14px;
            gap: 14px;
        }

        .header-logo {
            width: 70px;
            height: 70px;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            border-radius: 50%;
        }

        .header-text {
            flex: 1;
        }

        .header-org {
            font-size: 14px;
            font-weight: 700;
        }

        .header-dept {
            font-size: 12px;
            color: #444;
        }

        .header-form {
            text-align: right;
        }

        .form-no {
            font-size: 14px;
            font-weight: 700;
            background: #000;
            color: #fff;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .form-date {
            font-size: 11px;
            color: #555;
            margin-top: 4px;
        }

        /* Title */
        .form-title {
            text-align: center;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 2px solid #000;
            padding: 8px;
            margin-bottom: 14px;
            background: #f5f5f5;
        }

        /* Section */
        .section {
            margin-bottom: 14px;
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: #e0e0e0;
            padding: 4px 8px;
            border-left: 3px solid #000;
            margin-bottom: 6px;
        }

        /* Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 8px;
            border: 1px solid #ccc;
            font-size: 12px;
        }

        .info-table td:first-child {
            font-weight: 700;
            width: 35%;
            background: #f9f9f9;
        }

        .info-table .val {
            font-size: 12px;
        }

        /* Two columns */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        /* Condition checklist */
        .condition-list {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .condition-item {
            border: 1px solid #ccc;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
        }

        .condition-item.selected {
            background: #000;
            color: #fff;
            border-color: #000;
            font-weight: 700;
        }

        /* Remarks */
        .remarks-box {
            border: 1px solid #ccc;
            min-height: 50px;
            padding: 6px;
        }

        /* Signature */
        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 14px;
            margin-top: 20px;
        }

        .sig-box {
            border: 1px solid #ccc;
            padding: 10px;
        }

        .sig-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 4px;
            font-size: 10px;
            text-align: center;
        }

        .sig-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 4px;
            color: #444;
        }

        .sig-name {
            font-size: 11px;
            font-weight: 700;
        }

        .sig-desig {
            font-size: 10px;
            color: #555;
        }

        /* Footer */
        .form-footer {
            border-top: 1px dashed #999;
            margin-top: 16px;
            padding-top: 8px;
            font-size: 10px;
            color: #777;
            display: flex;
            justify-content: space-between;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                padding: 0;
            }

            .page {
                padding: 8mm;
            }
        }
    </style>
</head>

<body>

    {{-- Print Button --}}
    <div class="no-print" style="background:#1a1f2e;padding:10px 20px;display:flex;gap:10px;align-items:center;">
        <button onclick="window.print()"
            style="background:#3b82f6;color:#fff;border:none;padding:8px 20px;border-radius:6px;cursor:pointer;font-size:14px;">
            <i>🖨</i> Print Form
        </button>
        <button onclick="window.close()"
            style="background:transparent;color:#fff;border:1px solid #555;padding:8px 20px;border-radius:6px;cursor:pointer;font-size:14px;">
            Close
        </button>
        <span style="color:#aaa;font-size:13px;margin-left:10px;">Form No: {{ $assignment->form_no }}</span>
    </div>

    <div class="page">

        {{-- Header --}}
        <div class="header">
            <div class="header-logo">🏛</div>
            <div class="header-text">
                <div class="header-org">Government of Assam</div>
                <div class="header-dept">Asset Management Division</div>
                <div style="font-size:11px;color:#666;margin-top:2px;">
                    Asset Handover / Takeover / Transfer Form
                </div>
            </div>
            <div class="header-form">
                <div class="form-no">{{ $assignment->form_no }}</div>
                <div class="form-date">Date: {{ $assignment->transaction_date->format('d/m/Y') }}</div>
            </div>
        </div>

        {{-- Title --}}
        <div class="form-title">
            @if ($assignment->transaction_type === 'handover')
                Asset Handover Form
            @elseif($assignment->transaction_type === 'takeover')
                Asset Takeover Form
            @elseif($assignment->transaction_type === 'transfer')
                Asset Transfer Form
            @else
                {{ ucfirst($assignment->transaction_type) }} Form
            @endif
        </div>

        {{-- Asset Details --}}
        <div class="section">
            <div class="section-title">Asset Details</div>
            <table class="info-table">
                <tr>
                    <td>Asset Tag</td>
                    <td class="val"><strong>{{ $assignment->asset->asset_tag }}</strong></td>
                    <td>Asset Name</td>
                    <td class="val">{{ $assignment->asset->name }}</td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td class="val">{{ $assignment->asset->category?->name }}</td>
                    <td>Sub-Category</td>
                    <td class="val">{{ $assignment->asset->sub_category_name ?? '—' }}</td>
                </tr>
                <tr>
                    <td>Make / Brand</td>
                    <td class="val">{{ $assignment->asset->make_brand ?? '—' }}</td>
                    <td>Model</td>
                    <td class="val">{{ $assignment->asset->model ?? '—' }}</td>
                </tr>
                <tr>
                    <td>Serial No.</td>
                    <td class="val">{{ $assignment->asset->serial_no ?? '—' }}</td>
                    <td>Condition</td>
                    <td class="val">
                        <div class="condition-list">
                            @foreach (['new', 'good', 'fair', 'poor', 'condemned'] as $cond)
                                <span
                                    class="condition-item {{ $assignment->condition_at_handover === $cond ? 'selected' : '' }}">
                                    {{ ucfirst($cond) }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Purchase Price</td>
                    <td class="val">
                        {{ $assignment->asset->purchase_price ? '₹ ' . number_format($assignment->asset->purchase_price, 2) : '—' }}
                    </td>
                    <td>Current Value</td>
                    <td class="val">
                        {{ $assignment->asset->current_value ? '₹ ' . number_format($assignment->asset->current_value, 2) : '—' }}
                    </td>
                </tr>
            </table>
        </div>

        {{-- From / To --}}
        <div class="two-col">
            <div class="section">
                <div class="section-title">Handover From</div>
                <table class="info-table">
                    <tr>
                        <td>Type</td>
                        <td>{{ ucfirst($assignment->from_type ?? 'Store') }}</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><strong>{{ $assignment->from_holder_name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td>
                            @if ($assignment->from_location_building)
                                {{ $assignment->from_location_building }}
                            @endif
                            @if ($assignment->from_location_floor)
                                , Floor {{ $assignment->from_location_floor }}
                            @endif
                            @if ($assignment->from_location_room_no)
                                , Room {{ $assignment->from_location_room_no }}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="section">
                <div class="section-title">Handover To</div>
                <table class="info-table">
                    <tr>
                        <td>Type</td>
                        <td>{{ ucfirst($assignment->to_type ?? '—') }}</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><strong>{{ $assignment->to_holder_name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td>
                            @if ($assignment->to_location_building)
                                {{ $assignment->to_location_building }}
                            @endif
                            @if ($assignment->to_location_floor)
                                , Floor {{ $assignment->to_location_floor }}
                            @endif
                            @if ($assignment->to_location_room_no)
                                , Room {{ $assignment->to_location_room_no }}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Remarks --}}
        <div class="section">
            <div class="section-title">Remarks / Notes</div>
            <div class="remarks-box">{{ $assignment->remarks ?? '' }}</div>
        </div>

        {{-- Signature Section --}}
        <div class="section">
            <div class="section-title">Signatures</div>
            <div class="signature-section">

                {{-- Handed Over By --}}
                <div class="sig-box">
                    <div class="sig-title">Handed Over By</div>
                    <div class="sig-name">{{ $assignment->from_holder_name }}</div>
                    <div class="sig-desig">
                        @if ($assignment->fromEmployee?->designation)
                            {{ $assignment->fromEmployee->designation->name }}
                        @endif
                    </div>
                    <div class="sig-line">Signature & Date</div>
                </div>

                {{-- Received By --}}
                <div class="sig-box">
                    <div class="sig-title">Received By</div>
                    <div class="sig-name">{{ $assignment->to_holder_name }}</div>
                    <div class="sig-desig">
                        @if ($assignment->toEmployee?->designation)
                            {{ $assignment->toEmployee->designation->name }}
                        @endif
                    </div>
                    <div class="sig-line">Signature & Date</div>
                </div>

                {{-- Authorized By --}}
                <div class="sig-box">
                    <div class="sig-title">Authorized By</div>
                    <div class="sig-name">{{ $assignment->authorizedBy?->name ?? '________________' }}</div>
                    <div class="sig-desig">Authorized Signatory</div>
                    <div class="sig-line">Signature & Stamp</div>
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="form-footer">
            <span>Form No: {{ $assignment->form_no }} | Generated: {{ now()->format('d/m/Y H:i') }}</span>
            <span>This is a computer-generated document | Government Asset Management System</span>
        </div>

    </div>

    <script>
        // Auto print on load if ?print=1
        if (new URLSearchParams(window.location.search).get('print') === '1') {
            window.print();
        }
    </script>
</body>

</html>
