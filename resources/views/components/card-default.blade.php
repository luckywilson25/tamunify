<section class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-6 flex flex-col items-center text-center border border-gray-100 transform hover:-translate-y-1 relative overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-b from-green-50 to-transparent opacity-70 pointer-events-none"></div>
  <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4 ring-2 ring-green-200 shadow-md relative z-10">
    {!! $icon !!}
  </div>
  <h2 class="text-xl font-bold text-gray-900 mb-2 relative z-10">{{ $title }}</h2>
  <p class="text-gray-600 mb-6 relative z-10">{{ $desc }}</p>
  <a href="{{ $href }}" class="relative z-10">
    <button class="bg-green-800 hover:bg-green-900 text-white font-medium px-5 py-3 rounded-lg transition-all duration-300 hover:scale-105 flex items-center gap-2 shadow-md hover:shadow-lg">
      Registrasi <i class="fa-solid fa-arrow-right w-4 h-4"></i>
    </button>
  </a>
  <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-green-100 rounded-full opacity-30"></div>
</section>
