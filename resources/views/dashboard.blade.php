<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    
                    <div class="mt-4 p-4 bg-gray-100 rounded">
                        <strong>Deteksi Data Akun Saat Ini:</strong><br>
                        Nama: {{ Auth::user()->name }} <br>
                        Email: {{ Auth::user()->email }} <br>
                        Role ID: {{ Auth::user()->role_id }} <br>
                        Nama Role: {{ Auth::user()->role->nama_role ?? 'Role tidak ditemukan / Kolom salah' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
