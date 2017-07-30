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
      }

      function drop() {
        clearMarkers();
        for (var i = 0; i < neighborhoods.length; i++) {
          addMarkerWithTimeout(neighborhoods[i], i * 200);
        }
      }

      function addMarkerWithTimeout(position, timeout) {
        window.setTimeout(function() {
          markers.push(new google.maps.Marker({
            position: position,
            map: map,
            animation: google.maps.Animation.DROP
          }));
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
