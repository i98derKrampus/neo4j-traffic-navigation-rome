<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<?php echo $loi->__get('name'); ?>

<div id="mapa"></div>

<br/>

<form method="POST" action="<?php echo __SITE_URL . '/index.php?rt=main/search'?>">
    <input type="radio" name="source_type" id="map_centre" value="map_centre"/>
    <label for="map_centre">Najbliža točka središtu mape</label>
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

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>