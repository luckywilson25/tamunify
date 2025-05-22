@section('title', 'Notifikasi')
@section('header', 'Notifikasi')

<x-app-layout>
    <div class="p-6 flex-grow">
        @if (session()->has('success'))
        <x-alert.success :message="session('success')" />
        @endif

        <form method="POST" class="mt-3 mb-3" action="{{ route('notifications.markAsRead') }}">
            @csrf
            <x-button.default-button type="submit"
                class="mb-4 border-[#006838] text-white bg-[#006838] hover:bg-[#005830]">
                Tandai Sudah Dibaca
            </x-button.default-button>
        </form>

        <ul class="list bg-base-100 rounded-box shadow-md">
            @forelse (Auth::user()->notifications as $notification)
            <li class="list-row">
                <div>
                </div>
                <div>
                    <div class="uppercase font-bold">{{ $notification->data['type'] ?? 'Notifikasi' }}</div>
                    <div class="text-sm">
                        {{ $notification->data['message'] }}
                    </div>
                    <div class="text-xs uppercase opacity-60">
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>
                @if(is_null($notification->read_at))
                <span class="badge badge-warning text-xs">Belum dibaca</span>
                @endif
            </li>
            @empty
            <li class="p-4 text-center text-sm text-gray-500">Tidak ada notifikasi</li>
            @endforelse
        </ul>
    </div>
</x-app-layout>