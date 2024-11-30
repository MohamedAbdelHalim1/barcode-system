<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Store Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold">Store Name: {{ $store->name }}</h3>
                    <p class="mt-4">Details for the store will go here.</p>
                    <!-- Add any other store-related details here -->
                    
                    <a href="{{ route('stores.index') }}" class="btn btn-secondary mt-4">Back to Store List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
