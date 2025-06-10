<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Detail Pembayaran ID: {{ $payment->id }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-gray-600 mb-2"><strong>No. Pesanan:</strong>
                                @if($payment->order)
                                    <a href="{{ route('admin.orders.show', $payment->order) }}" class="text-blue-600 hover:underline">
                                        {{ $payment->order->order_number }} (Pelanggan: {{ $payment->order->user->name ?? 'N/A' }})
                                    </a>
                                @else
                                    <span class="text-gray-500">Order Dihapus</span>
                                @endif
                            </p>
                            <p class="text-gray-600 mb-2"><strong>ID Transaksi:</strong> {{ $payment->transaction_id ?? '-' }}</p>
                            <p class="text-gray-600 mb-2"><strong>Jumlah Pembayaran:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            <p class="text-gray-600 mb-2"><strong>Metode Pembayaran:</strong> {{ $payment->method ?? '-' }}</p>
                            <p class="text-gray-600 mb-2"><strong>Status:</strong>
                                @php
                                    $statusClass = '';
                                    switch($payment->status) {
                                        case 'pending': $statusClass = 'bg-yellow-100 text-yellow-800'; break;
                                        case 'completed': $statusClass = 'bg-green-100 text-green-800'; break;
                                        case 'failed': $statusClass = 'bg-red-100 text-red-800'; break;
                                        case 'refunded': $statusClass = 'bg-indigo-100 text-indigo-800'; break;
                                        default: $statusClass = 'bg-gray-100 text-gray-800'; break;
                                    }
                                @endphp
                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </p>
                            <p class="text-gray-600 mb-2"><strong>Waktu Dibuat:</strong> {{ $payment->created_at->format('d M Y H:i') }}</p>
                            <p class="text-gray-600 mb-2"><strong>Waktu Pembayaran Dikonfirmasi:</strong> {{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '-' }}</p>
                            @if ($payment->notes)
                                <p class="text-gray-600 mt-4"><strong>Catatan:</strong><br>{{ $payment->notes }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('admin.payments.edit', $payment) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-3">
                            Edit Status Pembayaran
                        </a>
                        <a href="{{ route('admin.payments.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Kembali ke Daftar Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>