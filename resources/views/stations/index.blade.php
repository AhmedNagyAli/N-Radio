@extends('layouts.app')

@section('header')
    @include('components.header')
@endsection

@section('content')
<section class="py-24 bg-zinc-950">
    <div class="container px-4 mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 mb-12 md:mb-20">
            @foreach ($stations as $station)
                <div class="bg-zinc-900 shadow-xl overflow-hidden transition transform hover:scale-[1.02] duration-300">
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
                            <div class="bg-zinc-950 p-3 rounded-lg shadow-inner flex items-center justify-between">
                                <button
    class="play-button w-full text-white bg-indigo-950 hover:bg-indigo-700 px-4 py-2 rounded"
    data-src="{{ $station->src }}"
    data-title="{{ $station->name }}"
    data-image="{{ asset('storage/'.$station->image) }}">
    ▶️ Play
</button>

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
<div id="bottom-player" class="fixed bottom-0 left-0 right-0 bg-zinc-900 text-white p-4 flex items-center justify-between shadow-lg hidden z-50">
    <div class="flex items-center gap-4">
        <img id="player-image" src="" alt="Station image" class="w-14 h-14 object-cover rounded-md">
        <span id="player-title" class="font-bold text-lg"></span>
    </div>
    <audio id="main-audio" controls class="w-full max-w-md"></audio>
</div>
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
<script>
    const allPlayers = document.querySelectorAll('audio');

    allPlayers.forEach(player => {
        player.addEventListener('play', () => {
            allPlayers.forEach(other => {
                if (other !== player) {
                    other.pause();
                }
            });
        });
    });
</script>
<script>
    const mainAudio = document.getElementById('main-audio');
    const bottomPlayer = document.getElementById('bottom-player');
    const playerTitle = document.getElementById('player-title');
    const playerImage = document.getElementById('player-image');

    document.querySelectorAll('.play-button').forEach(button => {
        button.addEventListener('click', () => {
            const src = button.getAttribute('data-src');
            const title = button.getAttribute('data-title');
            const image = button.getAttribute('data-image');

            mainAudio.src = src;
            playerTitle.textContent = title;
            playerImage.src = image;
            bottomPlayer.classList.remove('hidden');
            mainAudio.play();
        });
    });

    window.addEventListener('beforeunload', () => {
        mainAudio.pause();
    });
</script>




@endsection
