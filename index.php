<?php
session_start();

define("ZAPPKA", 1);


include "inc/init.php";
include "inc/class_templates.php";
include "inc/functions.php";

try {
    $pdo = new PDO('sqlite:inc/database.sqlite3');
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$informacja = "";

//Troche logiki
if(isset($_GET['action'])) {
    switch($_GET['action']) {
        case "dodajkod":
            $kod                = (int)$_GET['kod'];
            $informacja         = $_GET['informacja'];
            $zgodapapierosy   = (int)($_GET['zgodapapierosy'] == "on");

            $check = $pdo->query("SELECT * FROM kody WHERE kod = '".$kod."'");
            if(count($check->fetchAll()) == 0) {
                $pdo->query("INSERT INTO kody ('kod', 'informacja', 'pozostalo', 'zgodapapierosy', 'ostatnieuzycie') VALUES ('".$kod."', '".$informacja."', 3, '".$zgodapapierosy."', '".date("Y-m-d H:i:s", time())."')");
                inline_message("index.php", "<div class='alert alert-success'>Kod dodany poprawnie!</div>");
            } else {
                inline_message("index.php", "<div class='alert alert-danger'>Kod juz istnieje!</div>");
            }

            break;
        case "zaktualizuj":
            $pdo->query("UPDATE kody SET pozostalo = pozostalo-1, ostatnieuzycie = '".date("Y-m-d H:i:s", time())."' WHERE `kod` = '".$_GET['kod']."'");
            die("OK");
            break;

        default:
            die("Hm?");
            break;
    }
}


$stmt = $pdo->query("SELECT * FROM kody WHERE pozostalo != 0 ORDER BY ostatnieuzycie DESC");
$kody_sql = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($kody_sql) == 0) {
    $pdo->query("UPDATE `kody` SET `pozostalo` = 3, `ostatnieuzycie` = '".date("Y-m-d H:i:s", time())."'");
}

if(isset($_SESSION['inline'])) {
    $informacja = $_SESSION['inline']['message'];
    unset($_SESSION['inline']);
}

$kody = "";

foreach ($kody_sql as $kod) {
    $zgoda      = ($kod['zgodapapierosy']) ? '<font color="green">Tak</font>' : '<font color="red">Nie</font>';
    $border     = ($kod['zgodapapierosy']) ? 'border-success' : 'border-danger';

    $ean = "ean/code_".$kod['kod'].".png";

    if(!file_exists($ean)) {
        file_put_contents($ean, file_get_contents("http://bwipjs-api.metafloor.com/?bcid=code128&text=".$kod['kod']));
    }

    $mainfile = $ean;

    eval('$kody .= "'.render_template('kody').'";');
}

eval('$mainpage = "'.render_template('index').'";');
output_page($mainpage);

?>