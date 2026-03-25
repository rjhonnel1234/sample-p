@extends('layouts.app')

@section('title', 'Send  Message')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Send WhatsApp Message</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/send') }}" class="space-y-4">
        @csrf

        <div>
            <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number</label>
            <input type="text" name="phone" id="phone" placeholder="+639XXXXXXXXX"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>

        <div>
            <label for="message" class="block text-gray-700 font-medium mb-1">Message</label>
            <textarea name="message" id="message" rows="4" placeholder="Type your message here..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required></textarea>
        </div>

        <button type="submit"
            class="w-full bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-500 transition">
            Send Message
        </button>
    </form>
</div>
@endsection
