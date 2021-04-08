<?php
require_once "functions.php";

$string = file_get_contents("data.json");
$data = json_decode($string);
if (empty($string) || time() - $data->timestamp > 3600) {
    $result = json_decode(curl("https://api.corona-zahlen.org/germany"));
    $inGer = $result->weekIncidence;


    $result = json_decode(curl("https://api.corona-zahlen.org/states"));
    $inSH = $result->data->SH->weekIncidence;


    $result = json_decode(curl("https://api.corona-zahlen.org/districts"));
    $inSKF = $result->data->{'01001'}->weekIncidence;
    $inLSF = $result->data->{'01059'}->weekIncidence;
    $inNF = $result->data->{'01054'}->weekIncidence;


    $result = json_decode(curl("https://api.corona-zahlen.org/vaccinations"));
    $vac = $result->data->quote;

    $data = array(
        "timestamp" => time(),
        "inGer" => $inGer,
        "inSH" => $inSH,
        "inSKF" => $inSKF,
        "inLSF" => $inLSF,
        "inNF" => $inNF,
        "vac" => $vac,
    );

    file_put_contents("data.json", json_encode($data));
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Trueforce Security Inc.">
    <title>Corona in Flensburg und Umgebung</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <meta name="theme-color" content="#7952b3">
    <!-- Custom styles for this template -->

    <style>
        .danger-low {
            color: #25AE5C;
        }

        .danger-medium {
            color: #e0c200;
        }

        .danger-high {
            color: #FA8C00;
        }

        .danger-extreme {
            color: #C71E1D;
        }

    </style>
</head>
<body>

<div class="col-lg-8 mx-auto p-3 py-md-5">
    <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
        <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
            <span class="fs-4">Corona in Flensburg und Umgebung</span>
        </a>
    </header>

    <div class="row text-center text-md-left">
        <div class="col-md-4">
            <h5>Deutschland</h5>
            <h3 class="<?= color($data->inGer) ?>"><?= fround($data->inGer) ?></h3>
            7-Tage Inzidenzwert
        </div>
        <div class="col-md-4 mt-4 mt-md-0">
            <h5>Schleswig-Holstein</h5>
            <h3 class="<?= color($data->inSH) ?>"><?= fround($data->inSH) ?></h3>
            7-Tage Inzidenzwert
        </div>
        <div class="col-md-4 mt-4 mt-md-0">
            <h5>Deutschland</h5>
            <h3><?= round($data->vac * 100, 2) ?>%</h3>
            Erste Impfung
        </div>
    </div>
    <hr class="my-5">
    <div class="row text-center text-md-left">
        <div class="col-md-4">
            <h5>SK Flensburg</h5>
            <h3 class="<?= color($data->inSKF) ?>"><?= fround($data->inSKF) ?></h3>
            7-Tage Inzidenzwert
        </div>
        <div class="col-md-4 mt-4 mt-md-0">
            <h5>LK Schleswig-Flensburg</h5>
            <h3 class="<?= color($data->inLSF) ?>"><?= fround($data->inLSF) ?></h3>
            7-Tage Inzidenzwert
        </div>
        <div class="col-md-4 mt-4 mt-md-0">
            <h5>LK Nordfriesland</h5>
            <h3 class="<?= color($data->inNF) ?>"><?= fround($data->inNF) ?></h3>
            7-Tage Inzidenzwert
        </div>
    </div>
    <footer class="pt-5 my-5 text-muted border-top">
        <div class="small">
            <span class="danger-low">⬤</span> unter 35, <span class="danger-medium">⬤</span> unter 50,
            <span class="danger-high">⬤</span> unter 100 oder <span class="danger-extreme">⬤</span> über 100</span>
        </div>
        <div class="mt-4">
            &copy; <?= date("Y", time()) ?>
            &middot; <a href="https://api.corona-zahlen.org/docs/#endpoints" target="_blank">Datenquelle</a>
            &middot; <a href="https://github.com/MasterPuffin/Flensburg-Corona" target="_blank">Quellcode</a>
            &middot; <a href="https://www.trueforce.ca/impressum" target="_blank">Impressum</a>
        </div>
    </footer>
</div>


<script src="/js/bootstrap.bundle.min.js"></script>

</body>
</html>

