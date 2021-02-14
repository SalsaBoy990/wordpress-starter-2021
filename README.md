# Dockerizált wordpress development környezet - template

## Wordpress

### Composer

A wp-content/plugins mappába kerül telepítésre az összes plugin/sablon, Composerrel. Ennek előnyei:

- A nem általam kezelt kódok nem kerülnek gitbe
- A pluginok és függőségek egyértelműek és verziókezeltek, nincs "véletlen" verzióváltás, frissítés
- A fájlmódosítok le vannak tiltva az admin felületen, a pluginok, témák és a wordpress alaprendszer a Composer-rel frissíthető:


```bash
composer update
```

Telepítés:

```bash
composer require
```

### Új Wordpress oldal esetén

Nincs szükség adatbázis migrációra, nem kell semmit az /src/web mappába másolni. Hagyni kell, hogy a docker-compose le-buildelje a containeket és futtassa azokat. Utána menj a localhost:8000-re és haladj végig a telepítés lépésein

### Adatbázis migráció, PhpMyAdmin

Az sql dump-ot a /data mappába kell másolni.

 - Az sql szkript-ben érdemes lecserélni az url-eket. Példa: https://saida.hu -> http://localhost:8000
 - A docker innen behúzza az adattáblákat és az összes rekordjukat
 - a wp-config-ban módosítani kell az adatbázis adatait, amit .env fájl tartalmaz

Az adatbázisok kezelésére egy phpmyadmin szervíz is rendelkezésre áll a http://localhost:1337 címen

### Apache webserver

A projekt Apache webszervert használ: a var\www\html mappában található fájlokat szolgáltatja.
Ha fut bármilyen más apache szerver a gépeden, akkor azt állítsd le.

A .httacces fájlokat is módosítsd, amennyiben ez szükséges. Plusz fontos, hogy index.php legyen a root-ban

### MySQL 8.0

Frissítettem 8.0-ra. Illetve MariaDB-re is válthatnék.

### dotenv, backup

A .env fájlok NE KERÜLJENEK FEL git-re, mert komoly biztonsági kockázatot jelenthet, ha illetéktelenek kezébe jut.
Szintén érvényes ez a wp-config.php fájlra (amennyiben nem a .env fájlból töltjük bele az értékeket, mert akkor elég, ha csak a .env nem kerül fel).

### Salt

Saltok manuális forgatásához secret key-ek: https://api.wordpress.org/secret-key/1.1/salt/

### Development

A `--build` csak az első build-nél kell

```bash
(set -a; source .env; docker-compose up --build)
```

Linux distrók esetén:
```bash
set -a
source .env
sudo -E docker-compose up --build
```

A container-ek leállítása és megsemmisítése
```bash
docker-compose down
```

Ha valami nagyon félremenne - ez kitöröl minden létező container-t és volume-ot. Utána újrabuildelhetsz.
Viszont vigyázz, mert ez más projektek container-jeit és volume-jait is megsemmisíti:

```bash
sudo docker system prune -a --volumes
```


### Deploy

- Hozz létre mysql adatbázist a tárhelyszolgáltatódnál -> a wp-config-ot frissítsd az új adatbázisnévvel, felhasználónévvel, jelszóval. A Host a legtöbb esetben "localhost".
- PhpMyAdmin-ban exportáld ki sql-be az adatokat, írd át az url-t mindenhol a saját domain-edre, amit vásároltál. Utána importáld be a tárhelyen talható új adatbázisodba.
- ftp-n másold az src/web mappa tartalmát a tárhelyedre. És kész vagy.
- Opcionális: konfiguráld a pluginokat, állítsd be SMTP-t, ha szükséges
- Készíts biztonsági másolatot (Duplicator)
- Lődd be a wordfence-t


### TODO

 - wp-cli telepítése (hasznos lehet, de pillanatnyilag nem szükséges)
 - web-composer container hozzáadása (már első futáskor letölti a plugin-okat)
 - saltok forgatása automatikusan (pl. Salt Shaker - https://wordpress.org/plugins/salt-shaker/)
 - .env változók wp-config-ban (egylőre osztott tárhelynél nem olvashatók be env-ből)
 - JWT tokenek (ha van), REST API letiltása (amennyiben nincs rá szükség)
 - fájlmódosítások tiltása wp admin-on (DISALLOW_FILE_MODS=true)
