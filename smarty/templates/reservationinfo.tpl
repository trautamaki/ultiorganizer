{include file="header.tpl" body_functions='onload=\"load()\" onunload=\"GUnload()\"'}
{include file="leftmenu.tpl"}

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?php echo GetGoogleMapsAPIKey(); ?>" type="text/javascript"></script>
<script type="text/javascript">
  //<![CDATA[
  var map;
  var geocoder;

  function load() {
    if (GBrowserIsCompatible()) {
      geocoder = new GClientGeocoder();
      map = new GMap2(document.getElementById('map'));
      map.addControl(new GSmallMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(62, 25), 4);
    }
    var searchUrl = 'ext/locationxml.php?id={$place.location}';
    searchLocations(searchUrl);
  }

  function searchLocations(searchUrl) {
    GDownloadUrl(searchUrl, function(data) {
      var xml = GXml.parse(data);
      var markers = xml.documentElement.getElementsByTagName('marker');
      map.clearOverlays();

      var bounds = new GLatLngBounds();
      for (var i = 0; i < markers.length; i++) {
        var placeid = markers[i].getAttribute('id');
        var name = markers[i].getAttribute('name');
        var address = markers[i].getAttribute('address');
        var info = markers[i].getAttribute('info');
        var fields = markers[i].getAttribute('fields');

        var indoorBit = markers[i].getAttribute('indoor');
        var indoor = '<?php echo _("outdoors"); ?>';
        if (indoorBit == '1') {
          indoor = '<?php echo _("indoors"); ?>';
        }
        var point = new GLatLng(parseFloat(markers[i].getAttribute('lat')),
          parseFloat(markers[i].getAttribute('lng')));

        var marker = createMarker(point, name, address, info, fields, indoor);
        map.addOverlay(marker);
        GEvent.trigger(marker, 'click');
        bounds.extend(point);
      }
      map.setCenter(bounds.getCenter(), 14);
    });
  }

  function createMarker(point, name, address, info, fields, indoor) {
    var marker = new GMarker(point);
    var html = '<b>' + name + '</b> ' + address + '<br/>' + info +
      '<br/>' + '{t}Fields{/t}' + fields + '(' + indoor + ')';
    GEvent.addListener(marker, 'click', function() {
      marker.openInfoWindowHtml(html);
    });
    return marker;
  }

  //]]>
</script>
<h1>{$place.name} {t}Field{/t} {$place.fieldname}</h1>
<p>{$place.starttime_deftime} - {$place.endtime_deftime}</p>
<p>{$place.address}</p>
<p>{$place.info}</p>
<p>&nbsp;</p>

<div id="map" style="width: 600px; height: 400px; font-family: Arial, sans-serif; font-size: 11px; border: 1px solid black"></div>

{include file="footer.tpl"}