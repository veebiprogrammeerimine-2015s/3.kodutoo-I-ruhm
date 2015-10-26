# 3. kodutoo (I rühm)

## Kirjeldus

1. Lähtu ülesannete puhul alati oma ideest ning ole loominguline
  * loo vähemalt 1 tabel andmete hoidmiseks (lisa table.txt fail tabeli kirjeldusega)
  * ainult sisseloginud kasutaja saab kirjeid tabelisse lisada
  * kirjeid saab muuta
  * kõik või ainult kasutaja ise saab enda lisatud kirjeid vaadata (oleneb rakendusest)
  * otsing
  * abi saad tunnitöödest 5, 6 ja 7

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
  require_once("../../config_global.php");
  $database = "database";
  $mysqli = new mysqli($servername, $username, $password, $database);
  ```

  
	CREATE TABLE mvp (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		email VARCHAR(255) NOT NULL,
		password VARCHAR(128),
		age INT, 
		created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		UNIQUE(email)
	);

CREATE TABLE notes (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  note VARCHAR(255),   
  done VARCHAR(3),
  deleted TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES mvp(id)
);
