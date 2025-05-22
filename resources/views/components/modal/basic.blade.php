<dialog id="{{ $id }}" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box w-11/12 max-w-5xl">
        <h3 class="text-lg font-bold">{{ $title }}</h3>
        {{ $slot }}
    </div>
</dialog>