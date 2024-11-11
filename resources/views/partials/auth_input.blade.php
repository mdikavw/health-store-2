<div class="flex flex-col gap-2">
    <label class="text-sm" for="{{ $name }}">{{ $label }}</label>
    <input class="{{ $class ?? 'w-full px-4 py-2 rounded-lg border-solid border-[1px] border-slate-700' }}"
        id="{{ $name }}" name="{{ $name }}" type="{{ $type ?? 'text' }}" value="{{ $value ?? old($name) }}"
        {{ isset($disabled) && $disabled ? 'disabled' : '' }} placeholder="{{ $placeholder ?? '' }}" required>
    @error($name)
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
