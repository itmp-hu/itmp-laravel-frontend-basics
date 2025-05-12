<x-layout>
    <x-slot name="title">Edit car</x-slot>

    <form method="POST" action="{{route('cars.update', $car->id)}}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror
            " id="title" name="title" value="{{old('title', $car->title)}}">
            @error('title')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image URL</label>
            <input type="url" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{old('image', $car->image)}}">
            @error('image')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="start_production" class="form-label">Start of production</label>
            <input type="number" class="form-control @error('start_production') is-invalid @enderror" id="start_production" name="start_production" value="{{old('start_production', $car->start_production)}}">
            @error('start_production')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="class" class="form-label">Class</label>
            <input type="text" class="form-control @error('class') is-invalid @enderror" id="class" name="class" value="{{old('class', $car->class)}}">
            @error('class')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</x-layout>
