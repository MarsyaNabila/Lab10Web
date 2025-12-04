<?php
include "form.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Form Input - Praktikum 10</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="card">
      <h2>Silahkan isi form berikut ini :</h2>

      <?php
      $form = new Form("", "Kirim");
      $form->addField("nim", "NIM");
      $form->addField("nama", "Nama");
      $form->addField("alamat", "Alamat");

      $form->displayForm();
      ?>

      <?php if ($_SERVER['REQUEST_METHOD'] == "POST"): ?>
        <div class="submitted">
          <h3>Data yang diterima:</h3>
          <ul>
            <?php foreach ($_POST as $k => $v): ?>
              <li><strong><?php echo htmlspecialchars($k) ?></strong>: <?php echo nl2br(htmlspecialchars($v)) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

    </div>
  </div>
</body>
</html>