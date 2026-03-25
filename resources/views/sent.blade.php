@extends('layouts.app')

@section('title', 'Sent Messages')

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 max-h-[500px] overflow-y-auto">
    <h1 class="text-2xl font-bold mb-4 text-center">Sent Messages</h1>

    <div class="space-y-4">
        @forelse($messages as $msg)
            <div class="flex justify-end">
                <div class="bg-green-100 text-gray-900 p-3 rounded-lg rounded-br-none max-w-xs break-words">
                    <p class="font-semibold text-sm">{{ $msg->phone }}</p>
                    <p>{{ $msg->message }}</p>
                    <span class="text-xs text-gray-500 mt-1 block">{{ $msg->created_at->format('H:i, M d') }}</span>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">No sent messages yet.</p>
        @endforelse
    </div>
</div>
@endsection