<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?=base_url()?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?=base_url()?>plugins/jQueryUI/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_url()?>bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>dist/js/app.min.js"></script>

<script src="<?=base_url()?>plugins/datatables/jquery.dataTables.min.js"></script>
<!-- Slimscroll -->
<script src="<?=base_url()?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url()?>plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>dist/js/app.min.js"></script>

<script src="<?=base_url()?>plugins/timepicker/bootstrap-timepicker.min.js"></script>

<?php if (isset($ajaxtable )) { ?>

<script>
    $.widget.bridge('uibutton', $.ui.button);
$(document).ready(function() {
   $('#tableData')
    .addClass( 'nowrap' )
    .DataTable( {
      "pageLength": 10,
      "paging": true,
      "autoWidth": true,
      "info": true,
      "processing": true,
      "serverSide": true,
      "ordering": false,
      "ajax": "<?=$ajaxtable?>"
    } );
} );


</script>



<?php } ?>

<?php if (isset($buses )) { ?>
<script>

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });

</script>

<?php } ?>
<?php if (isset($map )) { ?>
   <script>

      // If you're adding a number of markers, you may want to drop them on the map
      // consecutively rather than all at once. This example shows how to use
      // window.setTimeout() to space your markers' animation.

      var neighborhoods = [
        {lat: 52.511, lng: 13.447},
        {lat: 52.549, lng: 13.422},
        {lat: 52.497, lng: 13.396},
        {lat: 52.517, lng: 13.394}
      ];

      var markers = [];
      var map;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: {lat: 14.531131, lng: 121.021210}
        });
       loadPins();
        setInterval(function(){loadPins(); }, 6000);
      }




      function loadPins() {
         $.getJSON("<?=$gps_url?>", function(data, status){
            clearMarkers();
            data.forEach(function(bus) {
               console.log(bus.bus_name);
               addMarkerWithTimeout({lat: parseFloat(bus.latitude), lng: parseFloat(bus.longitude)}, bus.bus_name, 200);
            });
         });
      }

      function addMarkerWithTimeout(position, title,  timeout) {
        window.setTimeout(function() {
          var marker = new google.maps.Marker({
            position: position,
            map: map,
            title: title,
            animation: google.maps.Animation.DROP
          });

         var contentString = '<div id="content">' + title + '</div>';

         var infowindow = new google.maps.InfoWindow({ content: contentString });

          marker.addListener('click', function() { infowindow.open(map, marker); });

          markers.push(marker);
          map.setCenter(position);
        }, timeout);


      }

      function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?=$map?>&callback=initMap">
    </script>
<?php } ?>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
