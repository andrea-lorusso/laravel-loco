@php
    $repoUrl = 'https://github.com/andrea-lorusso/laravel-loco';
    $version = config('app.version');

    try {
        $mysqlVersion = \Illuminate\Support\Facades\DB::connection()->getServerVersion();
    } catch (\Throwable) {
        $mysqlVersion = null;
    }

    try {
        $redisInfo = \Illuminate\Support\Facades\Redis::connection()->info('server');
        $redisVersion = $redisInfo['redis_version'] ?? $redisInfo['Server']['redis_version'] ?? null;
    } catch (\Throwable) {
        $redisVersion = null;
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
        <link rel="manifest" href="/site.webmanifest" />

        @fonts

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="welcome d-flex align-items-center min-vh-100">
        <main class="container py-5">
            <div class="row align-items-center justify-content-center g-5">
                <div class="col-lg-7 order-2 order-lg-1 text-center text-lg-start">
                    <h1 class="display-4 fw-semibold mb-3">
                        <span class="text-loco">&lt;</span>
                        {{ config('app.name') }}
                        <span class="text-loco">/&gt;</span>
                    </h1>

                    {{-- <p class="lead text-body-secondary mx-auto mx-lg-0 mb-4"> --}}
                        <blockquote class="blockquote lead">
                            <span class="text-loco fw-medium">Local Container</span> for Laravel development.
                        </blockquote>
                        <figcaption class="blockquote-footer">
                            A simple approach to spin up PHP, Laravel and Vite in Docker.
                        </figcaption>
                    {{-- </p> --}}

                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start align-items-center gap-3 mb-4">
                        <div class="welcome-clone d-flex align-items-center gap-2 border rounded-3 bg-body px-3 py-2 font-monospace small">
                            <span class="text-body-secondary user-select-none">$</span>
                            <code id="clone-cmd" class="text-body">git clone {{ $repoUrl }}.git</code>
                            <button
                                type="button"
                                class="btn btn-sm btn-link link-secondary p-0 ms-1"
                                title="Copy"
                                onclick="navigator.clipboard.writeText(document.getElementById('clone-cmd').innerText).then(() => { this.textContent = '✓'; setTimeout(() => this.innerHTML = this.dataset.icon, 1500); })"
                                data-icon='<svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/></svg>'
                            ><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/></svg></button>
                        </div>

                        <a href="{{ $repoUrl }}" target="_blank" rel="noopener" class="btn btn-loco px-3 d-inline-flex align-items-center gap-2 flex-shrink-0">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                            </svg>
                            View on GitHub
                        </a>
                    </div>

                    <ul class="small" style="width: fit-content;">
                        <li>Currently <strong class="text-body float-end ms-4">v{{ $version }}</strong></li>
                        <li>PHP <strong class="text-body float-end ms-4">{{ PHP_VERSION }}</strong></li>
                        <li>MySQL <strong class="text-body float-end ms-4">{{ $mysqlVersion ?? 'n/a' }}</strong></li>
                        <li>Redis <strong class="text-body float-end ms-4">{{ $redisVersion ?? 'n/a' }}</strong></li>
                    </ul>

                    <p class="text-body-secondary small mb-0">
                    {{--

                        Currently <strong class="text-body">v{{ $version }}</strong>
                        <span class="mx-2">·</span>
                        PHP <strong class="text-body">{{ PHP_VERSION }}</strong>
                        <span class="mx-2">·</span>
                        MySQL <strong class="text-body">{{ $mysqlVersion ?? 'n/a' }}</strong>
                        <span class="mx-2">·</span>
                        Redis <strong class="text-body">{{ $redisVersion ?? 'n/a' }}</strong>
                        <span class="mx-2">·</span>
                    --}}

                        <a href="{{ $repoUrl }}/blob/main/CHANGELOG.md" target="_blank" rel="noopener" class="icon-link link-secondary link-offset-2">Changelog <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0z"/></a>
                        <span class="mx-2">·</span>
                        <a href="{{ $repoUrl }}/releases" target="_blank" rel="noopener" class="icon-link link-secondary link-offset-2">Releases <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0z"/></a>
                        <span class="mx-2">·</span>
                        <a href="{{ $repoUrl }}#readme" target="_blank" rel="noopener" class="icon-link link-secondary link-offset-2">Docs <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0z"/>
</svg></a>
                    </p>
                </div>

                <div class="col-lg-5 order-1 order-lg-2 text-center p-0">
                    <img
                        src="{{ asset('laravel-loco-logo.png') }}"
                        alt="{{ config('app.name') }} logo"
                        class="welcome-logo img-fluid"
                    >
                </div>
            </div>
        </main>
    </body>
</html>
