# Projecte
## Descripcio
El projecte serà d'objectes de Pokémon i estarà inspirat en aquesta temàtica.

En aquesta primera fase del projecte compte amb les següents funcionalitats:

* Crear usuari

* Login

* Crear/eliminar/modificar/consultar objectes

### Coses importants
En cas de què no funcioni la connexió a la base de dades per culpa de l'usuari editar el següent fitxer:

>./config/db-connection.php

El fitxer de la creació de la BDD esta a:
>./config/db-schema.sql

Per iniciar sessió a l'usuari admin aquestes són les credencials

**User:** admin01

**Contrasenya:** mark

### Decisions

#### Eliminació d'un usuari amb articles
En cas que un usuari amb articles s'eliminés el compte, he decidit que aquests articles no tindrien un creador. Només un administrador podrà editar-los o eliminar-los.

#### Funcions ModelRemember
Hi ha funcions com:
> remember_set_cookie()
> 
> remember_clear_cookie()

Han d'estar al Model per poder accedir-hi. Si les tingués al controlador no funcionaria, ja que aquestes funcions les necessito per a les altres funcions del model.

#### CSRF token
Aquest token està creat per millorar la seguretat a l'hora de fer un canvi en algun compte. En cas que et robessin les cookies del compte, amb aquest token no podrien modificar la contrasenya des de dins del compte ni el nom d'usuari.

#### SameSite Lax (Remember Me)
És una millora de seguretat: les cookies només es poden utilitzar a la meva web i no es passen a altres webs o enllaços.

#### PHPMailer
A la arrel crear la carpeta de:
>libs

I posar la carpeta de PHPMailer dins, amb el nom de 'PHPMailer', la ruta seria la següent:
>/libs/PHPMailer

Plantilla per poder utilitzar el forgot password. Crear aquest arxiu a:
>/config/mail.php


```php
<?php
require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmailRecuperacion($emailDestino, $enlace) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '';
        $mail->Password   = ''; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Destinatari
        $mail->setFrom('correo', 'Pokemon Objects Support');
        $mail->addAddress($emailDestino);

        // Contingut
        $mail->isHTML(true);
        $mail->Subject = 'Recuperar Contrasenya - Pokemon Objects';
        $mail->Body    = "Hola, fes clic en aquest enllaç per restablir la teva contrasenya: <a href='$enlace'>Restablir Contrasenya</a>. L'enllaç caduca en 1 hora.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
```

#### Oauth
Per l'OAuth he creat un arxiu a:
>config/oauth.php

Amb les variables necessàries perquè funcioni, plantilla:

```php
<?php
define('GITHUB_CLIENT_ID', '');
define('GITHUB_CLIENT_SECRET', '');
define('GITHUB_REDIRECT_URI', 'http://localhost/practiques/backend/Projecte/index.php?page=oauth_github')
?>
```

He decidit fer OAuth amb GitHub, ja que és bastant fàcil d'implementar.

#### API
Accedir a: 
>Projecte/articles

get de tots els articles

Per accedir a la api has de generar una api key. Per poder generarla has de fer log in, aquesta key es guarda a la BD i quan l'usuari inicia sessió la key es guarda al sessión. Quan entras a la api es comprova la api key.