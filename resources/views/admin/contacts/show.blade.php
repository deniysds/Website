@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.contacts.index') }}" class="hover:text-red-600">Kotak Masuk Pertanyaan</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Detail Pesan</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6 max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Pesan Pertanyaan Masuk</h1>
                <p class="text-xs text-gray-500 mt-1">Informasi lengkap pengirim dan tindak lanjut balasan komunikasi.</p>
            </div>
            <a href="{{ route('website.contacts.index') }}" class="kt-btn kt-btn-outline text-xs">
                &larr; Kembali ke Kotak Masuk
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 text-sm flex items-center gap-2">
                <i class="ki-filled ki-check-circle text-green-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Sender Info & Message Card -->
        <div class="kt-card">
            <div class="p-6 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-150 gap-4">
                    <div>
                        <span class="text-[10px] font-bold text-red-600 uppercase tracking-widest block">Pengirim Pesan</span>
                        <h2 class="text-lg font-extrabold text-gray-900">{{ $contact->full_name }}</h2>
                    </div>
                    <div class="text-xs text-gray-500 font-mono">
                        Diterima: <strong class="text-gray-800 font-bold">{{ $contact->created_at->format('d F Y, H:i') }} WIB</strong>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 space-y-1">
                        <span class="text-gray-500 font-semibold uppercase text-[10px]">Alamat Email</span>
                        <div class="font-bold text-gray-900 text-sm">
                            <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:underline flex items-center gap-1">
                                {{ $contact->email }}
                                <i class="ki-filled ki-sms text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 space-y-1">
                        <span class="text-gray-500 font-semibold uppercase text-[10px]">Nomor Telepon / WhatsApp</span>
                        <div class="font-bold text-gray-900 text-sm">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" target="_blank" class="text-green-600 hover:underline flex items-center gap-1">
                                {{ $contact->phone }}
                                <i class="ki-filled ki-whatsapp text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Message Body -->
                <div class="space-y-2">
                    <span class="text-[11px] font-extrabold text-gray-700 uppercase tracking-wider block">Isi Pesan / Pertanyaan Lengkap:</span>
                    <div class="p-5 rounded-2xl bg-red-50/40 border border-red-100 text-xs sm:text-sm text-gray-900 leading-relaxed whitespace-pre-line font-normal">
                        {{ $contact->message }}
                    </div>
                </div>

                <!-- Action Direct Reply -->
                <div class="pt-2 flex flex-wrap gap-3">
                    <a href="mailto:{{ $contact->email }}?subject=Balasan%20Pertanyaan%20IGNITE%20Portal&body=Yth.%20{{ urlencode($contact->full_name) }},%0A%0ATerima%20kasih%20telah%20menghubungi%20kami.%0A%0A---%0APesan%20Asli:%0A{{ urlencode($contact->message) }}" class="kt-btn kt-btn-primary text-white text-xs font-bold px-4 py-2.5 flex items-center gap-1.5 shadow-xs">
                        <i class="ki-filled ki-sms text-white"></i> Balas via Email Langsung
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}?text=Halo%20{{ urlencode($contact->full_name) }},%20kami%20dari%20Tim%20IGNITE%20Publishing%20menindaklanjuti%20pertanyaan%20Anda." target="_blank" class="kt-btn kt-btn-outline text-xs font-bold px-4 py-2.5 flex items-center gap-1.5">
                        <i class="ki-filled ki-whatsapp text-green-600"></i> Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Follow-up Status & Admin Notes Form -->
        <div class="kt-card">
            <div class="kt-card-header min-h-14 py-4 border-b border-gray-200">
                <h3 class="kt-card-title text-base font-bold">Status Tindak Lanjut & Catatan Internal Admin</h3>
            </div>
            <div class="kt-card-body p-6">
                <form action="{{ route('website.contacts.status', $contact->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="font-bold text-gray-700">Status Penanganan Pesan <span class="text-red-500">*</span></label>
                            <select name="status" class="kt-select w-full text-xs">
                                <option value="unread" {{ $contact->status === 'unread' ? 'selected' : '' }}>Belum Dibaca (Unread)</option>
                                <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Sudah Dibaca (Read)</option>
                                <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Sudah Dibalas / Ditindaklanjuti (Replied)</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-gray-700">Waktu Ditandai Selesai</label>
                            <input type="text" disabled value="{{ $contact->replied_at ? $contact->replied_at->format('d M Y, H:i') : 'Belum ditandai selesai' }}" class="kt-input w-full text-xs bg-gray-100 text-gray-500" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Catatan Internal Redaksi / Admin</label>
                        <textarea name="admin_notes" rows="3" placeholder="Tuliskan catatan internal terkait jawaban atau tindak lanjut yang telah diberikan..." class="kt-input w-full text-xs">{{ $contact->admin_notes }}</textarea>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-bold px-5 py-2.5">
                            Simpan Perubahan Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
