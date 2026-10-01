<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Landing Page' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        [data-aos="unfold-paper"] {
            transform: perspective(1200px) rotateX(-90deg);
            transform-origin: top center;
            opacity: 0;
            transition-property: transform, opacity;
        }
        [data-aos="unfold-paper"].aos-animate {
            transform: perspective(1200px) rotateX(0deg);
            opacity: 1;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans antialiased overflow-x-hidden">
    
    <x-navbar />

    <main class="flex-grow w-full">
        {{ $slot }}
    </main>

    <x-footer />

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800, 
                once: true,    
                offset: 100,
                easing: 'ease-out-cubic'
            });
        });
    </script>

    @stack('modals')
</body>
</html>