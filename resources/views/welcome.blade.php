<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sulteng Lapor Jalan</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[#1f241f] antialiased">
        <div class="min-h-screen bg-[#eef1e7]">
            <section class="relative min-h-[84vh] overflow-hidden bg-[#111611] text-white">
                <img src="{{ asset('images/road-report-hero.png') }}" alt="Warga mendokumentasikan jalan rusak" class="absolute inset-0 h-full w-full object-cover">
                <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(15,18,14,0.96)_0%,rgba(15,18,14,0.78)_42%,rgba(15,18,14,0.28)_100%)]"></div>
                <div class="absolute inset-x-0 top-0 z-10 border-b border-white/10 bg-[#111611]/45 backdrop-blur">
                    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                        <a href="{{ url('/') }}" class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-md bg-[#f2b84b] text-[#171c15]">
                                <x-application-logo class="h-6 w-6" />
                            </span>
                            <span class="font-semibold">Sulteng Lapor Jalan</span>
                        </a>

                        @if (Route::has('login'))
                            <nav class="flex items-center gap-3 text-sm font-semibold">
                                @auth
                                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="rounded-md border border-white/20 px-4 py-2 text-white hover:bg-white/10">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="rounded-md px-4 py-2 text-white/85 hover:bg-white/10 hover:text-white">Masuk</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="rounded-md bg-[#f2b84b] px-4 py-2 text-[#171c15] hover:bg-[#ffd36d]">Daftar</a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </div>
                </div>

                <div class="relative z-10 mx-auto flex min-h-[84vh] max-w-7xl items-center px-6 pb-16 pt-28 lg:px-8">
                    <div class="max-w-2xl">
                        <p class="mb-4 inline-flex rounded-md border border-[#f2b84b]/40 bg-[#f2b84b]/10 px-3 py-1 text-sm font-semibold text-[#ffd36d]">Smart Mobility Sulawesi Tengah</p>
                        <h1 class="text-4xl font-extrabold leading-tight tracking-normal sm:text-5xl lg:text-6xl">Sulteng Lapor Jalan</h1>
                        <p class="mt-5 max-w-xl text-lg leading-8 text-white/82">Pelaporan jalan rusak yang cepat, rapi, dan mudah dipantau agar titik kerusakan bisa ditindaklanjuti dengan data yang jelas.</p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            @auth
                                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('reports.create') }}" class="inline-flex items-center justify-center rounded-md bg-[#f2b84b] px-5 py-3 text-sm font-bold text-[#171c15] hover:bg-[#ffd36d]">Mulai dari Dashboard</a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md bg-[#f2b84b] px-5 py-3 text-sm font-bold text-[#171c15] hover:bg-[#ffd36d]">Laporkan Jalan Rusak</a>
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md border border-white/25 px-5 py-3 text-sm font-bold text-white hover:bg-white/10">Masuk Akun</a>
                            @endauth
                        </div>

                        <div class="mt-10 grid max-w-xl grid-cols-3 gap-3">
                            <div class="rounded-md border border-white/12 bg-white/8 p-4">
                                <p class="text-2xl font-bold text-[#ffd36d]">24/7</p>
                                <p class="mt-1 text-xs font-medium uppercase tracking-normal text-white/65">Kirim laporan</p>
                            </div>
                            <div class="rounded-md border border-white/12 bg-white/8 p-4">
                                <p class="text-2xl font-bold text-[#ffd36d]">5</p>
                                <p class="mt-1 text-xs font-medium uppercase tracking-normal text-white/65">Status proses</p>
                            </div>
                            <div class="rounded-md border border-white/12 bg-white/8 p-4">
                                <p class="text-2xl font-bold text-[#ffd36d]">13</p>
                                <p class="mt-1 text-xs font-medium uppercase tracking-normal text-white/65">Wilayah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="border-b border-[#d9dfcf] bg-[#eef1e7] px-6 py-12 lg:px-8">
                <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-3">
                    <div class="rounded-md border border-[#d7dccd] bg-white/85 p-6 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-normal text-[#7a5b16]">01</p>
                        <h2 class="mt-3 text-lg font-bold text-[#1f241f]">Kirim bukti lokasi</h2>
                        <p class="mt-2 text-sm leading-6 text-[#5c6358]">Masyarakat mengisi lokasi, jenis kerusakan, tingkat kerusakan, tautan Maps, dan foto jalan.</p>
                    </div>
                    <div class="rounded-md border border-[#d7dccd] bg-white/85 p-6 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-normal text-[#7a5b16]">02</p>
                        <h2 class="mt-3 text-lg font-bold text-[#1f241f]">Admin memverifikasi</h2>
                        <p class="mt-2 text-sm leading-6 text-[#5c6358]">Admin melihat detail laporan, menilai prioritas, lalu memberi status dan catatan.</p>
                    </div>
                    <div class="rounded-md border border-[#d7dccd] bg-white/85 p-6 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-normal text-[#7a5b16]">03</p>
                        <h2 class="mt-3 text-lg font-bold text-[#1f241f]">Status bisa dipantau</h2>
                        <p class="mt-2 text-sm leading-6 text-[#5c6358]">Pelapor dapat melihat perkembangan laporan dari diterima sampai selesai atau ditolak.</p>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>
