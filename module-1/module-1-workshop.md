# 1. modul workshop - Laravel telepítése

- Laravel telepítése
- Projekt inicializálása
- Webszerver futtatása
- Új HTML oldalak létrehozása
- Alkalmazás tesztelése böngészőben
- Paraméter átadása a nézeteknek


> **Cél:**  
> - Minden szükséges eszköz telepítve legyen a számítógépen: Composer, parancssori PHP, Laravel installer, Visual Studio Code! 
> - Legyen létrehozva egy Laravel projekt! 
> - Értenünk kell egy Laravel projekt felépítését, valamint azt, hogy milyen mappákat, fájlokat tartalmaz!
> - Tudjunk létrehozni route-okat, amelyek különböző view-kat jelenítenek meg!
---

## Laravel projekt telepítése

- Hozz létre új Laravel projektet! Lépj be a kívánt mappába, majd futtasd le a következő parancsot:

  ```sh
  laravel new project-name
  ```

- Ha valamelyik előfeltétel nem teljesül és nem fut le a telepítő, akkor [innen](https://laravel.com/docs/12.x/installation#installing-php) telepíthető az összes egy lépésben.
- Ha nincs feltelepítve [Visual Studio Code](https://code.visualstudio.com/), akkor azt is telepítsd!

## Projekt inicializálása

- A projekt mappáját nyisd meg Visual Studio Code-ban!
- Nyiss egy terminált ablakot! A legegyszerűbb VS Code-ban: **View > Terminal**

## Legenerált projektfájlok és mappák tanulmányozása

Keresd meg és tanulmányozd az előadáson megbeszélt mappákat és állományokat!

## Szerver elindítása és a route tesztelése

Terminálban futtasd le a következő parancsot:
```sh
php artisan serve
```
- A szerver elindítása után a terminálban megjelenik a következő üzenet:

  ```sh
  INFO Server running on http://127.0.0.1:8000
  ```

Teszteljük le az alkalmazást egy böngészőben: [http://127.0.0.1:8000/](http://127.0.0.1:8000/)

## Új oldalak létrehozása

- Keresd meg és szerkesztd a következő fájlt: `routes/web.php`:

  Cseréld le a saját nyitó oldaladra a welcome view-t:
  ```php
  Route::get('/', function () {return view('home');});
  ```

- Nézd meg böngészőben most mi történt:

  *Internal Server Error. View [home] not found.*

- Hozz létre egy `home.html` oldalt a `resources/views` mappában, majd írj bele tetszőleges html tartalmat! Ellenőrizd újra a böngészőben!

- Nevezd át a `home.html`-t `home.php`-ra! Teszteld le, hogy működik-e a PHP: pl. írd bele, hogy:
  ```php
  <?php echo 'Hello PHP!'; ?>
  ```

- A blade szintaxis használatához a fájlok elnevezése `*.blade.php` kell hogy legyen! Pl.: `home.blade.php`. Add hozzá az alábbi tartalmat: `{{ 'Hello blade!' }}` és ellenőrizd!

- Hozz létre további route-okat és hozzá oldalakat, pl. `about`, `contacts`!

## Paraméter átadása a nézetnek

A `view()` metódus második paraméterében megadhatunk egy asszociatív tömböt, amely tartalmazza a nézetben használandó adatokat.

```php
Route::get('/home', function () {
    return view('home', ['name' => 'John Doe']);
});
```

### Fiktív user adatok generálása és átadása a nézetnek

A `database/seeders/DatabaseSeeder.php` fájlban tedd aktívvá az alábbi sort:
```php
User::factory(10)->create();
```

Futtatsd le a következő parancsot a terminálban:
```sh
php artisan db:seed
```

Ezzel létrejött 10 fiktív felhasználó.

Add át ezeket a felhasználókat a nézetnek:
```php
Route::get('/users', function () {
    return view('users', ['users' => User::all()]);
});
```

Jelenítsd meg a felhasználókat a `users.blade.php` nézetben natív PHP kóddal!

```php
<ul>
    <?php
        foreach ($users as $user) {
            echo "<li>$user->name</li>";
        }
    ?>
</ul>
```

*A következő modulban megismerjük a Blade sablonmotor használatát!*