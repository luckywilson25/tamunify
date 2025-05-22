@once
  @push('styles')
    <style>
      @keyframes scroll-text {
        0% {
          transform: translateX(0%);
        }
        100% {
          transform: translateX(-100%);
        }
      }

      .animate-scroll-text {
        animation: scroll-text 20s linear infinite;
      }

      .scroll-wrapper::after {
        content: "";
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 160px;
        background: linear-gradient(to left, #000000, transparent);
        z-index: 10;
      }

      .scroll-wrapper::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 160px;
        background: linear-gradient(to right, #000000, transparent);
        z-index: 10;
      }
    </style>
  @endpush
@endonce

<div class="mb-4 overflow-hidden px-4 sm:px-6 lg:px-8">
  <div class="relative w-full overflow-hidden scroll-wrapper">
    <h2 class="whitespace-nowrap text-3xl sm:text-4xl font-bold text-white drop-shadow-md animate-scroll-text">
      Selamat Datang di PT Pupuk Kujang - Selamat Datang di PT Pupuk Kujang - Selamat Datang di PT Pupuk Kujang
    </h2>
  </div>

  <div class="h-1 bg-white rounded-full mt-2 w-full transition-all duration-700 ease-out"></div>
</div>
