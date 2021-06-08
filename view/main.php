<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div id="mapa"></div>

<br/>

<form method="POST" action="<?php echo __SITE_URL . '/index.php?rt=main/search'?>">
    <input type="radio" name="source_type" id="map_centre" value="map_centre" checked/>
    <label for="map_centre">Najbliža točka središtu mape</label>
    <input type="text" name="map_lat" id="map_lat" readonly/>
    <input type="text" name="map_lon" id="map_lon" readonly/>
    <br/>
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

    <button type="submit" name="add_pt1">Dodaj ishodište!</button>
    <button type="submit" name="add_pt2">Dodaj odredište!</button>
    <br/>
    <button type="submit" name="find_path">Nađi najkraći put!</button>
</form>

<h4>Trenutno ishodište:</h4>
<?php echo $pt1; ?>
<br/>

<h4>Trenutno odredište:</h4>
<?php echo $pt2; ?>


    <script>
let openLayerMap = null;

$(document).ready(function()
{
    loadMap();
    updateCenterMap();

    $("#mapa").on("mouseleave", updateCenterMap);
    setInterval(updateCenterMap, 100);

});

function loadMap(centerLat = 41.8988, centerLon = 12.5451)
{
    openLayerMap = new ol.Map(
        {
            target: "mapa",
            layers:
            [
                new ol.layer.Tile({source: new ol.source.OSM()})
            ],
            view: new ol.View(
                {
                    center: ol.proj.fromLonLat([centerLon, centerLat]),
                    zoom: 9
                }
            )
        }
    );
}

function updateCenterMap()
{
    let coords = ol.proj.transform(
        openLayerMap.getView().getCenter(),
        openLayerMap.getView().getProjection().getCode(),
        'EPSG:4326'
    );

    $("#map_lat").val(coords[1].toString());
    $("#map_lon").val(coords[0].toString());
}










    </script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>