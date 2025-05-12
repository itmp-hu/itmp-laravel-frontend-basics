# 2. modul workshop - Blade sablonok és komponensek

Ebben a modulban megismerjük a Blade sablonnyelvet, amely segítségével könnyen és gyorsan tudunk HTML oldalakat készíteni. Ennek segítségével megjelenítünk autókat. A designt a [Bootstrap](https://getbootstrap.com/) segítségével valósítjuk meg.

> **Feladatok:**  
> - Beimportáljuk a kiinduló adatokat SQLite adatbázisba (`cars.sql`). 
> - Létrehozzuk a `Car` modellt, az adatbázisban lévő adatok eléréséhez.
> - Létrehozunk egy végpontot.
> - Layout komponens segítségével kialakítunk egy egységes és konzisztens felületet.
> - A `Car` modell segítségével megjelenítjük az adatokat egy nézetben.
> - Létrehozunk egy komponenst egy adott autó adatainak megjelenítésére.
> - **EXTRA**: menü komponens létrehozása (`nav`)

## Kiinduló adatok importálása SQLite adaatbázisba

Telepítsük fel az **SQLite3 Editor** extension-t a VS Code-ba! Ennek segítségével importálhatjuk az autókat tartalmazó adatokat az SQLite adatbázisba: 
- Másoljuk a projektünk `database` könyvtárába, majd nyissuk meg a `cars.sql` fájlt a `module-2/workshop-sources/` mappából.
- Ha fel van telepítve az SQLite3 Editor extension, akkor a fájl tetején megjelenik a **Connect** link. Kattintsunk rá és kapcsolódjunk a `databese.sqlite` adatbázishoz!
- Ha sikeresen csatlakoztunk, a `CREATE TABLE` és az `INSERT` utasítok felett megjelenik az **Execute** felirat. Kattintsunk rá és futtassuk le a parancsokat!
- Ellenőrizzük, hogy sikeres volt-e az importálás: nyissuk meg a `database.sqlite` állományt a `database` mappából! Válasszuk ki a `cars` táblát és ellenőrizzük, hogy az adatok megjelennek-e!

## Modell létrehozása

- Nyissunk egy terminál ablakot!
- Ellenőrizzük, hogy a projekt gyökérkönyvtárában vagyunk-e!
- Adjuk ki a következő parancsot:

    ```bash
    php artisan make:model Car
    ```

Ezzel létrejön a `app/Models` mappában a `Car.php` állomány és a `Car` modell. A `Car` modellen keresztül fogjuk elérni az adatbázis `cars` táblájában lévő adatokat.

## Végpont létrehozása

Hozzunk létre egy új `GET` végpontot az autók adatainak megjelenítésére!

- Nyissuk meg a `routes/web.php` fájlt!
- Adjuk hozzá a következő kódot a fájl végére:

    ```php
    Route::get('/cars', function () {
        return view('cars', ['cars' => Car::all()]);
    });
    ```
- Figyeljük arra, hogy a `Car` modellt importáljuk a fájl elején!

    ```php
    use App\Models\Car;
    ```

## Layout kialakítása

- Hozzunk létre egy új anoním komponenst:

    ```bash
    php artisan make:component Layout --view
    ```

- Alakítsuk ki a HTML oldal vázát a `resources/views/components/layout.blade.php` fájlban!
- A formázáshoz importáljuk a [Bootstrap](https://getbootstrap.com/) CSS-t a HTML oldal `head` részébe!
- Az oldal `body` részébe helyezzük el a `{{ $slot }}` utasítást!
- A meglévő oldalainkat (pl. `home`, `users`, `about`) szervezzük át a `layout` komponensbe:
    - Töröljük a `layout`-ba helyezett közös részeket!
    - Az oldalak tartalmát helyezzük az `<x-layout>...</x-layout>` blokkba!
- Alakítsunk ki egységes `header` részt a `layout` komponensben! Például:
   ```html
   <h1 class="mb-3 p-5 text-center bg-dark text-white">{{ $title ?? 'Home' }}</h1>
   ```
- A meglévő oldalainkban (pl. `users`, `about`) hozzunk létre egy új <x-slot> taget, amelyben megadjuk a `layout`-nak átadandó `title` értéket! Például:
   ```html
   <x-slot name="title">Users</x-slot>
   ```


## Adatok megjelenítése a nézetben

- Hozzunk létre egy új fájlt a `resources/views/` mappában `cars.blade.php` néven!
- A nézet paraméterként megkapja a `cars` tömböt, amelyet a végpontunkban adtunk át neki.
- Használjuk a `@foreach` vagy `@forelse` utasítást a `cars` tömb elemeinek megjelenítéséhez!
- Az egyes autókat jelenítsük meg tetszőleges elrendezésben például egy [Bootstrap `card`](https://getbootstrap.com/docs/5.3/components/card/)-ban!
- Az `Car` osztály egyes mezőit a `->` operátorral érhetjük el! Például:

   ```html
   <h5 class="card-title">{{ $car->title }}</h5>
   ```

## Komponens létrehozása

Áttekinthetőbb kódot kapunk, ha az egyes autók adatait külön komponensben jelenítjük meg.

Ehhez hozzunk létre egy új osztály alapú komponenst:
```bash
php artisan make:component Card
```

Ezzel két állomány jön létre:
- `app/View/Components/Card.php`
- `resources/views/components/card.blade.php`

Szerkesszük a `Card.php` fájlt! A konstruktorban adjuk át a `$car` objektumot a komponensnek!
```php
public function __construct(public Car $car) {}
```

Helyezzük át a `cars.blade.php` nézteből a `@foreach` vagy `@forelse` utasításában lévő, egy autó megjelenítéséért felelős `<div class="card>...</div>` elem teljes tartalmát a `card.blade.php` fájlba, és a helyén jelenítsük meg a `card` komponenst! Ne felejtsük átadni a `$car` objektumot a komponensnek!
```html
<x-card :car="$car" />
```

<details>
<summary>Ha a következő üzenet kapjuk: <b>Unresolvable dependency...</b></summary>
Ha egy komponens osztályban változtatunk valamit (pl. új paramétert adunk a konstruktornak) néha szükséges a cache törlése. Enélkül az alábbi hibaüzenetet kaphatjuk:

```Unresolvable dependency resolving [Parameter #0...]```

Megoldás: az összes cache-elt fájl törlése az alábbi paranccsal:

```php artisan optimize:clear```

</details>

## EXTRA: Menü létrehozása

Segítsük az egyes oldalak elérését egy menü létrehozásával! 
- A korábban megtanultak alapján hozzunk létre egy új komponenst a menü megjelenítésére!

    ```bash
    php artisan make:component nav --view
     ```

- A menü kialakításához használjuk pl. a [Bootstrap `navbar`](https://getbootstrap.com/docs/5.3/components/navbar/) css osztályát! 
- Helyezzük el a menüt a `layout` komponensben!
    ```html
    <x-nav></x-nav>
    ```
- A menüben jelenítsük meg a meglévő oldalainkat (pl.: `home`, `users`, `cars`)!

<details>
<summary>Minta menü megtekintése...</summary>

```html
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Cars</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cars">Cars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cars/create">New car</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
```

</details>

