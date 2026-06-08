{{-- resources/views/admin/ip-addresses/_form.blade.php --}}
{{-- Reused inside both #addIpModal and #editIpModal --}}
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">IP Address <span class="text-danger">*</span></label>
        <input type="text" name="ip_address" class="form-control @error('ip_address') is-invalid @enderror"
               placeholder="e.g. 192.168.1.100" value="{{ old('ip_address') }}" required>
        @error('ip_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Subnet Mask</label>
        <input type="text" name="subnet_mask" class="form-control @error('subnet_mask') is-invalid @enderror"
               placeholder="e.g. 255.255.255.0" value="{{ old('subnet_mask') }}">
        @error('subnet_mask')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Gateway</label>
        <input type="text" name="gateway" class="form-control @error('gateway') is-invalid @enderror"
               placeholder="e.g. 192.168.1.1" value="{{ old('gateway') }}">
        @error('gateway')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Network Type <span class="text-danger">*</span></label>
        <select name="network_type" class="form-select @error('network_type') is-invalid @enderror" required>
            <option value="LAN">LAN</option>
            <option value="WAN">WAN</option>
            <option value="WiFi">WiFi</option>
            <option value="VPN">VPN</option>
        </select>
        @error('network_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Primary DNS</label>
        <input type="text" name="dns_primary" class="form-control @error('dns_primary') is-invalid @enderror"
               placeholder="e.g. 8.8.8.8" value="{{ old('dns_primary') }}">
        @error('dns_primary')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Secondary DNS</label>
        <input type="text" name="dns_secondary" class="form-control @error('dns_secondary') is-invalid @enderror"
               placeholder="e.g. 8.8.4.4" value="{{ old('dns_secondary') }}">
        @error('dns_secondary')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">VLAN</label>
        <input type="text" name="vlan" class="form-control" placeholder="e.g. VLAN10" value="{{ old('vlan') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="available">Available</option>
            <option value="reserved">Reserved</option>
            <option value="decommissioned">Decommissioned</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea name="description" class="form-control" rows="2"
                  placeholder="Optional note…">{{ old('description') }}</textarea>
    </div>
</div>
