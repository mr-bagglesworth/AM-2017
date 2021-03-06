function initialize() {	  
	
		
var myLatlng = new google.maps.LatLng(51.501284, -0.319148);
  var mapOptions = {
    zoom: 14,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById('northfields'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Able Mediation: Northfields Office'
  });
  
  var contentString =
    '<div class="address">'+
    '<h1 class="able">'+'Able'+'</h1>'+'<h1 class="archive-title">'+' Mediation'+'</h1>'+
    '<ul>'+'<li>Northfields (Head Office)</li>'+'<li>71a Northcroft Road</li>'+'<li>Ealing</li>'+'<li>W13 9SS</li>'+'</ul>'+
    '</div>';
	
	var infowindow = new google.maps.InfoWindow({
    content: contentString
});

google.maps.event.addListener(marker, 'mouseover', function() {
  infowindow.open(map,marker);
});
}
google.maps.event.addDomListener(window, 'load', initialize);
	
