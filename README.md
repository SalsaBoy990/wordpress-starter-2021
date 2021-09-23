# Dockerizált wordpress development környezet - template

## Wordpress

### Composer

Az `src/web/wp-content/plugins` mappába kerül telepítésre az összes plugin/sablon a Composerrel, már amelyik a [WPackagist](https://wpackagist.org/) tárolóból elérhető.

- A nem általam kezelt kódok nem kerülnek gitbe, a `.gitignore`-ban kell a kivételeket megadni
- A pluginok és függőségek egyértelműek, verziókezeltek és frissíthetők
- Amennyiben a fájlmódosítok le vannak tiltva az admin felületen (`DISABLE_FILE_MODS`), a pluginok, témák és a wordpress alaprendszer csak a Composer-rel frissíthető:

```bash
composer update
```

Csomagok feltelepítése:

```bash
composer install
```


### Új Wordpress oldal esetén

Nincs szükség adatbázis migrációra, nem kell semmit az `/src/web` mappába másolni. Hagyni kell, hogy a docker-compose le-buildelje az image-eket és futtassa a konténereket. Utána menj a `localhost:8000`-re és haladj végig a telepítés lépésein!

TODO: A jövőben a `wp-cli` segítségével is meg lehetne valósítani a telepítést, a grafikus felület helyett.

### Adatbázis migráció, phpMyAdmin

!! Létrehoztam egy dump mappát a gyökérben, ami tartalmazza a tesztoldalam sql dumpját (`starter.sql`) !!

Az sql dump-ot az `src/data` mappába kell másolni.

 - Az sql szkript-ben érdemes lecserélni az url-eket. Példa: `https://decimus.hu` -> `http://localhost:8000`
 - A docker innen behúzza az adattáblákat
 - a wp-config-ban módosítani kell az adatbázis adatait, amit `.env` fájl tartalmaz a gyökérkönytárban

Az adatbázisok kezelésére egy phpmyadmin szervíz is rendelkezésre áll a `http://localhost:1337` címen (a belépési adatok szintén a `.env` fájlban vannak).

### Apache webserver

A projekt Apache webszervert használ: a konténeren belül a `var\www\html` mappában található fájlokat szolgáltatja.
Ha fut bármilyen más apache szerver a gépeden, akkor azt állítsd le.

A .httacces fájlokat is módosítsd, amennyiben ez szükséges. Plusz fontos, hogy index.php legyen a root-ban

### MySQL 8.0

Frissítettem 8.0-ra.

### Dotenv

A .env fájlok éles adatokkal NE KERÜLJENEK FEL git-re, mert komoly biztonsági kockázatot jelenthet, ha illetéktelenek kezébe jut!
Szintén érvényes ez a wp-config.php fájlra.

### Salt

Saltok manuális forgatásához secret key-ek: https://api.wordpress.org/secret-key/1.1/salt/ Érdemes időnként cserélni őket. Saltok forgatása automatikusan pl. a [Salt Shaker](https://wordpress.org/plugins/salt-shaker/) bővítménnyel valósítható meg.

### Development

A `--build` flag csak a legelején, a build-hez kell.

```bash
(set -a; source .env; docker-compose up --build)
```

Linux distrók esetén:
```bash
set -a
source .env
sudo -E docker-compose up --build
```

A konténerek leállítása és megsemmisítése
```bash
docker-compose down
```

Ha valami nagyon félremenne - ez a parancs kitöröl minden létező image-et, konténert - de más projekteknél is! Utána újrabuildelhetsz:

```bash
sudo docker system prune -a
```

A  `--volumes` flag-et nem ajánlom, mert az összes projekt összes volume adatát megsemmisíti.


### Deployment osztott tárhelyek esetén (számomra a Nethely.hu vált be)

1. Hozz létre mysql adatbázist a tárhelyszolgáltatódnál!
2. A `wp-config`-ot frissítsd az új adatbázisnévvel, felhasználónévvel, jelszóval! A Host a legtöbb esetben `"localhost"`.
3. PhpMyAdmin-ban exportáld ki sql-be az adatokat, írd át az url-t mindenhol az új domain-re az IDE-dben! Utána importáld be a tárhelyen talható új adatbázisodba! Vagy elsőnek importáld, és utána sql szkriptekkel írd át az url-eket (lásd. `src/data/rewrite-domainname.sql`)!
4. SFTP-n keresztül másold át az `src/web` mappa tartalmát a tárhelyedre! És kész vagy.


### Post-deployment

- Állítsd be az SMTP a levélküldéshez!
- Konfiguráld a pluginokat!
- Lődd be a Wordfence tűzfalat!
- Készíts biztonsági másolatot (pl. Duplicator-ral)!
- stb.


## Vue.js integráció

Külön konténerben fut, a `localhost:8080`-as portjához van kötve. Az `src/web/wp-content/plugins/vuecommerce` pluginban van a Vue.js SPA forráskódja és a Dockerfile. Jelenleg `node:12.2.0-alpine` image-et használok.

Felhívom a figyelmet, hogy a vue-cli devszerver csak cache-be menti a bundle fájlokat, tehát a szriptek regisztrációjakor a
path-ot eképpen add meg: `http://localhost:8080/dist/js/app-bundle-neve.js`! Amikor lebuild-eled az éles js és css bundle-öket, akkor írd át pl. erre: `plugins_url() . '/vuecommerce//dist/js/app-bundle-neve.js'` az `addVueScripts` metódusban (az `src/web/wp-content/plugins/vuecommerce/includes/VueCommerceBlocks.php` 82. sorától)!

A Vue app a `vuecommerce-filter-products` id-jű divbe csatlakozik be, amit egy rövidkóddal lehet az oldalsablonba helyezni:

```php
// ...

private function __construct()
{
  // ...

  // Add shortcode to WordPress
  add_shortcode('vuecommerce_filter_products', array($this, 'vuecommerceFilterProducts'));

  // ...
}

// ...

// Add shortscode
public function vuecommerceFilterProducts()
{
  // Vue code here will goe here on the frontend
  $appContainer = '<div id="vuecommerce-filter-products"></div>';

  return $appContainer;
}

// ...
```

A `bootcommerce-5-child` témában létrehoztam egy oldal sablont ("No Sidebar with Vue.js app container", `src/web/wp-content/themes/bootcommerce-5-child/page-vue.php`), ahova beillesztettem a rövidkódot (31. sor). A vue.js bundle szkriptek kizárólag ennél az oldalsablonnál kerülnek beillesztésre!


## Egyedi Gutenberg blokkok

A `reactwp-blocks` bővítményben vannak definiálva (`src/web/wp-content/plugins/reactwp-blocks`). Az src mappából webpack-kal generálom le a bundle-öket a dist mappába, és onnan kerülnek beillesztésre a wordpress oldalon (backend és frontend oldali bundle külön készül).

Dev build indítása a mappából:
`npm run start`

Production bundle:
`npm run build`


### TODO

 - wp-cli telepítése (hasznos lehet, de pillanatnyilag nem szükséges)

