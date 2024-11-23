<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'The Hramiak Savings') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

            @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">

        <div class="bg-gray-200 text-black/50 dark:bg-black dark:text-white/50  ">
            <img id="background" class="absolute left-0 top-0 w-full z-10000" src="{{ asset('images/bg.svg') }}" alt="Laravel background" />
            <header class="grid grid-cols-1 items-center gap-2 py-10  absolute right-0 top-0 z-10">
                @if (Route::has('login'))
                    <nav class=" flex flex-1 justify-end">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Dashboard
                            </a>
                            <a
                                href="{{ route('logout') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >   Logout
                            </a>
                            <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();"
                                            >
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="rounded-md px-3 py-2 bg-gray-300 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full  p-6  lg:w-4/5 bg-gradient-to-br from-slate-300 to-slate-100 rounded-xl shadow-[10px_10px_30px_-15px_rgba(0,0,0,0.5)] shadow-[-10px_-10px_30px_15px_rgba(250,250,250,0.5)] ">


                    <main class="h-full">
                        <div class="grid gap-6 grid-cols-1 ">
                            {{-- sum of all savings amount --}}
                            <div class="p-6 bg-white rounded-lg shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] dark:bg-zinc-900 dark:ring-zinc-800">
                                <h2 class="text-xl font-semibold text-black dark:text-white">Total Savings</h2>
                                <p>£{{ number_format($totalSavings, 2) }}</p>
                            </div>



                            <div class="p-6 bg-white rounded-lg shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] dark:bg-zinc-900 dark:ring-zinc-800 ">
                                {{-- Foreach user with savings display value in savingsByUser --}}
                                <h2 class="text-xl font-semibold text-black dark:text-white">Savings by Saver</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2">
                                    @foreach ($savingsByUser as $user)
                                        <p><span class="mr-3">{{ $user->saver }}:</span> £{{ number_format($user->total, 2) }}</p>
                                    @endforeach
                                </div>
                            </div>

                            <div class="p-6 bg-white rounded-lg shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] dark:bg-zinc-900 dark:ring-zinc-800">
                                {{-- Foreach saving  display name, amount, end_date and organisation name from savingsWithEndDate --}}
                                <h2 class="text-xl font-semibold text-black dark:text-white">Savings with End Date</h2>
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b">
                                            <th class="px-4 py-2 font-semibold text-black dark:text-white">Name</th>
                                            <th class="px-4 py-2 font-semibold text-black dark:text-white">Amount</th>
                                            <th class="px-4 py-2 font-semibold text-black dark:text-white">End Date</th>
                                            <th class="px-4 py-2 font-semibold text-black dark:text-white">Organisation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($savingsWithOrganisation as $saving)
                                            <tr class="border-b
                                                hover:bg-gray-100
                                                dark:hover:bg-gray-800
                                                @php
                                                    $daysDifference = \Carbon\Carbon::parse($saving->end_date)->diffInDays(now(), false);
                                                @endphp
                                                @if($daysDifference > 0 && $daysDifference < 30)
                                                    bg-red-500 text-white hover:bg-red-600
                                                @elseif($daysDifference > 0 && $daysDifference < 60)
                                                    bg-amber-500 hover:bg-amber-600
                                                @endif
                                            ">
                                                <td class="px-4 py-2">{{ $saving->name }}</td>
                                                <td class="px-4 py-2">£{{ number_format($saving->amount, 2) }}</td>
                                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($saving->end_date)->format('d-M-Y') }}</td>
                                                <td class="px-4 py-2">{{ $saving->organisation_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </div>
                    </main>

                    {{-- <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        <h2>Footer</h2>
                    </footer> --}}
                </div>
            </div>
        </div>
    </body>
</html>
