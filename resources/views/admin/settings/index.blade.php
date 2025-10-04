@extends('layouts.admin')

@section('page-title', 'Settings')

@section('content')
<div class="max-w-12xl mx-auto bg-white p-6 rounded-lg shadow-md">
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 2 Column Grid --}}
        <div class="grid md:grid-cols-2 gap-6">

            {{-- Website URL --}}
            <div>
                <label class="block font-semibold">Website URL</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fas fa-globe"></i>
                    </span>
                    <input type="url" name="url" value="{{ old('url', $setting->url ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label class="block font-semibold">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email', $setting->email ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- Mobile --}}
            <div>
                <label class="block font-semibold">Mobile</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fas fa-phone"></i>
                    </span>
                    <input type="text" name="mobile" value="{{ old('mobile', $setting->mobile ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- Location --}}
            <div>
                <label class="block font-semibold">Location</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <input type="text" name="location" value="{{ old('location', $setting->location ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- Logo --}}
            <div>
                <label class="block font-semibold">Logo</label>
                <input type="file" name="logo" class="w-full border rounded p-2">
                @if(!empty($setting->logo))
                    <img src="{{ asset('storage/'.$setting->logo) }}" class="h-12 mt-2">
                @endif
            </div>

            {{-- Favicon --}}
            <div>
                <label class="block font-semibold">Favicon</label>
                <input type="file" name="favicon" class="w-full border rounded p-2">
                @if(!empty($setting->favicon))
                    <img src="{{ asset('storage/'.$setting->favicon) }}" class="h-8 mt-2">
                @endif
            </div>

            {{-- Facebook --}}
            <div>
                <label class="block font-semibold">Facebook</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
                        <i class="fab fa-facebook"></i>
                    </span>
                    <input type="url" name="facebook" value="{{ old('facebook', $setting->facebook ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- Instagram --}}
            <div>
                <label class="block font-semibold">Instagram</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-pink-500">
                        <i class="fab fa-instagram"></i>
                    </span>
                    <input type="url" name="instagram" value="{{ old('instagram', $setting->instagram ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- TikTok --}}
            <div>
                <label class="block font-semibold">TikTok</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-black">
                        <i class="fab fa-tiktok"></i>
                    </span>
                    <input type="url" name="tiktok" value="{{ old('tiktok', $setting->tiktok ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- Twitter --}}
            <div>
                <label class="block font-semibold">Twitter</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sky-500">
                        <i class="fab fa-twitter"></i>
                    </span>
                    <input type="url" name="twitter" value="{{ old('twitter', $setting->twitter ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- LinkedIn --}}
            <div>
                <label class="block font-semibold">LinkedIn</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-700">
                        <i class="fab fa-linkedin"></i>
                    </span>
                    <input type="url" name="linkedin" value="{{ old('linkedin', $setting->linkedin ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- YouTube --}}
            <div>
                <label class="block font-semibold">YouTube</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-red-600">
                        <i class="fab fa-youtube"></i>
                    </span>
                    <input type="url" name="youtube" value="{{ old('youtube', $setting->youtube ?? '') }}"
                        class="w-full border rounded p-2 pl-10">
                </div>
            </div>

            {{-- WhatsApp Link --}}
            <div>
                <label class="block font-semibold">WhatsApp Link</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-green-500">
                        <i class="fab fa-whatsapp"></i>
                    </span>
                    <input type="url" name="whatsapp" value="{{ old('whatsapp', $setting->whatsapp ?? '') }}"
                        class="w-full border rounded p-2 pl-10"
                        placeholder="https://wa.me/2547XXXXXXXX">
                </div>
            </div>

            {{-- Tawk.to Script --}}
            <div class="md:col-span-2">
                <label class="block font-semibold">Tawk.to Script</label>
                <textarea name="tawkto" rows="3" class="w-full border rounded p-2"
                    placeholder="Paste your Tawk.to widget code here">{{ old('tawkto', $setting->tawkto ?? '') }}</textarea>
            </div>

            {{-- Google Map Iframe --}}
            <div class="md:col-span-2">
                <label class="block font-semibold">Google Map Iframe</label>
                <textarea name="map_iframe" rows="3" class="w-full border rounded p-2">{{ old('map_iframe', $setting->map_iframe ?? '') }}</textarea>
            </div>

        </div>

        {{-- Submit --}}
        <div class="mt-6">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
