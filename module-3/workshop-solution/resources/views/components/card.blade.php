<div class="card h-100">
    <img src="{{ $car->image }}" class="card-img-top" alt="{{ $car->title }}"
        onerror="this.onerror=null; this.src='/images/default-car.jpg';">
    <div class="card-body">
        <h5 class="card-title">{{ $car->title }}</h5>
        <p class="card-text">Start of production: {{ $car->start_production }}</p>
        <p class="card-text">Class: {{ $car->class }}</p>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{route('cars.destroy', $car->id)}}" method="post"
                onsubmit="return confirm('Are you sure to delete this car?');">
                @csrf
                @method('DELETE')
                <input type="submit" class="btn btn-danger" value="Delete"/>
            </form>
        </div>
    </div>
</div>
