@extends('website::layouts.public')

@section('public_content')
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ __('Hubungi Kami') }}</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">{{ __('Kontak Redaksi & Layanan Publik') }}</h1>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="text-lg font-bold text-slate-900">{{ __('Alamat Kantor Redaksi') }}</h3>
                    <div class="text-slate-600 text-sm leading-relaxed space-y-1">
                        <p class="font-bold text-slate-800">Yayasan Satriabudi Dharma Setia</p>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $settings['contact_address'] ?? 'Ruko C-17, Pasar Modern Intermoda – BSD, Jl. Raya Cisauk Lapan, Sampora, Cisauk, Tangerang, Banten 15345' }}</p>
                    </div>
                    <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-slate-700">
                        <p class="flex items-center gap-2">
                            <i class="ki-filled ki-sms text-red-600 text-sm"></i>
                            <span>Email: <a href="mailto:{{ $settings['contact_email'] ?? 'admin@dharma.or.id' }}" class="font-semibold text-slate-900 hover:text-red-600">{{ $settings['contact_email'] ?? 'admin@dharma.or.id' }}</a></span>
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="ki-filled ki-phone text-red-600 text-sm"></i>
                            <span>Telepon: <a href="tel:{{ preg_replace('/[^0-9]/', '', $settings['contact_phone'] ?? '02150208805') }}" class="font-semibold text-slate-900 hover:text-red-600">{{ $settings['contact_phone'] ?? '(021) 5020-8805' }}</a></span>
                        </p>
                        @if(!empty($settings['contact_whatsapp']))
                            <p class="flex items-center gap-2">
                                <i class="ki-filled ki-whatsapp text-emerald-600 text-sm"></i>
                                <span>WhatsApp: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['contact_whatsapp']) }}" target="_blank" class="font-semibold text-emerald-600 hover:underline">{{ $settings['contact_whatsapp'] }}</a></span>
                            </p>
                        @endif
                        <p class="flex items-center gap-2 text-slate-500 text-[11px] pt-1">
                            <i class="ki-filled ki-time text-slate-400"></i>
                            <span>{{ $settings['contact_hours'] ?? 'Senin – Jumat: 08.30 – 17.00 WIB' }}</span>
                        </p>
                    </div>

                    @if(!empty($settings['contact_whatsapp']))
                        <div class="pt-4 border-t border-slate-100">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['contact_whatsapp']) }}?text=Halo%20Admin%20IGNITE%20Yayasan%20Satriabudi%20Dharma%20Setia" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-2">
                                <i class="ki-filled ki-whatsapp text-base"></i>
                                <span>Chat WhatsApp Layanan Cepat</span>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="text-lg font-bold text-slate-900">{{ __('Kirim Pesan Pertanyaan') }}</h3>
                    
                    @if(session('success'))
                        <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-xs font-bold flex items-center gap-2">
                            <i class="ki-filled ki-check-circle text-green-600 text-base"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('website.contact.submit') }}" method="POST" class="space-y-4 text-xs">
                        @csrf
                        {{-- Honeypot bot protection field --}}
                        <div class="hidden" style="display:none !important;" aria-hidden="true">
                            <input type="text" name="website_hp" value="" tabindex="-1" autocomplete="off" />
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">{{ __('FIRST NAME') }} <span class="text-red-600">*</span></label>
                            <input type="text" name="first_name" required value="{{ old('first_name') }}" placeholder="{{ __('FIRST NAME') }}" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none" />
                            @error('first_name')
                                <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">{{ __('PHONE') }} <span class="text-red-600">*</span></label>
                            <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="{{ __('PHONE') }}" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none" />
                            @error('phone')
                                <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">{{ __('EMAIL') }} <span class="text-red-600">*</span></label>
                            <input type="email" name="email" required value="{{ old('email') }}" placeholder="{{ __('EMAIL') }}" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none" />
                            @error('email')
                                <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">{{ __('MESSAGE') }} <span class="text-red-600">*</span></label>
                            <textarea name="message" rows="3" required placeholder="{{ __('MESSAGE') }}" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold text-xs tracking-wide transition shadow-md flex items-center justify-center gap-1.5">
                            <span>{{ __('Kirim') }}</span> &rarr;
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
