<html lang="en">
  <?php include "header.php";?>
<body>
  <?php
    if(!isset($_GET["page"])) {
      include "home.php";
    }
    else {
      $page = $_GET["page"];
      include $page . ".php";
    }
  ?>
</body>
</html>
