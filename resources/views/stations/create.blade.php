@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Create Station</h1>

    <form id="create-station-form" method="POST" action="{{ route('stations.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="name">Station Name</label>
            <input type="text" id="name" name="name" class="w-full border rounded p-2">
            <small class="text-red-600 hidden" id="error-name"></small>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="description">Description</label>
            <textarea id="description" name="description" class="w-full border rounded p-2"></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="image">Image</label>

            <label for="image" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-5 4l-4-4h8l-4 4z" />
                    </svg>
                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500">PNG, JPG (MAX. 5MB)</p>
                </div>
                <input id="image" name="image" type="file" class="hidden" />
            </label>
            <p id="file-name" class="text-lg mt-2 text-gray-700"></p>

            <small class="text-red-600 hidden" id="error-image"></small>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="src">Source</label>
            <input type="text" id="src" name="src" class="w-full border rounded p-2">
            <small class="text-red-600 hidden" id="error-src"></small>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="country_id">Country</label>
            <select id="country_id" name="country_id" class="w-full border rounded p-2">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                @endforeach
            </select>
            <small class="text-red-600 hidden" id="error-country_id"></small>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="city_id">City</label>
            <select id="city_id" name="city_id" class="w-full border rounded p-2">
                <option value="">Select City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->city }}</option>
                @endforeach
            </select>
            <small class="text-red-600 hidden" id="error-city_id"></small>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="language_id">Language</label>
            <select id="language_id" name="language_id" class="w-full border rounded p-2">
                <option value="">Select Language</option>
                @foreach ($languages as $language)
                    <option value="{{ $language->id }}">{{ $language->language }}</option>
                @endforeach
            </select>
            <small class="text-red-600 hidden" id="error-language_id"></small>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="type">Type</label>
            <input type="text" id="type" name="type" class="w-full border rounded p-2">
            <small class="text-red-600 hidden" id="error-type"></small>
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create Station
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    console.log("dsfgf");

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
