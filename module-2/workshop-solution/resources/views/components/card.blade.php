<div class="card h-100">
    <img src="{{ $car->image }}" class="card-img-top" alt="{{ $car->title }}"
        onerror="this.onerror=null; this.src='/images/default-car.jpg';">
    <div class="card-body">
        <h5 class="card-title">{{ $car->title }}</h5>
        <p class="card-text">Start of production: {{ $car->start_production }}</p>
        <p class="card-text">Class: {{ $car->class }}</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
</div>
