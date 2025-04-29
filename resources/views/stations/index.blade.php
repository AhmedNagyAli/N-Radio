@extends('layouts.app')

@section('header')
    @include('components.header')
@endsection

@section('content')
<section class="py-24 bg-zinc-950">
    <div class="container px-4 mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 mb-12 md:mb-20">
            @foreach ($stations as $station)
                <div class="bg-indigo-900 rounded-2xl shadow-xl overflow-hidden transition transform hover:scale-[1.02] duration-300">
                    <a href="#">
                        <img class="w-full h-[300px] object-cover" src="{{ asset('storage/'.$station->image) }}" alt="{{ $station->name }}">
                    </a>
                    <div class="p-6 space-y-4">
                        <a class="inline-block px-4 py-1 text-sm font-semibold text-indigo-700 bg-indigo-100 rounded-full uppercase tracking-wide hover:bg-indigo-200 transition" href="#">
                            {{ $station->name }}
                        </a>
                        <p class="text-white text-base font-medium">
                            {{ $station->country->country }}
                        </p>
                        <h3 class="text-2xl text-white font-bold leading-tight">
                            <a href="#" class="hover:underline">{{ $station->description }}</a>
                        </h3>
                        <p class="text-white text-base">{{ $station->type }}</p>
                        <p class="text-white text-base">{{ $station->city->city }}</p>

                        <div class="pt-4">
                            <div class="bg-white p-3 rounded-lg shadow-inner flex items-center justify-between">
                                <audio controls class="w-full focus:outline-none">
                                    <source src="{{ $station->src }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>

                                @auth
    <button
        class="like-button ml-4 text-gray-500 hover:text-red-500 transition"
        data-id="{{ $station->id }}">
        @if(auth()->user()->favoriteStations->contains($station->id))
            <i class="fas fa-heart text-red-500 text-2xl"></i>
        @else
            <i class="far fa-heart text-2xl"></i>
        @endif
    </button>
@else
    <a href="{{ route('login') }}" class="ml-4 text-gray-500 hover:text-red-500 transition">
        <i class="far fa-heart text-2xl"></i>
    </a>
@endauth

                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-10 text-white">
            {{ $stations->links() }}
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function () {
            const stationId = this.dataset.id;
            const icon = this.querySelector('i');

            fetch(`/stations/${stationId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
    // Toggle heart icon
    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas', 'text-red-500');

        Swal.fire({
            icon: 'success',
            title: '<span style="font-size:6rem;">❤️</span>',
            html: '<strong style="font-size:1.5rem;">Station added to your favorites successfully.</strong>',
            timer: 2000,
            showConfirmButton: false,
        });
    } else {
        icon.classList.remove('fas', 'text-red-500');
        icon.classList.add('far');
    }
})
.catch(error => {
    console.error('Error:', error);

    Swal.fire({
        icon: 'error',
        title: '<span style="font-size:3rem;">💔</span>',
        html: '<strong style="font-size:1.25rem;">Something went wrong.</strong>',
        timer: 2000,
        showConfirmButton: false,
    });
});

        });
    });
</script>

@endsection
