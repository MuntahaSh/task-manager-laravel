{{-- I keep the same form for create and edit. --}}
<div class="field">
    <label for="title">Title</label>
    <input id="title" type="text" name="title" value="{{ old('title', $task->title ?? '') }}" maxlength="255" required>
    @error('title')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>

<div class="field">
    <label for="description">Description</label>
    <textarea id="description" name="description" maxlength="2000" placeholder="What needs to be done?">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>

<div class="field">
    <label for="status">Status</label>
    <select id="status" name="status" required>
        @foreach ($statusOptions as $value => $label)
            <option value="{{ $value }}" @selected(old('status', $task->status ?? 'pending') === $value)>{{ $label }}</option>
        @endforeach
    </select>
    @error('status')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>

<div class="field">
    <label for="due_date">Due date</label>
    <input id="due_date" type="date" name="due_date" value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
    @error('due_date')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>
