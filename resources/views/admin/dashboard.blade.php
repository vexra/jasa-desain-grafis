<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        {{-- Sidebar --}}
        <div id="sidebar1" class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white p-4 space-y-4
                                  transform -translate-x-full md:relative md:translate-x-0
                                  transition-all duration-300 ease-in-out z-50 md:z-auto">
            <div class="text-2xl font-semibold text-center">Admin Panel</div>
            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 12v10a1 1 0 001 1h3m10-10l2 2m0 0l7 7m-12 0h-3a1 1 0 01-1-1v-10a1 1 0 011-1h6a1 1 0 011 1v10a1 1 0 01-1 1z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.menus.index') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Kelola Menu
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M17 12l-2 2m-2-2l2-2m-2 2l-2-2" />
                    </svg>
                    Kelola Pesanan
                </a>
                <a href="{{ route('admin.customers.index') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2v-2a3 3 0 015.356-1.857M17 20v-9a2 2 0 00-2-2H7a2 2 0 00-2 2v9m4 1h6a2 2 0 002-2v-7a2 2 0 00-2-2H9a2 2 0 00-2 2v7a2 2 0 002 2zM9 13h6" />
                    </svg>
                    Kelola Pelanggan
                </a>
                <a href="{{ route('admin.payments.index') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition duration-200">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0H7a2 2 0 00-2 2v4a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2m-4 5h4" />
                    </svg>
                    Kelola Pembayaran
                </a>
            </nav>
        </div>

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center bg-white p-4 shadow-md">
                {{-- Toggle Button --}}
                <button id="sidebarToggle1" class="text-gray-600 focus:outline-none md:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>

                {{-- User Dropdown/Logout --}}
                <div class="flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <h1 class="text-3xl font-semibold text-gray-800 mb-6">Analitik Admin Sekilas</h1>

                {{-- Card Statistik Umum --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Menu Jasa</p>
                            <h2 class="text-3xl font-bold text-gray-800">{{ $totalMenus }}</h2>
                        </div>
                        <div class="text-indigo-500">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Pelanggan</p>
                            <h2 class="text-3xl font-bold text-gray-800">{{ $totalCustomers }}</h2>
                        </div>
                        <div class="text-green-500">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2v-2a3 3 0 015.356-1.857M17 20v-9a2 2 0 00-2-2H7a2 2 0 00-2 2v9m4 1h6a2 2 0 002-2v-7a2 2 0 00-2-2H9a2 2 0 00-2 2v7a2 2 0 002 2zM9 13h6" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Pesanan</p>
                            <h2 class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</h2>
                        </div>
                        <div class="text-yellow-500">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M17 12l-2 2m-2-2l2-2m-2 2l-2-2" />
                            </svg>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Pendapatan (Lunas)</p>
                            <h2 class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalPayments, 0, ',', '.') }}</h2>
                        </div>
                        <div class="text-red-500">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V4m0 8v4m-6-4h12" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Statistik Pesanan Berdasarkan Status --}}
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ringkasan Status Pesanan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500 text-sm">Pesanan Pending</p>
                        <h2 class="text-3xl font-bold text-yellow-600">{{ $pendingOrders }}</h2>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500 text-sm">Pesanan Diproses</p>
                        <h2 class="text-3xl font-bold text-blue-600">{{ $processingOrders }}</h2>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500 text-sm">Pesanan Selesai</p>
                        <h2 class="text-3xl font-bold text-green-600">{{ $completedOrders }}</h2>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500 text-sm">Pesanan Dibatalkan</p>
                        <h2 class="text-3xl font-bold text-red-600">{{ $cancelledOrders }}</h2>
                    </div>
                </div>

                {{-- Statistik Pembayaran Berdasarkan Status (opsional) --}}
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ringkasan Status Pembayaran</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500 text-sm">Pembayaran Pending</p>
                        <h2 class="text-3xl font-bold text-yellow-600">{{ $pendingPayments }}</h2>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500 text-sm">Pembayaran Selesai</p>
                        <h2 class="text-3xl font-bold text-green-600">{{ $completedPaymentsCount }}</h2>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500 text-sm">Pembayaran Gagal</p>
                        <h2 class="text-3xl font-bold text-red-600">{{ $failedPayments }}</h2>
                    </div>
                </div>

            </main>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar1');
            const sidebarToggle = document.getElementById('sidebarToggle1');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });
        });
    </script>
    @endpush
</x-app-layout>