<!DOCTYPE html>
<html lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ERPSystem</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
  <link rel="stylesheet" href="<?= Router::$BASE ?>assets/style.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="<?= Router::$BASE ?>assets/script.js"></script>

</head>

<body>
    <div id="main">
      <div class="columns">
        <div class="column is-narrow" id="menu">
          <?php require_once __ROOT__ . DS . 'includes' . DS . 'Menu.php' ?>
        </div>
        <div class="column" id="system">
          <section class="section">
            <?php require_once Router::$View; ?>
          </section>
        </div>
      </div>
    </div>
  </body>
  <footer>
    <p id="baseurl"><?= Router::$BASE ?></p>
    <?= var_dump(Invoice::showdb()) ?>
  </footer>

</html>
