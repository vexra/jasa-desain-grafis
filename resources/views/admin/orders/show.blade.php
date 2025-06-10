<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Detail Pesanan #{{ $order->order_number }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-gray-600 mb-2"><strong>Pelanggan:</strong> {{ $order->user->name ?? 'N/A' }} ({{ $order->user->email ?? 'N/A' }})</p>
                            <p class="text-gray-600 mb-2"><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                            <p class="text-gray-600 mb-2"><strong>Total Harga:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            <p class="text-gray-600 mb-2"><strong>Status:</strong>
                                @php
                                    $statusClass = '';
                                    switch($order->status) {
                                        case 'pending': $statusClass = 'bg-yellow-100 text-yellow-800'; break;
                                        case 'processing': $statusClass = 'bg-blue-100 text-blue-800'; break;
                                        case 'completed': $statusClass = 'bg-green-100 text-green-800'; break;
                                        case 'cancelled': $statusClass = 'bg-red-100 text-red-800'; break;
                                        default: $statusClass = 'bg-gray-100 text-gray-800'; break;
                                    }
                                @endphp
                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            @if ($order->notes)
                                <p class="text-gray-600 mt-4"><strong>Catatan:</strong><br>{{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>

                    <h4 class="text-xl font-bold mb-4">Item Pesanan:</h4>
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu Jasa</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="py-4 px-6 whitespace-nowrap">{{ $item->menu->name ?? 'Menu Dihapus' }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">{{ $item->quantity }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.orders.edit', $order) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-3">
                            Edit Status Pesanan
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Kembali ke Daftar Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>