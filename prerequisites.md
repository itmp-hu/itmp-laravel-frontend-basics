# Frontend fejlesztés alapjai Laravellel - előfeltételek

### Szükséges szoftverek: **PHP, Composer, Laravel installer**

- **PHP**: A Laravel PHP nyelven íródik, ezért először telepíteni kell a PHP-t.
- A **Composer** egy PHP csomagkezelő, amely lehetővé teszi külső könyvtárak és függőségek egyszerű telepítését, kezelését és frissítését egy projektben. A `composer.json` fájlban meghatározhatók a szükséges csomagok, amelyeket a `composer install` vagy `composer update` parancs telepít és frissít a **vendor** mappában.
- **Laravel Installer**: A Laravel telepítéséhez szükséges parancssori eszköz.

**Telepítés**

1. A fenti szoftverek telepíthetők a Laravel dokumentációjában található script segítségével (*Windows, Linux vagy macOS operációs rendszerre*) **egy lépésben** [innen](https://laravel.com/docs/12.x/installation#installing-php).

Például Windows-ban PowerShellt kell indítani **rendszergazdaként**, majd ott lefuttatni az alábbi parancsot:
```powershell
# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```

<details>
<summary>Néha előfordul, hogy <b>a szerver nem indul el</b>...</summary>

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

2. A szükséges szoftverek egyesével is telepíthetők:
 - [XAMPP](https://www.apachefriends.org/hu/index.html): a PHP-hez és a mysqlhez
 - [Composer](https://getcomposer.org)
 - Laravel installer - a Composer telepítése után az alábbi parancs futtatásával:
 
    ```sh
    composer global require laravel/installer
    ```
---


## Visual Studio Code beállítása
A fejelsztéshez Visual Studio Code-ot fogunk használni. *Alternatív népszerű fejlesztői környezet a PHPStorm.*

### Minimálisan ajánlott VS Code extension-ök
- **PHP Intelephense** (intelligens kódkiegészítés)
- **Laravel Extra Intellisense** (intellisense Laravel funkciókhoz)
- **Laravel Snippets** (kódkiegészítés Laravel funkciókhoz)
- **Laravel Blade formatter** (automatikus formázás a .blade.php sablonfájlokhoz)
- **Laravel Blade Snippets** (gyors kódkiegészítés Blade direktívákhoz)
- **Laravel goto view** (gyors ugrás a view-hoz kontrollerből vagy route-ból)
- **SQLite3 Editor** (SQLite3 adatbázis kezeléséhez)
