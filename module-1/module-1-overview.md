# Laravel Frontend fejlesztés: 1. modul - Laravel telepítés, projekt létrehozása

- Bevezetés a Laravelbe
- Mi az SSR (Server-Side Rendering)?
- Szükséges szoftverek: **PHP, Composer, Laravel installer**
- Laravel fejlesztés elindítása
- Lokális fejlesztői szerver
- A Laravel mappastruktúra
- Welcome page
- Paraméter átadása a nézetnek

## Bevezetés a Laravelbe

### Mi az a Laravel?

A Laravel egy modern **PHP keretrendszer**, amely megkönnyíti a webalkalmazások fejlesztését egy egyszerű és elegáns szintaxissal. A Laravel számos beépített funkcióval rendelkezik, mint például az Eloquent ORM, Artisan CLI, **Blade templating rendszer**, valamint API fejlesztést támogató eszközök.

### Miért érdemes Laravel-t használni?
- Egyszerű szintaxis és gyors fejlesztés
- MVC (Model-View-Controller) alapú architektúra
- Erőteljes ORM (Eloquent) az adatbázis kezeléséhez
- Artisan CLI a gyors parancssori műveletekhez
- Beépített hitelesítési és jogosultságkezelési megoldások
*- Könnyű API fejlesztés és támogatás a RESTful architektúrához*
- Nagyon jól használható [dokumentáció](https://laravel.com/docs)


## Mi az SSR (Server-Side Rendering)?

SSR (Server-Side Rendering) jelentése: Szerver oldali renderelés. Ez azt jelenti, hogy a HTML-t a szerver generálja le, és a böngésző már egy teljesen feldolgozott (renderelt) oldalt kap vissza, amit azonnal meg tud jeleníteni.

### Hogyan működik az SSR?

- Amikor egy felhasználó meglátogat egy weboldalt, a kérés eljut a szerverhez.
- A szerver lefuttatja a szükséges logikát (pl. lekérdezések, sablon renderelés stb.).
- Legenerálja az adott oldal HTML-jét, és ezt küldi vissza a böngészőnek.
- A böngésző ezt azonnal meg tudja jeleníteni – nincs szükség JavaScript futtatására ahhoz, hogy megjelenjen az oldal.

### Különbség a CSR-hez (Client-Side Rendering) képest

| SSR (Server-Side Rendering)                                 | CSR (Client-Side Rendering)                       |
| ----------------------------------------------------------- | ------------------------------------------------- |
| HTML-t a szerver generálja                                  | HTML-t a kliens (böngésző) generálja              |
| Gyorsabb első betöltés                                      | Lassabb első betöltés (sok JS-t tölt be)          |
| Jobb SEO (a keresőrobotok azonnal látják az oldaltartalmat) | SEO-hoz plusz trükkök kellenek (pl. prerendering) |
| Minden új oldalbetöltéshez szerverhez fordul                | Egyszer tölt be, utána JS kezeli a navigációt     |
| Használható Laravel Blade-del, PHP sablonmotorral           | Használható pl. Vue/React SPA-kkal                |

### Mikor melyiket érdemes választani?

**Hasznos lehet Laravel SSR, ha:**

- Gyors első megjelenítés a cél (pl. tartalom alapú oldalak, blogok).
- Keresőoptimalizálás fontos – a keresőrobotok könnyebben indexelik az oldalt.
- Nincs szükség komplex interaktív felületre – az oldalak inkább statikus jellegűek.

**CSR hasznos lehet Laravel + SPA (Single Page Application) esetén, pl.:**

- Ha erősen interaktív, alkalmazásszerű élményt szeretnél.
- Ha Vue/React alkalmazást használsz Laravel backenddel.
- Ilyenkor Laravel inkább csak API-t szolgáltat, és a megjelenítést a frontend JavaScript végzi.

## Szükséges szoftverek: **PHP, Composer, Laravel installer**

- **PHP**: A Laravel PHP nyelven íródik, ezért először telepíteni kell a PHP-t.
- A **Composer** egy PHP csomagkezelő, amely lehetővé teszi külső könyvtárak és függőségek egyszerű telepítését, kezelését és frissítését egy projektben. A `composer.json` fájlban meghatározhatók a szükséges csomagok, amelyeket a `composer install` vagy `composer update` parancs telepít és frissít a **vendor** mappában.
- **Laravel Installer**: A Laravel telepítéséhez szükséges parancssori eszköz.

### Telepítés

A fenti szoftverek telepíthetők egyesével:
 - [XAMPP](https://www.apachefriends.org/hu/index.html)
 - [Composer](https://getcomposer.org)
 - Laravel installer - a Composer telepítése után az alábbi parancs futtatásával:
 
    ```sh
    composer global require laravel/installer
    ```
---

 ...vagy **egy lépésben** a Laravel dokumentációjában található script segítségével (*Windows, Linux vagy macOS operációs rendszerre*) [innen](https://laravel.com/docs/12.x/installation#installing-php).

Például Windows-ban PowerShellt kell indítani **rendszergazdaként**, majd ott lefuttatni az alábbi parancsot:
```powershell
# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```

<details>
<summary>Ez utóbbi esetben a számítógép konfigurációjától függően előfordulhat, hogy <b>a szerver nem indul el</b>...</summary>

Ha a szerver az alábbi hibaüzenettel nem indul el:

```sh
Failed to listen on 127.0.0.1:8000 (reason: ?)
Failed to listen on 127.0.0.1:8001 (reason: ?)
...
```

Keressük meg a `php.ini` fájlt a következő helyen:

```sh
c:\Users\<username>\.config\herd-lite\bin\php.ini 
```

és töröljük ki az 'E' betűt a `variables_order` sorban:

```php
variables_order = "EGPCS"
helyett
variables_order = "GPCS"
```
</details>


## Laravel fejlesztés elindítása
Új projekt létrehozása:

```sh
laravel new project-name
```

<details>
<summary><b>Laravel 12</b> telepítés során az alábbi kérdésekre kell válaszolni</summary>

- Which starter kit would you like to install? **Válasz**: none
- Which database will your application use? **Válasz**: sqlite
- Would you like to run npm install and npm run build? **Válasz**: no.
 
</details>

## Lokális fejlesztői szerver
A Laravel beépített szerverét az alábbi paranccsal indíthatjuk el:

```sh
php artisan serve
```

Ez a szerver alapértelmezetten az alábbi címen lesz elérhető: [http://127.0.0.1:8000](http://127.0.0.1:8000)

## A Laravel mappastruktúra

A Laravel keretrendszer jól strukturált mappaszerkezettel rendelkezik. Az alábbi mappákat használjuk leggyakrabban:

**1. /resources/views/**
Blade sablonok helye. Ide kerül minden .blade.php fájl, ami HTML-t generál. A Laravel ezeket dolgozza fel és rendereli szerver oldalon.

**2. /app**
Az alkalmazás fő logikáját tartalmazza:
- **Models/** – Az adatbázis modellek itt helyezkednek el.
- **Http/Controllers/** – Ha összetettebb logika szükséges, a vezérlés a kontrollereken keresztül történik. Ezek kérik le az adatokat, és adják át a Blade sablonoknak.

**3. /database**
Az adatbázissal kapcsolatos fájlok:
- **database.sqlite** – SQLite adatbázisfájl, amely kis fejlesztési projektekhez használható.

**4. /routes**
Az alkalmazás útvonalai:
- **web.php** – A webalkalmazások végpontjait itt definiáljuk. Itt határozod meg, hogy melyik URL milyen nézetet (view-t) jelenítsen meg, vagy milyen controller metódust hív meg.

**5. /public**
Publikus fájlok (CSS, JS, képek). Ezeket a Blade sablonok hivatkozhatják. Az SSR által előállított HTML ezekre a fájlokra is támaszkodik (de nem ezek generálják a tartalmat).

**6. /vendor**
A Composer által telepített külső csomagok tárolására szolgál. Ez a mappa benne van a `.gitignore`-ban, így nem kerül a git repository-ba.

Egy frissen klónozott projekthez utólag telepítendők a csomagok a következő paranccsal:
```sh
composer install
```

**6. A főkönyvtárban lévő fontos állományok:**
- **.env** – Környezeti változók beállításai, például adatbáziskapcsolat.
- **artisan** – Laravel parancssori segédeszköz.
- **composer.json** – A csomagfüggőségek meghatározása.


## Welcome page
Ha még nem fut a Laravel fejlesztői szerver, akkor először egy terminál ablakban indítsuk el:
```sh
php artisan serve
```

Nézzük meg egy böngészőben mit tapasztalunk: [http://127.0.0.1:8000/](http://127.0.0.1:8000/)

### Hogyan jelenek meg ez az oldal? 

A Laravelben a végpontokat a `routes/web.php` fájlban definiáljuk.

A benne lévő kód definiálja az alkalmazás nyitó oldalát, amely a `welcome` nevű nézetet jeleníti meg:

```php
Route::get('/', function () {
    return view('welcome');
});
```

Keressük meg a `welcome.blade.php` oldalt a `resources/views` mappában!


## Paraméter átadása a nézetnek

A `view()` metódus második paraméterében megadhatunk egy asszociatív tömböt, amely tartalmazza a nézetben használandó adatokat.

```php
Route::get('/home', function () {
    return view('home', ['name' => 'John Doe']);
});
```

### Fiktív user adatok generálása és átadása a nézetnek

A `database/seeders/DatabaseSeeder.php` fájlban tegyük aktívvá az alábbi sort:
```php
User::factory(10)->create();
```

Futtassuk le a következő parancsot a terminálban:
```sh
php artisan db:seed
```

Ezzel létrehoztunk 10 fiktív felhasználót.

Adjuk át ezeket a felhasználókat a nézetnek:
```php
Route::get('/users', function () {
    return view('users', ['users' => User::all()]);
});
```

*Az adatok megjelenítésével a következő modulban foglalkozunk.*