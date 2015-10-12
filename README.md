# 2. kodutoo (I rühm)

## Kirjeldus

1. Võimalda oma lehel kasutajat luua ja kontrollida sisselogimist (kui on õige trüki kasutaja id )
  * Abi saad 4. tunnitööst
1. **OLULINE! ÄRA POSTITA GITHUBI GREENY MYSQL PAROOLE.** Selleks toimi järgmiselt:
  * loo eraldi fail `config.php`. Lisa sinna kasutaja ja parool ning tõsta see enda koduse töö kaustast ühe taseme võrra väljapoole
  ```PHP
  $servername = "localhost";
  $username = "username";
  $password = "password";
  ```
  * Andmebaasi nimi lisa aga kindlasti enda faili ja `require_once` käsuga küsi parool ja kasutajanimi `config.php` failist, siis saan kodust tööd lihtsamini kontrollida
  ```PHP
  // ühenduse loomiseks kasuta
  require_once("../config.php");
  $database = "database";
  $mysqli = new mysqli($servername, $username, $password, $database);
  ```
