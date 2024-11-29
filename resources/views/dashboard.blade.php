<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Savings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div> --}}
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <h2>Current Total:</h2>
                        <p>£{{ number_format($totalSavings, 2) }}</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="mb-2">Admin:</h2>
                        {{-- link to organisation.index styled as a button--}}

                        <a href="{{ route('organisation.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-6">Organisation</a>
                        <a href="{{ route('type.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-6">Type</a>
                        <a href="{{ route('savings.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-6">Savings</a>


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
