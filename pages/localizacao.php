<!Doctype html>
<html>
<head>
<style>
  body{
    background-color: orange;
  }

  #map{
    height:70%;
    width:60%;
    margin-left: 200px;
    margin-bottom: 10px;
  }
</style>
</head>
<body>

<h3>Nossa loja fica na <strong>Av. Encarnação, 82 - Piraporinha - Diadema - SP</strong></h3>
<h4>CEP: 09960-010</h4>

<div id="map"></div>
<script>
  function initMap() {
    var uluru = {lat: -23.6924819, lng: -46.5883303};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: uluru
    });
    var marker = new google.maps.Marker({
      position: uluru,
      map: map
    });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUVf2n3lg5rZxWOuJ1MYEaEVN0oosLJnU&callback=initMap"async defer></script>
</body>
</html>
