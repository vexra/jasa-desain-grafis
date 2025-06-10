<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Daftar Pesanan Pelanggan</h3>

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
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pesan</th>
                                    <th class="py-3 px-6 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="py-4 px-6 whitespace-nowrap text-sm font-medium">{{ $order->order_number }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">{{ $order->user->name ?? 'N/A' }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap">
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
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td class="py-4 px-6 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-green-600 hover:text-green-900 mr-3">Detail</a>
                                            <a href="{{ route('admin.orders.edit', $order) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit Status</a>
                                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini? Menghapus pesanan akan menghapus semua item terkait.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-6 text-center text-gray-500">Belum ada pesanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>