<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Daftar Pembayaran</h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l3.029-2.651-3.029-2.651a1.2 1.2 0 1 1 1.697-1.697l2.651 3.029 2.651-3.029a1.2 1.2 0 1 1 1.697 1.697l-3.029 2.651 3.029 2.651a1.2 1.2 0 0 1 0 1.697z"/></svg>
                            </span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pembayaran</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td class="py-4 px-6 whitespace-nowrap text-sm font-medium">{{ $payment->id }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            @if($payment->order)
                                                <a href="{{ route('admin.orders.show', $payment->order) }}" class="text-blue-600 hover:underline">{{ $payment->order->order_number }}</a>
                                            @else
                                                <span class="text-gray-500">Order Dihapus</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">{{ $payment->method ?? '-' }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">
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
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">{{ $payment->created_at->format('d M Y H:i') }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.payments.show', $payment) }}" class="text-green-600 hover:text-green-900 mr-3">Detail</a>
                                            <a href="{{ route('admin.payments.edit', $payment) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit Status</a>
                                            <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 px-6 text-center text-gray-500">Belum ada pembayaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>