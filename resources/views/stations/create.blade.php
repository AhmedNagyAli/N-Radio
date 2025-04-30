@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-zinc-950 px-6 py-12">
<div class="max-w-4xl mx-auto mt-10 p-6 bg-zinc-900 text-white rounded-2xl shadow-lg border border-gray-700">
    <h1 class="text-3xl font-bold mb-6 text-white">🎙️ Create a New Station</h1>

    <form id="create-station-form" method="POST" action="{{ route('stations.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <!-- Station Name -->
        <div>
            <label class="block text-sm font-medium mb-1" for="name">Station Name <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 focus:ring focus:ring-blue-500 text-white">
            <small class="text-red-400 hidden" id="error-name"></small>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium mb-1" for="description">Description</label>
            <textarea id="description" name="description" rows="4" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 text-white"></textarea>
        </div>

        <!-- Image Upload -->
        <div>
            <label class="block text-sm font-medium mb-1">Image</label>
            <label for="image" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-500 rounded-lg cursor-pointer bg-gray-800 hover:bg-gray-700 transition">
                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-400">
                    <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-5 4l-4-4h8l-4 4z" />
                    </svg>
                    <p class="mb-1 text-sm"><span class="font-semibold">Click to upload</span> or drag</p>
                    <p class="text-xs">PNG, JPG (MAX. 5MB)</p>
                </div>
                <input id="image" name="image" type="file" class="hidden" />
            </label>
            <p id="file-name" class="text-sm mt-2 text-gray-300"></p>
            <small class="text-red-400 hidden" id="error-image"></small>
        </div>

        <!-- Source -->
        <div>
            <label class="block text-sm font-medium mb-1" for="src">Source URL <span class="text-red-500">*</span></label>
            <input type="text" id="src" name="src" class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 text-white">
            <small class="text-red-400 hidden" id="error-src"></small>
        </div>

        <!-- Dropdown Fields -->
        @foreach ([
            'country_id' => $countries,
            'city_id' => $cities,
            'language_id' => $languages
        ] as $id => $collection)
            <div>
                <label class="block text-sm font-medium mb-1 capitalize" for="{{ $id }}">{{ str_replace('_', ' ', $id) }} <span class="text-red-500">*</span></label>
                <select id="{{ $id }}" name="{{ $id }}" class="w-full p-3 bg-gray-800 border border-gray-700 text-white rounded-lg">
                    <option value="">Select</option>
                    @foreach ($collection as $item)
                        <option value="{{ $item->id }}">{{ $item->country ?? $item->city ?? $item->language }}</option>
                    @endforeach
                </select>
                <small class="text-red-400 hidden" id="error-{{ $id }}"></small>
            </div>
        @endforeach

        <!-- Type -->
        <div>
            <label class="block text-sm font-medium mb-1" for="type">Station Type <span class="text-red-500">*</span></label>
            <input type="text" id="type" name="type" class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg text-white">
            <small class="text-red-400 hidden" id="error-type"></small>
        </div>

        <!-- Tags -->
        <div>
            <label class="block text-sm font-medium mb-1" for="tags">Tags</label>
            <select name="tags[]" id="tags" multiple class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg text-white">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                @endforeach
            </select>
            <small class="text-red-400 hidden" id="error-tags"></small>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
            🚀 Create Station
        </button>
    </form>
</div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function() {
        $('#create-station-form').on('submit', function(e) {
            e.preventDefault();

            let hasError = false;

            // Clear old errors (only hide <small> elements)
            $('small[id^="error-"]').addClass('hidden').text('');

            // Validate fields manually
            const requiredFields = ['name', 'src', 'country_id', 'city_id', 'language_id', 'type'];
            requiredFields.forEach(function(field) {
                const value = $('#' + field).val();
                if (!value) {
                    hasError = true;
                    $('#error-' + field).text('This field is required.').removeClass('hidden');
                }
            });

            if (hasError) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill all required fields!',
                });
                return;
            }

            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '{{ route('stations.store') }}',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'Accept': 'application/json'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                    $('#create-station-form')[0].reset();
                    // Hide all error messages after success
                    $('small[id^="error-"]').addClass('hidden').text('');
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Show field-specific errors from backend too if any
                        $.each(xhr.responseJSON.errors, function(key, messages) {
                            $('#error-' + key).text(messages[0]).removeClass('hidden');
                        });
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please fix the errors and try again!',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        $('#image').change(function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                $('#file-name').text(fileName);
            } else {
                $('#file-name').text('');
            }
        });
    });
</script>
@endsection
