<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sulteng Lapor Jalan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Leaflet Map CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Leaflet Map JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <!-- Lucide Icons JS -->
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="font-sans antialiased text-[#1a1e1b] bg-[#fafafa]">
        <div x-data="globalAppHandler()" x-init="init()" class="relative min-h-screen app-surface">
            <!-- Global Loading Overlay -->
            <div x-show="isLoading" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/70 backdrop-blur-md"
                 style="display: none;"
            >
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-12 h-12 border-4 border-[#ff5e00] border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-xs font-bold text-[#ff5e00] tracking-wider uppercase" x-text="loadingText">Memuat...</p>
                </div>
            </div>

            <!-- Global Toast Notification -->
            <div class="fixed bottom-5 right-5 z-[9999] space-y-2.5 pointer-events-none">
                <template x-for="toast in toasts" :key="toast.id">
                    <div x-show="toast.show"
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="translate-y-4 opacity-0 scale-95"
                         x-transition:enter-end="translate-y-0 opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200 transform"
                         x-transition:leave-start="translate-y-0 opacity-100 scale-100"
                         x-transition:leave-end="translate-y-4 opacity-0 scale-95"
                         class="pointer-events-auto flex items-center p-4 w-80 max-w-xs bg-white rounded-2xl shadow-xl border border-gray-100"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center" 
                                 :class="{
                                     'bg-green-50 text-green-600': toast.type === 'success',
                                     'bg-red-50 text-red-600': toast.type === 'error',
                                     'bg-amber-50 text-amber-600': toast.type === 'warning',
                                     'bg-blue-50 text-blue-600': toast.type === 'info'
                                 }"
                            >
                                <span x-html="toast.iconHtml"></span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900" x-text="toast.message"></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="border-b border-gray-100 bg-white/70 backdrop-blur-md shadow-sm">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            function globalAppHandler() {
                return {
                    isLoading: false,
                    loadingText: 'Memuat...',
                    toasts: [],
                    init() {
                        // Check for Laravel session status and validation errors
                        @if(session('status'))
                            this.addToast("{{ session('status') }}", 'success');
                        @endif

                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                this.addToast("{{ $error }}", 'error');
                            @endforeach
                        @endif

                        window.showLoading = (text = 'Memuat...') => {
                            this.loadingText = text;
                            this.isLoading = true;
                        };

                        window.hideLoading = () => {
                            this.isLoading = false;
                        };

                        window.showToast = (message, type = 'success') => {
                            this.addToast(message, type);
                        };

                        // Intercept form submits for loading effects
                        document.addEventListener('submit', (e) => {
                            const form = e.target;
                            
                            // For validation in creating reports
                            if (form.id === 'create-report-form') {
                                const photoInput = document.getElementById('photo');
                                if (!photoInput || !photoInput.files || photoInput.files.length === 0) {
                                    e.preventDefault();
                                    this.addToast('Silakan unggah foto bukti kerusakan jalan!', 'warning');
                                    return;
                                }
                            }

                            if (!form.dataset.submitting) {
                                e.preventDefault();
                                window.showLoading(form.dataset.loadingText || 'Menyimpan data...');
                                form.dataset.submitting = 'true';
                                setTimeout(() => {
                                    form.submit();
                                }, 1200); // 1.2s delay
                            }
                        });

                        // Intercept local links for loading effects
                        document.addEventListener('click', (e) => {
                            const link = e.target.closest('a');
                            if (link && link.href && !link.target && !link.href.startsWith('#') && !link.href.startsWith('javascript:') && !link.classList.contains('no-loader') && !link.getAttribute('download')) {
                                if (link.href.includes(window.location.hostname)) {
                                    e.preventDefault();
                                    window.showLoading('Membuka halaman...');
                                    setTimeout(() => {
                                        window.location.href = link.href;
                                    }, 1000); // 1.0s delay
                                }
                            }
                        });

                        // Initialize Lucide Icons initially
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    },
                    addToast(message, type = 'success') {
                        const id = Date.now() + Math.random();
                        let iconHtml = '';
                        if (type === 'success') {
                            iconHtml = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
                        } else if (type === 'error') {
                            iconHtml = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
                        } else if (type === 'warning') {
                            iconHtml = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>`;
                        } else {
                            iconHtml = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
                        }

                        this.toasts.push({
                            id,
                            message,
                            type,
                            iconHtml,
                            show: true
                        });

                        setTimeout(() => {
                            const index = this.toasts.findIndex(t => t.id === id);
                            if (index !== -1) {
                                this.toasts[index].show = false;
                            }
                        }, 4000);
                    }
                };
            }
        </script>
    </body>
</html>
