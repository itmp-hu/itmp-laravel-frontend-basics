# Laravel Frontend: 2. modul - Blade sablonok és komponensek

- Bevezetés: Mire jó a Blade?
- Blade direktívák
- Blade komponensek
- Anoním komponensek
- Layout építése komponensekkel
- Űrlapok kezelése

---

## Bevezetés – Mire jó a Blade?

A **Blade** a Laravel beépített sablonmotorja, amely tiszta, olvasható szintaxist biztosít a dinamikus HTML generálásához. Segítségével egyszerűen valósíthatók meg komponens-alapú nézetek, öröklődéses sablonstruktúrák, ciklusok, elágazások és űrlapkezelés.  
A Blade fájlok a `resources/views/` mappában `.blade.php` kiterjesztéssel helyezkednek el.

---

## Blade direktívák

A Blade direktívák olyan speciális utasítások, amelyek egyszerűsítik a PHP-kód beágyazását a Blade sablonokba. Laravel számos beépített direktívát biztosít, és saját direktívákat is létrehozhatunk.

Blade direktívák nélkül:
```php
<?php echo $user->name; ?>
```

Blade direktívák használatával:
```php
{{ $user->name }}
```

---

## Adatok megjelenítése

Blade-ben a `{{ }}` szintaxist használjuk adatok biztonságos megjelenítésére (XSS elleni védelem):

```php
<p>{{ $user->name }}</p>
```

Ha HTML tartalmat is meg szeretnél jeleníteni (biztonsági kockázat!), használd a `{!! !!}` direktívát:

```php
{!! $post->content !!}
```



### Feltételes direktívák

- @if, @elseif, @else
    ```php
    @if($user->isAdmin())
        <p>Admin felhasználó vagy.</p>
    @elseif($user->isModerator())
        <p>Moderátor vagy.</p>
    @else
        <p>Átlagos felhasználó vagy.</p>
    @endif
    ```

- @unless - Akkor fut, ha a feltétel **hamis**.
    ```php
    @unless($user->isSubscribed())
        <p>Kérjük, iratkozz fel!</p>
    @endunless
    ```

- @isset, @empty
    ```php
    @isset($post)
        <p>{{ $post->title }}</p>
    @endisset

    @empty($comments)
        <p>Nincsenek hozzászólások.</p>
    @endempty
    ```

### Ciklusok
- @foreach
    ```php
    @foreach ($posts as $post)
        <li>{{ $post->title }}</li>
    @endforeach
    ```

- @forelse - Hasznos üres tömb esetén.
    ```php
    @forelse($posts as $post)
        <p>{{ $post->title }}</p>
    @empty
        <p>Nincsenek bejegyzések.</p>
    @endforelse
    ```

- További ciklusok:
    ```php
    @for  ... @endfor

    @while  ... @endwhile
    ```

### Hitelesítés és jogosultság
- @auth, @guest
    ```php
    @auth
        <p>Üdv, {{ auth()->user()->name }}!</p>
    @endauth

    @guest
        <p>Kérjük, jelentkezz be!</p>
    @endguest
    ```

- @can, @cannot
    ```php
    @can('delete', $post)
        <button>Törlés</button>
    @endcan
    ```

### Egyéb direktívák
- CSRF védelem
    ```php
    <form method="POST">
        @csrf
    </form>
    ```
- Validációs hiba megjelenítése
    ```php
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror
    ```

---

## Blade komponensek

A Blade komponensek lehetővé teszik, hogy újra felhasználható, tiszta és moduláris HTML + PHP sablonokat hozzunk létre. A komponensek különösen hasznosak, ha ugyanazt a struktúrát több helyen is szeretnénk megjeleníteni – például gombokat, kártyákat, vagy űrlapmezőket.

Lehetnek:

- Anoním komponensek (nincs külön PHP osztály)
- Osztály alapú komponensek

Komponensek létrehozása: `php artisan make:component`


### Osztály alapú komponens létrehozása

```sh
php artisan make:component Alert
```

Ez létrehozza:
- `app/View/Components/Alert.php`
- `resources/views/components/alert.blade.php`

#### Alert komponens – `alert.blade.php`

```php
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>
```

#### Alert komponens – PHP osztály (részlet)

```php
class Alert extends Component
{
    public function __construct(public string $type = 'info') {}
}
```

#### Használat Blade-ben

Blade komponens használatához egyszerűen hivatkozhatunk rá HTML-szerű szintaxissal.

```php
<x-alert type="success">
    Sikeres mentés!
</x-alert>
```

**Mi az az `<x-...>` szintaxis?**

Ez a Laravel Blade saját **komponens direktívája**, amivel meghívod a komponensedet. 

**Miért hasznos?**

- **Újrafelhasználhatóság** – egyszer írunk meg egy elrendezést, és sok helyen használhatjuk.
- **Olvashatóság** – a nézetek tisztábbak és karbantarthatóbbak lesznek.
- **Komponens-alapú gondolkodás** – hasonlóan működik, mint a JavaScript keretrendszerekben a komponensek.


### Adat átadása komponensnek
A komponensek paramétereket is fogadhatnak HTML attribútumok formájában:

```php
<x-alert type="error" message="Hiba történt!" />
```

Ehhez a komponens osztályában a megfelelő publikus property-knek kell létezniük:

```php
public $type;
public $message;

public function __construct($type, $message)
{
    $this->type = $type;
    $this->message = $message;
}
```

<details>
<summary><b>Unresolvable dependency</b> hibaüzenet kezelése</summary>
Ha egy komponens osztályban változtatunk valamit (pl. új paramétert adunk a konstruktornak) néha szükséges a cache törlése. Enélkül az alábbi hibaüzenetet kaphatjuk:

```Unresolvable dependency resolving [Parameter #0...]```

Megoldás: az összes cache-elt fájl törlése az alábbi paranccsal:

```php artisan optimize:clear```

</details>

### Slot használata

A slot lehetővé teszi, hogy a komponens tartalmát dinamikusan határozd meg:

```php
<x-card>
    Ez a kártya tartalma.
</x-card>
```

A komponens sablonjában a `{{ $slot }}` változóval érheted el ezt a tartalmat:
```php
<div class="card">
    {{ $slot }}
</div>
```

**Nevesített slotok**

Több slot esetén nevesítheted is őket:

```php
<x-modal>
    <x-slot name="title">
        Figyelem!
    </x-slot>

    Ez az alapértelmezett slot tartalma.
</x-modal>
```

A komponens sablonjában így érheted el:
```php
<div class="modal">
    <h1>{{ $title }}</h1>
    <div>{{ $slot }}</div>
</div>
```

### Anoním komponensek

Anoním komponens = csak nézet fájl, nincs mögötte PHP osztály. Akkor használjuk, ha a komponens csak egy egyszerű HTML sablon.

```sh
php artisan make:component Button --view
```

Helye: `resources/views/components/*.blade.php`

Példa: `resources/views/components/button.blade.php`

---

## Layout építése komponensekkel

Laravelben a Blade komponensek lehetővé teszik, hogy elrendezéseket (layouts) hozzunk létre, amelyeket más nézetek (views) örökölhetnek. Ez nagyon hasznos, ha van egy alapelrendezésed (pl. fejléc, lábléc, menü, stb.), amit több oldal is használnál.


### Saját `x-layout` komponens létrehozása

1. Hozz létre egy Blade fájlt (manuálisan vagy artisan paranccsal):  
   `resources/views/components/layout.blade.php`

```php
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Alapértelmezett cím' }}</title>
</head>
<body>
    <x-navbar />
    <main>
        {{ $slot }}
    </main>
</body>
</html>
```

- A `{{ $slot }}` helyén jelenik meg a gyerek komponens tartalma.
- A `$title` változót átadhatod a komponensnek.

### Használat egy nézetben

```php
<x-layout title="Kezdőlap">
    <h1>Üdvözlünk!</h1>
    <p>Ez a kezdőoldal tartalma.</p>
</x-layout>
```

### Komponensbe ágyazott komponensek

`x-layout` belsejében további komponenseket használhatsz, pl.:

```php
<x-navbar />
<x-footer />
```
