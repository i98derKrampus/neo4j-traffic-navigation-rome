<?php require_once __SITE_PATH.'/view/_header.php'; ?>

    <div id="mapa"></div>

    <br/>
    <div class="centar">Centar mape:
        <input type="text" name="map_lat" id="map_lat" readonly/>
        <input type="text" name="map_lon" id="map_lon" readonly/>
    </div>

    <form method="POST" action="<?php echo __SITE_URL.'/index.php?rt=main/search' ?>">
        <input type="radio" name="source_type" id="lat_lon" value="lat_lon"/>
        <label for="lat_lon">Unesite zemljopisnu širinu i dužinu u stupnjevima:</label>
        <input type="text" name="text_lat"/>
        <select name="text_lat_smjer">
            <option value="N">sjeverno</option>
            <option value="S">južno</option>
        </select>
        <input type="text" name="text_lon"/>
        <select name="text_lon_smjer">
            <option value="E">istočno</option>
            <option value="W">zapadno</option>
        </select>
        <br/>
        <input type="radio" name="source_type" id="name_search" value="name_search"/>
        <label for="name_search">Pretraživanje po dijelu imena:</label>
        <input type="text" name="text_name_search"/>
        <br/>

        <button type="submit" name="add_pt1" id="origin">Dodaj ishodište!</button>
        <button type="submit" name="add_pt2" id="destination">Dodaj odredište!</button>
        <br/>
        <button type="submit" name="find_path">Nađi najkraći put!</button>
        <button type="submit" name="find_path">Nađi najkraći put!</button>
    </form>

    <h4>Trenutno ishodište:</h4>
<?php echo $pt1; ?>
    <br/>

    <h4>Trenutno odredište:</h4>
<?php echo $pt2; ?>


    <script>
        let openLayerMap = null;
        var markers = [];
        var setting = "origin"

        $(document).ready(function () {
            loadMap();
            updateCenterMap();

            $("#mapa").on("click", updateCenterMap);
            $("#origin").on("click", function ( setting = "destination" ){})
        });

        function loadMap() {
            openLayerMap = L.map('mapa').setView(
                [41.89536138648265, 91452.48424530031],
                12.5
            );
            markerClusters = L.markerClusterGroup;
            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                minZoom = 9,
                maxZoom = 20
            ).addTo(openLayerMap);
            openLayerMap.on('click', onMapClick);
        }

        function updateCenterMap() {
            let coords = openLayerMap.getCenter();
            $("#map_lat").val(coords.lat);
            $("#map_lon").val(coords.lng);
        }


        function onMapClick(e) {
            if(
                markers.length === 1 &&
                setting === "origin" &&
                confirm("Ponovno postaviti početnu lokaciju?")
            ){
                openLayerMap.removeLayer(markers[0]);
                markers.pop();
                return;
            }
            else if (
                markers.length === 2 &&
                setting === "destnation" &&
                confirm("Ponovno postaviti krajnju lokaciju?")
            ) {
                openLayerMap.removeLayer(markers[0]);
                markers.pop();
                return;
            }

            markers.push(L.marker(e.latlng).addTo(openLayerMap));
        }


    </script>

<?php require_once __SITE_PATH.'/view/_footer.php'; ?>