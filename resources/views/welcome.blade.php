<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="flex min-h-screen flex-col relative overflow-hidden">

      <div class="absolute inset-0 z-0">
        <!-- <BuildingBackground /> -->
        <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm" />
      </div>

      <header class="bg-white/90 border-b relative z-10">
        <div class="w-ful flex justify-between items-center ">
       
            <!-- <HeaderLogo /> -->
<header class="bg-white/90 border-b relative z-10">
                    <div class="w-full flex justify-between items-center">
                      <HeaderLogo />
                    </div>
                  </header>
        </div>
      </header>

      <main class="flex-1 w-full px-0.5 py-1 relative z-10 flex items-center justify-center text-center text-white">
        <div class="max-w-screen-xl mx-auto w-full space-y-6">
          <AnimatedWelcomeText />
          <p class="text-xl font-semibold drop-shadow-md">
            Silakan register sebagai tamu untuk memulai kunjungan Anda.
          </p>

          <div class="flex flex-wrap justify-center gap-6">
            <Link href="/check-in-new">
              <button
                size="lg"
                class="bg-[#006838] hover:bg-[#005028] text-white transition-all duration-300 transform hover:scale-105"
              >
                Register Tamu
              </button>
            </Link>
            <Link href="/check-out">
              <Button
                variant="outline"
                size="lg"
                class="border-white text-[#006838] hover:bg-white hover:text-[#006838] transition-all duration-300 transform hover:scale-105"
              >
                Check-out
              </Button>
            </Link>
          </div>
        </div>
      </main>
    </body>
</html>
