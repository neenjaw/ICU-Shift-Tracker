<?php
include_once 'includes/dbconfig.php';

if (isset($_SESSION['user_session'])) {
    $stmt = $DB_con->prepare("SELECT * FROM ".$DB_tbl_users." WHERE email=:uid");
    $stmt->execute(array(":uid"=>$_SESSION['user_session']));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Bootstrap Login/Signup Modal Form Design</title>

  <!-- BOOTSTRAP v4.0.0-alpha 6 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

  <!-- less.js
  <link rel="stylesheet/less" type="text/css" href="assets/styles.less" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js" type="text/javascript"></script>
  -->

  <!-- Select 2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

  <!-- -->
  <link href="assets/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">
</head>
<body>
