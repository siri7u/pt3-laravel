
<style>
    #map {
        height: 500px;
    }
</style>


<script type="application/javascript">
    var map = L.map('map').setView([0, 0], 1);
    L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=CZhoDNPVBHSRiPKPQGHH', {
        tileSize: 512,
        zoomOffset: -1,
        minZoom: 1,
        //attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">© MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap contributors</a>',
        crossOrigin: true
    }).addTo(map);

    $(document).ready(function() {

        map.invalidateSize();

    });


</script>