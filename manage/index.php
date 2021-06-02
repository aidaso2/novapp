<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/manage.css">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/manage.js"></script> 
<script src="../js/ajax.js"></script> 

<?php
  require("../vendor/autoload.php");

  use NovApp\API;

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $api = new API();
  $avls = $api->getAirportAvialines("1");
  $countriesArr = array();
  $countries = $api->getCountries();
  while($country = mysqli_fetch_array($countries)) {
      $countriesArr[] = $country;
  }

?>
</head>
<body onload="getAirportAvialines()">

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


<div class="row">
  <div class="col-xs-12 col-sm-6">
    <!-- Left column panels -->
    <table class="table">
  <thead>
    <tr>
        <th scope="col">Airports</th>
    </tr>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">lat</th>
      <th scope="col">lng</th>
      <th scope="col">Remove</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $airports = $api->getAirports();
      while($airport = mysqli_fetch_array($airports)) {
    ?>
    <tr>
      <th scope="row"><?php echo $airport["id"]; ?></th>
      <td><?php echo $airport["name"]; ?></td>
      <td><?php echo $airport["lat"]; ?></td>
      <td><?php echo $airport["lng"]; ?></td>
      <td><span onclick="removeAirport(<?php echo $airport["id"]; ?>)">-</span></td>
    </tr>
    <?php
      }
    ?>
  </tbody>
</table>
  </div>

  <div class="col-xs-12 col-sm-6">
    <!-- Right column panels -->
    <table class="table">
  <thead>
    <tr>
        <th scope="col">Avialines</th>
    </tr>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Remove</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $avialines = $api->getAvialines();
      while($avialine = mysqli_fetch_array($avialines)) {
    ?>
    <tr>
      <th scope="row"><?php echo $avialine["id"]; ?></th>
      <td><?php echo $avialine["name"]; ?></td>
      <td><span onclick="removeAvialine(<?php echo $avialine["id"]; ?>)">-</span></td>
    </tr>
    <?php
      }
    ?>
  </tbody>
</table>
  </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6">
        <form>
        <div class="form-group">
            <label for="apname">Name</label>
            <input type="text" class="form-control" id="apname" placeholder="airport name">
        </div>
        <div class="form-group">
            <label for="aplat">Lat</label>
            <input type="text" class="form-control" id="aplat" placeholder="airport lat">
        </div>
        <div class="form-group">
            <label for="aplng">Lng</label>
            <input type="text" class="form-control" id="aplng" placeholder="airport lng">
        </div>
        <div class="form-group">
            <label for="apcountry">Country</label>
            <select class="form-control" id="apcountry">
            <?php
                foreach($countriesArr as $country) {
            ?>
            <option value="<?php echo $country["id"]; ?>"><?php echo $country["name"]; ?></option>
            <?php
                }
            ?>
            </select>
        </div>
        <button type="button" class="btn btn-info" onclick="addAirport()">Add</button>
        <button type="button" class="btn btn-warning" onclick="updateAirport()">Update</button>
        <input type="text" class="" id="apid" placeholder="id">
        </form>

    </div>
    <div class="col-xs-12 col-sm-6">
    <form>
        <div class="form-group">
            <label for="avname">Name</label>
            <input type="text" class="form-control" id="avname" placeholder="avialine name">
        </div>
        <div class="form-group">
            <label for="avcountry">Country</label>
            <select class="form-control" id="avcountry">
            <?php
                foreach($countriesArr as $country) {
            ?>
            <option value="<?php echo $country["id"]; ?>"><?php echo $country["name"]; ?></option>
            <?php
                }
            ?>
            </select>
        </div>
        <button type="button" class="btn btn-info" onclick="addAvialine()">Add</button>
        <button type="button" class="btn btn-warning" onclick="updateAvialine()">Update</button>
        <input type="text" id="avid" placeholder="id">
        </form>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6">
        <form>
        <div class="form-group">
            <label for="apsel">Airports</label>
            <select class="form-control" id="apsel" onchange="getAirportAvialines()">
            <?php
                $airports = $api->getAirports();
                while($airport = mysqli_fetch_array($airports)) {
            ?>
            <option value="<?php echo $airport["id"]; ?>"><?php echo $airport["name"]; ?></option>
            <?php
                }
            ?>
            </select>
        </div>
        <button type="button" class="btn btn-info" onclick="addAirportAvialine()">Add</button>
        <select class="form-control" id="avsel" onchange="getAirportAvialines()">
            <?php
                $avialines = $api->getAvialines();
                while($avialine = mysqli_fetch_array($avialines)) {
            ?>
            <option value="<?php echo $avialine["id"]; ?>"><?php echo $avialine["name"]; ?></option>
            <?php
                }
            ?>
            </select>
        </form>
    </div>
    <div class="col-xs-12 col-sm-6">
    <!-- Right column panels -->
    <table class="table" id="airport_avialines">
  <thead>
    <tr>
        <th scope="col">Avialines</th>
    </tr>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Remove</th>
    </tr>
  </thead>
  <tbody>


  </tbody>
</table>
  </div>
</div>


</body>
</html> 