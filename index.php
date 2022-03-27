<?php

    function polishMe($value, $prefix, $suffix) {
        switch($value) {
            case "1":
                return $prefix[0]." <b class='updateme'>".$value."</b> ".$suffix[0];
                break;
            case "2":
            case "3":
            case "4":
                return $prefix[1]." <b class='updateme'>".$value."</b> ".$suffix[1];
                break;   
            default:
                return $prefix[1]." <b class='updateme'>".$value."</b> ".$suffix[2];
                break;
        }
    }

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO("mysql:host=HOSTNAME;dbname=DBNAME;charset=utf8mb4", "USERNAME", "PASSWORD", $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    if($_GET['lowid']) {
        $pdo->query("UPDATE `kody` SET `pozostało` = `pozostało`-1 WHERE `id` = '".$_GET['lowid']."'");
        die("OK");
    }

    $stmt = $pdo->query("SELECT * FROM `kody` WHERE `pozostało` != 0 ORDER BY `id` DESC LIMIT 0,25");
    $stmt2 = $pdo->query("SELECT * FROM `kody` WHERE `pozostało` != 0 ORDER BY `id` DESC");
    $stmt3 = $pdo->query("SELECT * FROM `kody` ORDER BY `ostatnieuzycie` DESC LIMIT 0,1");

    if(date("d") != date("d", strtotime($stmt3->fetch()['ostatnieuzycie']))) {
        $pdo->query("UPDATE `kody` SET `pozostało` = 3, `ostatnieuzycie` = '".date("Y-m-d H:i:s", time())."'");
        header("Refresh:0");
    }

    if(strpos($_SERVER['HTTP_USER_AGENT'], "Android") == false && !$_GET['bypass']) {
        die("Not allowed");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Guess?</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="main/style.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="manifest" href="manifest.json">
    </head>

    <body>
        <div class="content">

        <?php if($stmt->rowCount() == 0) { ?>
            <div class="alert alert-danger">Brak nieużytych kodów!</div>
        <?php } else { ?>
            <?php while ($row = $stmt->fetch()) { ?>
                <?php $informacja = empty($row['informacja']) ? 'Nieznane' : $row['informacja']; ?>
                <div class="zappkacode_block" data-kodid="<?=$row['id']?>" data-usesleft="<?=$row['pozostało']?>" data-info="<?=$informacja?>">
                    <br />
        
                    <div><img class="zappkacode" src="http://bwipjs-api.metafloor.com/?bcid=code128&text=<?=$row['kod']?>" /></div>
                    <div class="zappkainfo">
                        <span class="update_code_<?=$row['id']?>"><?=$informacja?> - <?=$row['pozostało']?></span>
                    </div>
                </div>
            <?php } ?>
            <p class="infocode alert alert-info">
                <?=polishMe($stmt2->rowCount(), array("Pozostał", "Pozostało"), array("kod", "kody", "kodów"));?>
            </p>
        <?php } ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="main/script.js"></script>
    </body>
</html>