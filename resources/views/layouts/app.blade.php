{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Government Asset Management System">
    <title>@yield('title', 'Dashboard') | GovAsset Manager</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Styles Component --}}
    <x-layout.styles />

    @stack('styles')
</head>
<body>

<div class="app-layout">

    {{-- Sidebar Component --}}
    <x-layout.sidebar />

    {{-- Sidebar Overlay --}}
    <div class="sb-overlay" id="sbOverlay"></div>

    {{-- Main Content --}}
    <div class="main-wrap" id="mainWrap">

        {{-- Header Component --}}
        <x-layout.header>
            @yield('breadcrumb')
        </x-layout.header>

        {{-- Page Body --}}
        <main class="page-body">

            {{-- Page Header --}}
            @hasSection('page-title')
            <div class="page-hdr">
                <div>
                    <h1 class="page-title">@yield('page-title')</h1>
                    @hasSection('page-subtitle')
                    <p class="page-subtitle mb-0">@yield('page-subtitle')</p>
                    @endif
                </div>
                @hasSection('page-actions')
                <div class="page-actions">
                    @yield('page-actions')
                </div>
                @endif
            </div>
            @endif

            {{-- Flash Alerts --}}
            @foreach([
                'success' => ['success', 'circle-check'],
                'error'   => ['danger',  'circle-xmark'],
                'warning' => ['warning', 'triangle-exclamation'],
                'info'    => ['info',    'circle-info'],
            ] as $type => [$cls, $ico])
                @if(session($type))
                <div class="alert alert-{{ $cls }} alert-dismissible fade show
                            d-flex align-items-center gap-2 mb-3"
                     role="alert">
                    <i class="fas fa-{{ $ico }} flex-shrink-0"></i>
                    <div class="flex-grow-1">{{ session($type) }}</div>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            @endforeach

            {{-- Validation Errors --}}
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3"
                 role="alert">
                <div class="d-flex gap-2">
                    <i class="fas fa-triangle-exclamation flex-shrink-0 mt-1"></i>
                    <div>
                        <strong class="d-block mb-1">
                            Please fix the following errors:
                        </strong>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Page Content --}}
            @yield('content')

        </main>

        {{-- Footer Component --}}
        <x-layout.footer />

    </div>
</div>

{{-- Scripts Component --}}
<x-layout.scripts />

@stack('scripts')
</body>
</html>
