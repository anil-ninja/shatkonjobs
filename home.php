<?php
session_start();

require_once "components/dbConnection.php";

$status = $_GET["status"];
$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {  
	header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>BlueNet | Fill Details</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="images/icons/favicon.ico">
  <link rel="apple-touch-icon" href="images/icons/favicon.png">
 <!--Loading bootstrap css-->
  <?php include_once "components/headers.php"; ?>  
</head>
<body>
  <?php require_once "components/navbar.php"; ?>

      <div class="page-content">
        <div id="tab-general">
          <div class="row">
            <div class="col-lg-4">
              <div class="panel-primary">
                <?php require_once "components/addworker.php"; ?>
              </div>
            </div>
            <div class="col-lg-7">
                <?php require_once "components/page_contect.php"; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once "components/footers.php"; ?>
</body>
</html>
