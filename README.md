# 3. kodutoo (I r�hm)

## Kirjeldus

1. L�htu �lesannete puhul alati oma ideest ning ole loominguline
  * loo v�hemalt 1 tabel andmete hoidmiseks (lisa table.txt fail tabeli kirjeldusega)
  * ainult sisseloginud kasutaja saab kirjeid tabelisse lisada
  * kirjeid saab muuta
  * k�ik v�i ainult kasutaja ise saab enda lisatud kirjeid vaadata (oleneb rakendusest)
  * otsing
  * abi saad tunnit��dest 5, 6 ja 7

1. **OLULINE! �RA POSTITA GITHUBI GREENY MYSQL PAROOLE.** Selleks toimi j�rgmiselt:
  * loo eraldi fail `config.php`. Lisa sinna kasutaja ja parool ning t�sta see enda koduse t�� kaustast �he taseme v�rra v�ljapoole
  ```PHP
  $servername = "localhost";
  $username = "username";
  $password = "password";
  ```
  * Andmebaasi nimi lisa aga kindlasti enda faili ja `require_once` k�suga k�si parool ja kasutajanimi `config.php` failist, siis saan kodust t��d lihtsamini kontrollida
  ```PHP
  // �henduse loomiseks kasuta
  require_once("../../config_global.php");
  $database = "database";
  $mysqli = new mysqli($servername, $username, $password, $database);
  ```

  
CREATE TABLE mvp (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(128),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(email)
);

CREATE TABLE notes (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  note VARCHAR(255),   
  done VARCHAR(3),
  FOREIGN KEY (user_id) REFERENCES mvp(id)
);

