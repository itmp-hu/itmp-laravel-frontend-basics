# 3. modul workshop - Adatmegjelenítés és interakciók

Ebben a modulban létrehozunk egy űrlapot új autó hozzáadására. A helyes adatokat elmentjük az adatbázisba. Hibás input esetén hibaüzenetet jelenítünk meg. Hozzáadunk autó törlése funkciót is. 
**EXTRA** feladatként hozzáadhatjuk a szerkesztés funkciót is.

> **Új ismeretek:**
> - Controller osztály, amely felelős az alkalmazás logikájának kezeléséért, az adatok feldolgozásáért
> - Modell osztály, amely felelős az adatok tárolásáért, az adatbázis-kapcsolat kezeléséért
> - Űrlap létrehozása CSRF védelemmel
> - HTTP metódusok módosítása a `@method(...)` direktívával
> - Validálási hibák megjelenítése, korábbi adatok megőrzése űrlap elküldésekor

## Új create végpont létrehozása
- Hozzunk létre egy új `GET` végpontot a `web.php` fájlban (`/cars/create`), amely megjeleníti `create` nézetet!
- Adjunk nevet a végpontnak: `cars.create`!

    ```php
    Route::get('/cars/create', function () {
        return view('create');
    })->name('cars.create');
    ```

## CarController osztály létrehozása
Adjuk ki a következő parancsot a terminálban:
```bash
php artisan make:controller CarController
```

Ez a parancs létrehoz egy új `CarController` osztályt a `app/Http/Controllers` könyvtárban. Ez az osztály felelős az alkalmazás logikájának kezeléséért, az adatok feldolgozásáért pl. egy `POST` vagy `DELETE` metódus esetén!

Az osztályban hozzuk létre a `store` metódust, amely validálja a kérésben érkező adatokat. Ha nincsenek hibák, akkor elmenti az adatokat az adatbázisba, majd visszairányítja a felhasználót a `cars.create` nevű végpontra!

<details>
<summary><code>CarController</code> osztály <b><code>Store</code></b> metódus...</summary>

```php
function store(Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'start_production' => 'required|integer|min:1900|max:' . date('Y'),
        'class' => 'required|string|max:255',
        'image' => 'url'
    ]);

    $car = Car::create($validated);

    return redirect()->route('cars.create')->with('success', 'Car created successfully.');
    }
```

</details>

## Car modell: szükséges property-k hozzáadása
- Nyissuk meg a `app/Models/Car.php` fájlt!
- Adjunk hozzá a `Car` modellhez a következő property-ket:
    
    ```php
    protected $guarded = [];
    public $timestamps = false;
    ```

A `$guarded` property lehetővé teszti a `Car::create()` metódus használatát. A `$timestamps` property tudatja a modellel hogy nem használjuk a `created_at` és `updated_at` mezőket.

## Új POST végpont létrehozása
- Hozzunk létre egy új `POST` végpontot a `web.php` fájlban (`/cars`), amely segítségével tudunk autót felvenni az adatbázisba! 
- Ezt az végpontot fogjuk meghívni a `create` nézetben a `form` `action` attribútumában!
- Ez a végpont fogja meghívni a `CarController` osztály `store` metódusát, amely elmenti az adatokat az adatbázisba!
- Adjunk nevet a végpontnak: `cars.store`!
    ```php
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
    ```

## Űrlap létrehozása
- Hozzunk létre egy új nézetet `create` néven (`resources/views/create.blade.php`)!
- Alakítsuk ki az űrlapot! Kiindulásként használhatjuk a [Bootstrap](https://getbootstrap.com/docs/5.3/forms/overview/) formokat!
- Az űrlap input mezőinek `name` tulajdonsága pontosan egyezzen meg a `cars` tábla mezőinek nevével! Például:
    ```html
    <input type="text" class="form-control" id="title" name="title">
    ```
- Az űrlapban használjuk a `@csrf` direktívát, amely biztosítja a Cross-Site Request Forgery (CSRF) védelmet.
- Az űrlap `method` attribútumában `POST` legyen!
- Az űrlap `action` attribútumában adjuk meg a `cars.store` végpontot!
    ```html
    <form method="POST" action="{{ route('cars.store') }}">
        @csrf
        ...
    </form>
    ```

## Üzenetek megjelenítése a layout viewban
- A `layouts.blade.php` komponensben adjuk hozzá a `@session('success')` direktívát, amely megjeleníti a sikeres üzenetet, ha létezik!

    ```php
    @session('success')
        <div class="alert alert-success">{{ session('success') }}</div>
    @endsession
    ```
- Ugyanígy adjuk hozzá a ```@session('error')``` direktívát, amely megjeleníti a hibaüzenetet, ha létezik!

## Korábbi adatok megjelenítése az űrlap elküldésekor
Módosítsuk a `crete.blade.php` nézetet, hogy a korábbi adatokat megőrizze az űrlap sikertelen elküldésekor! Minden input mezőhöz adjuk hozzá a `value` attribútumot, amely az `old()` függvény segítségével megkapja a korábbi adatokat! Például:

```php
<input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
```

## Validálási hibák megjelenítése
A `CarController` osztály `store` metódusában használt `validate()` metódus validálja a kérésben érkező adatokat. Ha valamelyik mező értéke nem megfelelő, akkor automatikusan visszairányítja a felhasználót a `cars.create` végpontra és a hibákat a `session` objektum `error` tulajdonságában tárolja!

Módosítsuk a `crete.blade.php` nézetet, hogy a validálási hibákat megjelenítse!

Amennyiben egy adott mezőhöz van hibaüzenet, akkor a Bootstrap `is-invalid` osztályát adjuk hozzá a mezőhöz, amely pirosra változtatja a mezőt! Például:
    
```php
<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{old('title')}}">
```

A hibaüzenet szövegét (ha van) az `invalid-feedback` Bootstrap osztályba sorolt `div` segítségével megjelenítjük! Például:
    
```php
@error('title')
    <div class="invalid-feedback">{{$message}}</div>
@enderror
```

## Autó törlése

### DELETE végpont létrehozása
- Hozzunk létre egy új `DELETE` végpontot (`/cars/{car}`) a `web.php` fájlban!
- Ez a végpont fogja meghívni a `CarController` osztály `destroy` metódusát, amely törli az adott autót az adatbázisból!
- Adjunk nevet a végpontnak: `cars.destroy`!

    ```php
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    ```

### destroy metódus implementálása a CarController osztályban
- Hozzunk létre egy új metódust a `CarController` osztályban `destroy` néven!
- A metódusnak egy autó azonosítóját (`$id`) kell átadni paraméterként!
- A metódusban megkeressük és (ha van) töröljük az adott autót az adatbázisból!
- A metódusból térjünk vissza a `cars.index` végpontra! (Ha eddig nem tettük meg, akkor nevezzük el a `web.php` fájlban a `cars` végpontot: `cars.index`!)

<details>
<summary><code>CarController</code> osztály <b><code>destroy</code></b> metódus...</summary>

```php
function destroy($id) {
    $car = Car::find($id);
    if (!$car) {
        return redirect()->route('cars.index')->with('error', 'No car found.');
    }

    $car->delete();
    return redirect()->route('cars.index')->with('success', 'Car deleted successfully.');
}
```
</details>

### Törlés gomb hozzáadása a cardhoz
- Módosítsuk a `card.blade.php` nézetet, hogy a törlés gombot tartalmazza!
- A törléshez egy formot kell használni, amelyben a metódust `DELETE`-re kell módosítani a `@method('DELETE')` direktívával!
- A form `action` attribútumában hívjuk meg a `cars.destroy` végpontot! A végpontnak át kell adni az autó azonosítóját (`$car->id`)!
- Ne feledjük a `@csrf` direktívát hozzáadni a formhoz!
- A törlés gomb submit típusú legyen!

<details>
<summary><b>Törlés</b> gomb...</summary>

```html
<form action="{{route('cars.destroy', $car->id)}}" method="post"
    onsubmit="return confirm('Are you sure to delete this car?');">
    @csrf
    @method('DELETE')
    <input type="submit" class="btn btn-danger" value="Delete"/>
</form>
```

</details>

## EXTRA: Autó szerkesztése
Hozzunk létre két új végpontot a `web.php` fájlban:
    - `GET`: `/cars/{id}/edit`, name: `cars.edit`
    - `PUT`: `/cars/{id}`, name: `cars.update`

```php
Route::get('/cars/{id}/edit', [CarController::class, 'edit'])->name('cars.edit');
Route::put('/cars/{id}', [CarController::class, 'update'])->name('cars.update');
```

Hozzunk létre egy új metódust a `CarController` osztályban `edit` néven!
- A metódusnak egy autó azonosítóját (`$id`) kell átadni paraméterként!
- A metódusban az `$id` alapján megkeressük az autót és (ha van) meghívjuk az `edit` nézetet az autó adataival!

<details>
<summary><b>Edit</b> metódus...</summary>

```php
public function edit(string $id)
{
    $car = Car::find($id);
    return view('edit', ['car' => $car]);
}
```

</details>

Hozzunk létre egy új metódust a `CarController` osztályban `update` néven!
- A metódusnak egy autó adatait tartalmazó tömböt (`$request`) és az autó azonosítóját (`$id`) kell átadni paraméterként!
- A metódusban ellenőrizzük, hogy a kérésben érkezett adatok megfelelnek-e a validálási szabályoknak!
- Ha a validálás sikeres, akkor `$id` alapján megkeressük és az `update()` metódus segítségével frissítjük az autót az adatbázisban!

<details>
<summary><b>Update</b> metódus...</summary>

```php
public function update(Request $request, string $id)
{
    $car = Car::find($id);
    
    $validated = $request->validate([
        'image' => 'required|url',
        'title' => 'required|string|max:255',
        'start_production' => 'required|integer|min:1886|max:' . date('Y'),
        'class' => 'required|string|max:255',
    ]);

    $car->update($validated);

    return redirect()->route('cars.index')->with('success', 'Car updated successfully!');
}
```

</details>

Hozzunk létre egy új nézetet `edit` néven (`resources/views/edit.blade.php`): 
- Duplikáljuk majd nevezzük át a `create.blade.php` nézetet!
- Az űrlap `action` attribútumában havjuk meg a `cars.update` végpontot az autó azonosítójával!   
- A formon belül a `@method('PUT')` direktívával módisítsuk a metódust!

```html
<form action="{{ route('cars.update', $car->id) }}" method="POST">
    @csrf
    @method('PUT')
    ...
</form>
```

- Minden input mezőnek adjuk meg a `value` attribútumát a paraméterben kapott auto megfelelő mezőjével! Például:

```html
<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $car->title) }}">
```

Adjuk hozzá a módosítás gombot a `card.blade.php` nézethez!

```html
<a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">Edit</a>
```

