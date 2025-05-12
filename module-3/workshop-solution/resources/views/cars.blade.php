<x-layout>
    <x-slot name="title">Cars</x-slot>

    <div class="row">
        @forelse ($cars as $car)
            <div class="col-md-3 mb-3">
                <x-card :car="$car"></x-card>
            </div>
        @empty
            <p>No cars found.</p>
        @endforelse
    </div>

</x-layout>
