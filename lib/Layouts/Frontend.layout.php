<!DOCTYPE html>
<html lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ERPSystem</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
  <link rel="stylesheet" href="<?= Router::$BASE ?>assets/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

  <body>
    <div id="main">
      <div class="columns">
        <div class="column is-narrow" id="menu">
          <?php require_once __ROOT__ . DS . 'includes' . DS . 'menu.html' ?>
        </div>
        <div class="column" id="system">
          <section class="section">
            <?php require_once Router::$View; ?>
          </section>
        </div>
      </div>
    </div>
  </body>
</body>

</html>
