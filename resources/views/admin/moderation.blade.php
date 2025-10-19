@extends('layouts.admin')
@section('title', 'Item Moderation')

@section('content')
<div class="mx-6 mb-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-shield-alt text-indigo-600"></i> Panel Moderasi Barang
            </h2>
        </div>

        <form action="{{ route('admin.moderate') }}" method="POST" class="p-6 space-y-6">
            @csrf

            {{-- Select Item --}}
            <div>
                <label class="block font-medium text-gray-700">Pilih Barang</label>
                <select name="item_id" id="item_id" onchange="showItemDetails(this)"
                        class="w-full mt-2 border px-4 py-2 rounded-lg">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($allItems as $item)
                        <option value="{{ $item->id }}"
                                data-image="{{ asset('images/' . $item->pic) }}"
                                data-type="{{ $item->type }}"
                                data-description="{{ $item->description }}"
                                data-location="{{ $item->latitude ? number_format($item->latitude, 4) . ', ' . number_format($item->longitude, 4) : 'Tidak ada' }}"
                                data-created="{{ $item->created_at->format('Y-m-d H:i') }}">
                            {{ $item->description }} - {{ ucfirst($item->type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Action --}}
            <div>
                <label class="block font-medium text-gray-700">Aksi Moderasi</label>
                <select name="action" class="w-full mt-2 border px-4 py-2 rounded-lg">
                    <option value="">-- Pilih Aksi --</option>
                    <option value="approve">✓ Setujui Barang</option>
                    <option value="flag">⚠ Tandai sebagai Tidak Etis</option>
                    <option value="delete">✗ Hapus Permanen</option>
                </select>
            </div>

            {{-- Preview --}}
            <div id="itemPreview" class="hidden bg-gray-50 border rounded-lg p-4 shadow space-y-3">
                <div class="flex justify-center">
                    <div id="imageContainer" class="relative">
                        <img id="itemImage" src="" class="max-w-xs rounded-lg border shadow-md" 
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                             onload="this.style.display='block'; this.nextElementSibling.style.display='none';">
                        <div id="imagePlaceholder" style="display:none;" class="max-w-xs h-48 bg-gray-200 border border-dashed border-gray-400 rounded-lg flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm">Gambar tidak tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-sm text-gray-700 space-y-1">
                    <p><strong>Jenis:</strong> <span id="itemType"></span></p>
                    <p><strong>Deskripsi:</strong> <span id="itemDescription"></span></p>
                    <p><strong>Lokasi:</strong> <span id="itemLocation"></span></p>
                    <p><strong>Dilaporkan pada:</strong> <span id="itemCreated"></span></p>
                </div>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg w-full">
                Jalankan Moderasi
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showItemDetails(select) {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.dataset.image) {
            document.getElementById('itemPreview').classList.add('hidden');
            return;
        }

        document.getElementById('itemImage').src = selected.dataset.image;
        document.getElementById('itemType').innerText = selected.dataset.type;
        document.getElementById('itemDescription').innerText = selected.dataset.description;
        document.getElementById('itemLocation').innerText = selected.dataset.location;
        document.getElementById('itemCreated').innerText = selected.dataset.created;

        document.getElementById('itemPreview').classList.remove('hidden');
    }
</script>
@endsection
