@props(['id', 'label', 'type' => 'text', 'required' => false])

<div class="space-y-2">
  <label for="{{ $id }}" class="block text-sm font-medium">{{ $label }}</label>
  <input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}"
         class="w-full border border-gray-300 rounded px-3 py-2"
         @if($required) required @endif
         value="{{ old($id) }}">
</div>
