<!-- resources/views/components/dashboard-box.blade.php -->
@props(['title', 'value'])

<div class="bg-white shadow rounded-lg p-4">
    <h4 class="text-sm font-medium text-gray-500">{{ $title }}</h4>
    <div class="text-2xl font-bold text-blue-900 mt-2">{{ $value }}</div>
</div>
