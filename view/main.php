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

    <button type="submit" name="add_pt1">Dodaj ishodište!</button>
    <button type="submit" name="add_pt2">Dodaj odredište!</button>
    <br/>
    <button type="submit" name="find_path">Nađi najkraći put!</button>
    <button type="submit" name="find_path_quickest">Nađi najbrži put!</button>
</form>

<h4>Trenutno ishodište:</h4>
<span id="ishodiste"><?php echo $pt1; ?></span>
<br/>

<h4>Trenutno odredište:</h4>
<span id="odrediste"><?php echo $pt2; ?></span>


    <script>
let openLayerMap = null;
let centerMarker = null;
let sourceMarker = null;
let targetMarker = null;

$(document).ready(function()
{
    loadMap();
    updateCenterMap();

    $("#mapa").on("mouseleave", updateCenterMap);
    setInterval(updateCenterMap, 100);

    $("body").on('click', "span", function(){
        let id = $(this).attr("id");
        if(id === "ishodiste"){
            let source_lat = "<?php 
                if(is_null($pt1_lat)){
                    echo "null";
                } else{
                    echo $pt1_lat;
                }?>";
            if(source_lat !== "null"){
                let source_lon = "<?php echo $pt1_lon;?>";
                source_lat = parseFloat(source_lat);
                source_lon = parseFloat(source_lon);
                openLayerMap.getView().setCenter(ol.proj.fromLonLat([source_lon, source_lat]));
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
        }
        if(id === "odrediste"){
            let target_lat = "<?php 
                if(is_null($pt2_lat)){
                    echo "null";
                } else{
                    echo $pt2_lat;
                }?>";
            if(target_lat !== "null"){
                let target_lon = "<?php echo $pt2_lon;?>";
                target_lat = parseFloat(target_lat);
                target_lon = parseFloat(target_lon);
                openLayerMap.getView().setCenter(ol.proj.fromLonLat([target_lon, target_lat]));
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
        }
        
    })

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
    let centerMarker_div = document.createElement('div');
    centerMarker_div.innerHTML = '<img src="https://cdn.mapmarker.io/api/v1/fa/stack?size=50&color=DC4C3F&icon=fa-microchip&hoffset=1" />';
    centerMarker = new ol.Overlay({
            position: ol.proj.fromLonLat([centerLon, centerLat]),
            positioning: 'center-center',
            element: centerMarker_div,
            stopEvent: false
    });
    openLayerMap.addOverlay(centerMarker);

    let source_lat = "<?php 
            if(is_null($pt1_lat)){
                echo "null";
            } else{
                echo $pt1_lat;
            }
        ?>";
    if(source_lat !== "null"){
        let source_lon = "<?php echo $pt1_lon;?>";
        source_lat = parseFloat(source_lat);
        source_lon = parseFloat(source_lon);
        let sourceMarker_div = document.createElement('div');
        sourceMarker_div.innerHTML = '<img src="https://cdn.mapmarker.io/api/v1/fa/stack?size=40&color=0000FF&icon=fa-microchip&hoffset=1" />';
        sourceMarker = new ol.Overlay({
            position: ol.proj.fromLonLat([source_lon, source_lat]),
            positioning: 'center-center',
            element: sourceMarker_div,
            stopEvent: false
        });
        openLayerMap.addOverlay(sourceMarker);
    }

    let target_lat = "<?php 
            if(is_null($pt2_lat)){
                echo "null";
            } else{
                echo $pt2_lat;
            }
        ?>";
    if(target_lat !== "null"){
        let target_lon = "<?php echo $pt2_lon;?>";
        target_lat = parseFloat(target_lat);
        target_lon = parseFloat(target_lon);
        let targetMarker_div = document.createElement('div');
        targetMarker_div.innerHTML = '<img src="https://cdn.mapmarker.io/api/v1/fa/stack?size=40&color=0000FF&icon=fa-microchip&hoffset=1" />';
        targetMarker = new ol.Overlay({
            position: ol.proj.fromLonLat([target_lon, target_lat]),
            positioning: 'center-center',
            element: targetMarker_div,
            stopEvent: false
        });
        openLayerMap.addOverlay(targetMarker);
    }
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
    centerMarker.setPosition(ol.proj.fromLonLat(coords));
}










    </script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>