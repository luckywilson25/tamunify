<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel')) - {{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/solid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTableTailwind.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins antialiased">
    <div class="flex-1 bg-transparent relative z-10 flex flex-col pl-64">

        {{--
        <x-background /> --}}
        @include('layouts.sidebar')
        <div class="flex-1 bg-transparent relative z-10 flex flex-col">

            <header class="bg-white/90 border-b px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <h1 class="lg:text-xl text-xs font-bold text-[#006838]">@yield('header')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="lg:block hidden">
                            <a href="{{ route('home') }}">
                                <x-button.default-button
                                    class="border-[#006838] text-white bg-[#006838] hover:bg-[#005830] lg:btn-lg btn-sm lg:text-base text-xs">
                                    Kembali ke Beranda
                                </x-button.default-button>
                            </a>
                        </div>
                        <div class="lg:hidden block">
                            <a href="{{ route('home') }}">
                                <x-button.default-button
                                    class="border-[#006838] text-white bg-[#006838] hover:bg-[#005830] lg:btn-lg btn-sm lg:text-base text-xs">
                                    Kembali
                                </x-button.default-button>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="main-content">
                {{ $slot }}
            </main>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/all.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/solid.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/brands.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/fontawesome.js') }}"></script>
    <script src="{{ asset('assets/js/dataTable.js') }}"></script>
    <script src="{{ asset('assets/js/dataTableTailwind.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        new DataTable('#myTable');
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        $('#summernote').summernote({
            placeholder: 'lorem ipsum',
            style: 'background-color:white;',
            tabsize: 2,
            height: 500,
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Montserrat',
                'Times New Roman', 'Calibri'
            ],
            lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
            fontSizes: ['2', '4', '6', '8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '32', '40', '52',
                '60', '72', '82'
            ],
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'clear', 'fontname', 'fontsizeunit',
                    'forecolor', 'backcolor'
                ]],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video', 'hr']],
                ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']],
            ],
        });
    </script>
    @if (isset($script))
    {{ $script }}
    @endif
</body>

</html>