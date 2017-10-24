<?php 
	include('../functions.php');
	// include 'update.php';

	if (!isAdmin()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../login.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
	.header {
		background: #003366;
	}
	button[name=register_btn] {
		background: #003366;
	}
	</style>
	<style>
       #map {
        height: 100vh;
        width: 100%;
        background-color: grey;
        /*padding: 10px;*/
        align-content: center;
        /*margin-left: 10%;*/
       }
    </style>
</head>
<body>
	<div class="header">
		<h2>Admin - Home Page</h2>
	</div>
	<div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="home.php?logout='1'" style="color: red;">logout</a>
						&nbsp; <a href="create_user.php"> + add user</a>
					</small>
					<div id="map"></div>
					<script>
					/*showing only not aproved alerts*/
				   	  function initMap() {
				        var map = new google.maps.Map(document.getElementById('map'), {
				          center: new google.maps.LatLng(19, 72),
				          zoom: 4
				        });
						var infoWindow = new google.maps.InfoWindow;
			          	downloadUrl('../markers.php', function(data) {
				            var xml = data.responseXML;
				            var markers = xml.documentElement.getElementsByTagName('marker');
				            Array.prototype.forEach.call(markers, function(markerElem) {
				            	if (markerElem.getAttribute('flag') == 0) {
			            		  var id = markerElem.getAttribute('id');
					              var name = markerElem.getAttribute('name');
					              var description = markerElem.getAttribute('des');
					              var cases = markerElem.getAttribute('cases');
					              var point = new google.maps.LatLng(
					                  parseFloat(markerElem.getAttribute('lat')),
					                  parseFloat(markerElem.getAttribute('lng')));
						          
					              var infowincontent = document.createElement('div');
					              var strong = document.createElement('strong');
					              strong.textContent = name
					              infowincontent.appendChild(strong);
					              infowincontent.appendChild(document.createElement('br'));

					              var text = document.createElement('text');
					              text.textContent = description
					              infowincontent.appendChild(text);
					              infowincontent.appendChild(document.createElement('br'));
					              var text1 = document.createElement('text');
					              text1.textContent = cases
					              infowincontent.appendChild(text1);
					              var aprove = document.createElement("INPUT");
					              aprove.setAttribute("type" , "button");
					              aprove.setAttribute("value", "Aprove");
					              aprove.setAttribute("onclick", "verifyIt("+id+","+marker+")");
					              infowincontent.appendChild(document.createElement('br'));
					              infowincontent.appendChild(aprove);
					              var del = document.createElement("INPUT");
					              del.setAttribute("type" , "button");
					              del.setAttribute("value", "Discard");
					              del.setAttribute("onclick", "deleteIt("+id+","+marker+")");
					              infowincontent.appendChild(document.createElement('br'));
					              infowincontent.appendChild(del);
					              /*creating markers*/
					              var marker = new google.maps.Marker({
					                map: map,
					                position: point
					              });
					              /*info window on clicking the marker*/
					              marker.addListener('click', function() {
					                infoWindow.setContent(infowincontent);
					                infoWindow.open(map, marker);
					              });
				            	}
				            });
			          	});
				      }
				      function verifyIt(id,marker) {
		              	var request = new XMLHttpRequest();
		              	request.open('GET',"update.php?id="+id+"&act=1",true);
					    request.send(null);
					    // console.log(request);
					    marker.setMap(null);
				      }
				      function deleteIt(id,marker) {
				      	var request = new XMLHttpRequest();
				      	request.open('GET',"update.php?id="+id+"&act=0",true);
				        request.send(null);
				        // console.log(request);
					    marker.setMap(null);
				      }
				      function downloadUrl(url, callback) {
				        var request = window.ActiveXObject ?
				            new ActiveXObject('Microsoft.XMLHTTP') :
				            new XMLHttpRequest;

				        request.onreadystatechange = function() {
				          if (request.readyState == 4) {
				            request.onreadystatechange = doNothing;
				            callback(request, request.status);
				          }
				        };

				        request.open('GET', url, true);
				        request.send(null);
				      }

				      function doNothing() {}

				    </script>
				    <script src="../markerclusterer.js"></script>
      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOjj5yR_uy57jVp0u9moK2SJbtd756swk&callback=initMap">
      </script>
				<?php endif ?>
			</div>
		



	</div>
		
</body>
</html>