<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        {{-- Sidebar Admin --}}
        <div id="sidebar1" class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white p-4 space-y-4
                                  transform -translate-x-full md:relative md:translate-x-0
                                  transition-all duration-300 ease-in-out z-50 md:z-auto">
            <div class="text-2xl font-semibold text-center">Panel Admin</div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2h-3v10a2 2 0 01-2 2H7a2 2 0 01-2-2V5H2a2 2 0 00-2 2v11a2 2 0 002 2h15zm-3 0v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2h10z" />
                    </svg>
                    Kelola Pelanggan
                </a>
                 <a href="{{ route('admin.payments.index') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition duration-200 bg-gray-700 text-white">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
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
                <h1 class="text-2xl font-bold text-gray-800">Detail Pembayaran #{{ $payment->transaction_id }}</h1>

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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <h3 class="text-2xl font-bold mb-6">Detail Pembayaran</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-gray-600 mb-2"><strong>ID Transaksi:</strong> {{ $payment->transaction_id }}</p>
                                <p class="text-gray-600 mb-2"><strong>No. Pesanan:</strong>
                                    <a href="{{ route('admin.orders.show', $payment->order->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $payment->order->order_number }}
                                    </a>
                                </p>
                                <p class="text-gray-600 mb-2"><strong>Pelanggan:</strong> {{ $payment->order->user->name ?? 'N/A' }} (ID: {{ $payment->order->user->id ?? 'N/A' }})</p>
                                <p class="text-gray-600 mb-2"><strong>Jumlah Pembayaran:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                <p class="text-gray-600 mb-2"><strong>Metode Pembayaran:</strong> {{ $payment->method }}</p>
                                <p class="text-gray-600 mb-2"><strong>Waktu Pengajuan:</strong> {{ $payment->created_at->format('d M Y H:i') }}</p>
                                <p class="text-gray-600 mb-2"><strong>Waktu Dikonfirmasi:</strong> {{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '-' }}</p>
                                <p class="text-gray-600 mb-2"><strong>Status Pembayaran:</strong>
                                    @php
                                        $paymentStatusClass = '';
                                        switch($payment->status) {
                                            case 'pending': $paymentStatusClass = 'bg-yellow-100 text-yellow-800'; break;
                                            case 'completed': $paymentStatusClass = 'bg-green-100 text-green-800'; break;
                                            case 'failed': $paymentStatusClass = 'bg-red-100 text-red-800'; break;
                                            default: $paymentStatusClass = 'bg-gray-100 text-gray-800'; break;
                                        }
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $paymentStatusClass }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </p>
                                <p class="text-gray-600 mb-2"><strong>Catatan:</strong> {{ $payment->notes ?? '-' }}</p>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-4">Bukti Pembayaran:</h4>
                                @if ($payment->proof_of_payment)
                                    <img src="{{ Storage::url($payment->proof_of_payment) }}" alt="Bukti Pembayaran" class="max-w-xs h-auto rounded-lg shadow-md border border-gray-200">
                                    <a href="{{ Storage::url($payment->proof_of_payment) }}" target="_blank" class="mt-2 inline-block text-blue-600 hover:text-blue-900">Lihat Gambar Ukuran Penuh</a>
                                @else
                                    <p class="text-gray-500">Tidak ada bukti pembayaran diunggah.</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('admin.payments.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                                Kembali ke Daftar Pembayaran
                            </a>
                            @if ($payment->status === 'pending')
                                <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="inline-block mr-2" onsubmit="return confirm('Anda yakin ingin MENYETUJUI pembayaran ini? Status pesanan akan diubah menjadi processing.');">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Setujui Pembayaran
                                    </button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin MENOLAK pembayaran ini?');">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Tolak Pembayaran
                                    </button>
                                </form>
                            @endif
                        </div>
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