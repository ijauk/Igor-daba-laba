## Početak

## Kreiranje projekta

composer create-project laravel/laravel ImeProjekta

### Baza podataka

-   nakon toga uredim .env dokument i podesim bazu podataka
-   u mom slučaju, koristim lokalni mysql
-   nakon podešavanj .env pokrećem:

```php
    php artisan migrate
```

-   ova naredba kreira bazu i osnovne tablice, uključujući i User tablic
-   podatke potrebne za osnovni rad baze, kao i testne podatke, u bazu punimo pomoću

```php
    php artisan make:seeder UserSeeder
```

-   ova će naredba kreirati UserSeede.php datoteku u database/seeders mapi
-   sljedeći kod koristim za kreiranje usera Admin

```php
    namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'->'Glavni admin',
            'email' -> 'admin@igor.com',
            'password' -> Hash::make('admin1234)
        ])
    }
}

```

-   u DatabaseSeeder.php pozivam tu klasu, npr

```php

public function run():void
{
    $this->call([
        UserSeeder::class
    ])
}
```

-   kada pozovem sljedeću narebu, pokrenut će se sve seed naredbe

```php
php artisan db:seed
```

-   a ova naredba preskočit će defultni DatabaseSeeder i pozvati specificirani seeder, u uvom slučaju UserSeeder

```php
php artisan db:seed --class=UserSeeder
```

-   s obzirom da sam krivim redoslijedom napravio modele i bio je problem u migraciji, promijenio sam "timestamp" migracije i onda ih pokrenuo.
