<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Event Manager</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="antialiased text-black w-[100vw] overflow-x-hidden" style="font-family: 'Poppins', sans-serif">
<div class="flex ">    
    <div>        
        <header class="flex items-center gap-2 py-4 lg:grid-cols-3 bg-transparent w-full">
                <img src="https://themes.muffingroup.com/be/event6/wp-content/uploads/2021/04/retina-event6.png" class="w-[150px] ml-[9vw] mt-6" alt="">

                @if (Route::has('login'))
                    <nav class="mx-5 flex flex-1 gap-3 justify-end">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="rounded-3xl px-3 py-2 mr-[12vw] text-black bg-white hover:bg-[#8a16db] hover:text-white"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="rounded-3xl px-3 py-2 text-black bg-white hover:bg-[#8a16db] hover:text-white"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="rounded-3xl px-3 py-2 mr-[5vw] text-black bg-white hover:bg-[#8a16db] hover:text-white"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
        </header>

        <main class="mt-6">
            <section class="hero mx-5 lg:grid lg:grid-cols-2 items-center">
                <div class="left px-28">
                    <h3>Welcome</h3>
                    <h1 class="text-[60px] font-bold my-7">You want to organize an event?</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quos molestias corrupti debitis, esse, voluptas asperiores eaque ex cupiditate similique alias expedita dolorem voluptatibus aut suscipit id reprehenderit temporibus animi commodi.</p>

                    <a
                        href="#"
                        class="block text-center text-white w-[150px] h-[40px] bg-[#5208B6] hover:bg-[#8a16db] rounded-3xl px-3 py-2 my-12"
                    >
                        Get Started
                    </a>
                </div>


                <div class="right">
                    <img src="https://themes.muffingroup.com/be/event6/wp-content/uploads/2021/04/event6-slider-pic1.png" alt="">
                </div>
            </section>
        </main>
    </div>

    <div class="bg-[#5208B6] h-[100vh] w-[35vw] fixed z-[-1] ml-[65.8vw]">
    </div>
</div>

    <footer class="bg-[#5208B6]">
      <div
        class="container flex flex-col-reverse justify-between px-6 py-10 mx-auto space-y-8 md:flex-row md:space-y-0"
      >
        <!-- Logo and social links container -->
        <div
          class="flex flex-col-reverse items-center justify-between space-y-12 md:flex-col md:space-y-0 md:items-start"
        >
          <h3 class="font-bold text-xl text-white">be.event</h3>
          <!-- Social Links Container -->
          <div
            class="flex flex-wrap justify-center md:justify-start md:gap-y-2 space-x-4"
          >
            <!-- Link 1 -->
            <a href="#">
              <img
                src="https://img.icons8.com/?size=512&id=118497&format=png"
                alt="facebook"
                class="h-8"
              />
            </a>
            <!-- Link 2 -->
            <a href="#">
              <img
                src="https://img.icons8.com/?size=512&id=19318&format=png"
                alt="youtube"
                class="h-8"
              />
            </a>
            <!-- Link 3 -->
            <a href="#">
              <img
                src="https://img.icons8.com/?size=512&id=13963&format=png"
                alt="twitter"
                class="h-8"
              />
            </a>
            <!-- Link 4 -->
            <a href="#">
              <img
                src="https://img.icons8.com/?size=512&id=63676&format=png"
                alt="pinterest"
                class="h-8"
              />
            </a>
            <!-- Link 5 -->
            <a href="#">
              <img
                src="https://img.icons8.com/?size=512&id=Xy10Jcu1L2Su&format=png"
                alt="instagram"
                class="h-8"
              />
            </a>
          </div>
        </div>
        <!-- List Container -->
        <div class="flex justify-around space-x-32">
          <div class="flex flex-col space-y-3 text-white">
            <a
              href="#"
              class="hover:text-purple-200"
              >Home</a
            >
            <a
              href="#"
              class="hover:text-purple-200"
              >Pricing</a
            >
            <a
              href="#"
              class="hover:text-purple-200"
              >Products</a
            >
            <a
              href="#"
              class="hover:text-purple-200"
              >About</a
            >
          </div>
          <div class="flex flex-col space-y-3 text-white">
            <a
              href="#"
              class="hover:text-purple-200"
              >Careers</a
            >
            <a
              href="#"
              class="hover:text-purple-200"
              >Community</a
            >
            <a
              href="#"
              class="hover:text-purple-200"
              >Privacy Policy</a
            >
          </div>
        </div>
        <!-- Input Container -->
        <div class="flex flex-col justify-between">
          <form>
            <div class="flex">
              <input
                type="text"
                class="flex-1 px-5 rounded-l-full focus:outline-none"
                placeholder="Updated in your inbox"
              />
              <button
                class="px-5 py-1.5 text-white rounded-r-full bg-purple-500 hover:bg-purple-400 focus:outline-none"
              >
                Go
              </button>
            </div>
          </form>
          <div class="hidden text-white md:block">
            Copyright &copy; be.event 2024, All Rights Reserved
          </div>
        </div>
      </div>
    </footer>
    </body>
</html>
