@php
    $repoUrl = 'https://github.com/andrea-lorusso/laravel-loco';
    $version = config('app.version');
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
        <main class="container py-5 text-center">
            <img
                src="{{ asset('laravel-loco-logo.png') }}"
                alt="{{ config('app.name') }} logo"
                class="welcome-logo d-block mx-auto mb-4"
                width="300"
                height="300"
            >

            <h1 class="display-5 fw-semibold mb-3">
                <span class="text-loco">&lt;</span>
                {{ config('app.name') }}
                <span class="text-loco">/&gt;</span>
            </h1>

            <p class="lead text-body-secondary mx-auto mb-4" style="max-width: 40rem;">
                <span class="text-loco fw-medium">Local Container</span> for Laravel development.
                A simple approach to spin up PHP, Laravel and Vite in Docker.
            </p>

            <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3 mb-4">
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

                <a href="{{ $repoUrl }}" target="_blank" rel="noopener" class="btn btn-lg btn-loco px-4 d-inline-flex align-items-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                    </svg>
                    View on GitHub
                </a>
            </div>

            <p class="text-body-secondary small mb-0">
                Currently <strong class="text-body">v{{ $version }}</strong>
                <span class="mx-2">·</span>
                <a href="{{ $repoUrl }}/blob/main/CHANGELOG.md" target="_blank" rel="noopener" class="link-secondary link-offset-2">Changelog</a>
                <span class="mx-2">·</span>
                <a href="{{ $repoUrl }}/releases" target="_blank" rel="noopener" class="link-secondary link-offset-2">Releases</a>
                <span class="mx-2">·</span>
                <a href="{{ $repoUrl }}#readme" target="_blank" rel="noopener" class="link-secondary link-offset-2">Docs</a>
            </p>
        </main>
    </body>
</html>
