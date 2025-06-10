<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Edit Pembayaran ID: {{ $payment->id }}</h3>

                    <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="order_number_display" class="block text-sm font-medium text-gray-700">No. Pesanan</label>
                            <input type="text" id="order_number_display" class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm cursor-not-allowed" value="{{ $payment->order->order_number ?? 'Order Dihapus' }}" disabled>
                            <p class="text-sm text-gray-500 mt-1">Ini hanya tampilan. Nomor pesanan tidak dapat diubah di sini.</p>
                        </div>

                        <div class="mb-4">
                            <label for="amount_display" class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                            <input type="text" id="amount_display" class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm cursor-not-allowed" value="Rp {{ number_format($payment->amount, 0, ',', '.') }}" disabled>
                            <p class="text-sm text-gray-500 mt-1">Ini hanya tampilan. Jumlah pembayaran tidak dapat diubah di sini.</p>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror" required>
                                @foreach ($statuses as $statusOption)
                                    <option value="{{ $statusOption }}" {{ old('status', $payment->status) == $statusOption ? 'selected' : '' }}>
                                        {{ ucfirst($statusOption) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700">ID Transaksi (opsional)</label>
                            <input type="text" name="transaction_id" id="transaction_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('transaction_id') border-red-500 @enderror" value="{{ old('transaction_id', $payment->transaction_id) }}">
                            @error('transaction_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="method" class="block text-sm font-medium text-gray-700">Metode Pembayaran (opsional)</label>
                            <input type="text" name="method" id="method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('method') border-red-500 @enderror" value="{{ old('method', $payment->method) }}">
                            @error('method')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Admin (opsional)</label>
                            <textarea name="notes" id="notes" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('notes') border-red-500 @enderror">{{ old('notes', $payment->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="mr-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Perbarui Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>