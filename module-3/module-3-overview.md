# Laravel Frontend: 3. modul - Adatmegjelenítés és interakciók

- Űrlapok kezelése
- CSRF védelem
- HTTP metódusok kezelése
- Validálási hibák megjelenítése

---

## Űrlapkezelés Blade-ben

### Űrlap létrehozása CSRF védelemmel

Ez a Blade direktíva automatikusan beszúr egy **CSRF token**-t az űrlapba. Erre azért van szükség, hogy megvédje az alkalmazást a cross-site request forgery támadásoktól. A Laravel minden POST, PUT, PATCH, és DELETE kéréshez megköveteli ezt.

```php
<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <input type="text" name="title" value="{{ old('title') }}">
    <button type="submit">Mentés</button>
</form>
```

### HTTP metódusok kezelése

A HTML formok alapból csak `GET` és `POST` metódusokat támogatnak. Ha például `PUT`, `PATCH` vagy `DELETE` metódust szeretnél használni (RESTful elvek szerint), akkor a `@method()` Blade direktívákat használhatod. A Laravel ez alapján felismeri, hogy nem egy sima POST, hanem például egy PUT kérésről van szó.

```php
<form method="POST" action="{{ route('posts.update', $post->id) }}">
    @csrf
    @method('PUT')
    <!-- mezők -->
</form>
```

### Validálási hibák megjelenítése

Amikor egy űrlapot beküldünk, a Laravel automatikusan visszairányítja a felhasználót, ha a validáció sikertelen, és a hibákat a session-ben eltárolja. Ezekhez a hibákhoz a Blade-ben az `$errors` változóval férhetünk hozzá.

#### Egy adott mező hibájának megjelenítése
```php
@error('title')
    <div class="text-danger">{{ $message }}</div>
@enderror
```

#### Az összes hiba kilistázása
```php
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
```

- Az `any()` metódus ellenőrzi, hogy bármilyen hiba történt-e.
- Az `all()` az összes hibaüzenetet visszaadja tömbként.

#### Input visszatöltése hiba esetén

Hogy a felhasználónak ne kelljen újra begépelni az adatokat validációs hiba után:
```php
<input type="text" name="email" value="{{ old('email') }}">
```

- Az `old('mező_neve')` visszaadja a korábban beírt adatokat.

