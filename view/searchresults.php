<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<div id="mapa"></div>

<br/>

<h2><?php echo $type;?> od ishodišta do odredišta: <?php echo $totalDistance . $unit;?></h2>

<?php
foreach($tocke as $tocka){
    
}
?>

<a href="<?php echo __SITE_URL . '/index.php?rt=main';?>">Vrati se na početnu stranicu</a>
<br/>


<script>

let a = [
    <?php
    foreach($tocke as $tocka){
        echo "{";
        echo "id: " . $tocka->id . ",";
        echo "lat: " . $tocka->lat . ",";
        echo "lon: " . $tocka->lon . ",";
        echo 'name: "' . $tocka->name . '"';
        echo "},";
    }  
    ?>
];

let openLayerMap = null;

$(document).ready(function()
{
    loadMap();

    a.forEach(function(tocka)
    {
        let span = $("<span>");
        span.attr("id", "tocka_"+tocka.id);
        span.html(tocka.lat+"N " + tocka.lon + "E " + tocka.name);
        $("body").append(span).append("<br/>");
    });
    
    $("body").on('click', "span", function(){
        let id = $(this).attr("id").substr(6);
        let tocka = null;
        for(let i = 0; i < a.length; i++){
            if(a[i].id == id){
                tocka = a[i];
            }
        }
        openLayerMap.getView().setCenter(ol.proj.fromLonLat([tocka.lon, tocka.lat]));
        openLayerMap.getView().setZoom(15);
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
}

</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>