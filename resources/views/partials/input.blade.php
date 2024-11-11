<div class="form-group">
    <h3>{{ $label }}</h3>
    <input name="{{ $name }}" type="{{ $type ?? 'text' }}" value="{{ $value ?? old($name) }}"
        placeholder="{{ $placeholder ?? '' }}" {{ isset($required) && $required ? 'required' : '' }}>
    @error('{{ $name }}')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
