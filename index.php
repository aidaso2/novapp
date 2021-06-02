<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/home.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/home.js"></script> 
  <script src="js/ajax.js"></script> 

<?php
  require("vendor/autoload.php");

  use NovApp\API;

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $api = new API();
  $airports = $api->getAirports();
?>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="/">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="/manage">Manage</a>
    </div>
  </div>
</nav>

<div class="nov-modal">
  <div class="nov-control-panel">
    <?php
      $airports = $api->getAirports();
      while($airport = mysqli_fetch_array($airports)) {
    ?>
    <div class="row" onclick="getMarkerById(<?php echo $airport["id"]; ?>)">
      <?php echo $airport["name"]; ?>
    </div>
    <?php
      }
    ?>
  </div>

  <div class="map-container">
    <div id="map"></div>
  </div>

 
</div>

<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAglZWfultbV1Ix7rXjAMT9BHaUaIo7drw&callback=initMap"></script>


</body>
</html> 