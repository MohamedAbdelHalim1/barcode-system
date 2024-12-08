<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Color Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-medium text-lg">Color Key: {{ $color->key }}</h3>

                    <a href="{{ route('colors.index') }}" class="btn btn-primary mt-4">Back to Colors</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>