<?php
function botrowocra_print_map(){
    $_field_Points_slug = get_option('field_Points_slug');
    $_field_Points_slug__lines = explode(PHP_EOL, $_field_Points_slug);

    $_get_points = get_points($_field_Points_slug__lines);
    $lats = $_get_points['lats'];
    $lngs = $_get_points['lngs'];
    $addresses = $_get_points['addresses'];
    $point_description = $_get_points['point_description'];
    $titles = $_get_points['titles'];
    ?>
    <script>
        var marker = '';
        var infowindow = '';
        var contentString = '';
        var current_infowindow = null;

        function initMap() {
            var _center = {lat: <?php echo get_option('field_Center_lat_slug')?>, lng: <?php echo get_option('field_Center_lng_slug')?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: <?php echo get_option('field_Center_zoom_slug')?>,
                center: _center
            });
            var lats = <?php echo str_replace('\r', '', trim(json_encode($lats)));?>;
            var lngs = <?php echo str_replace('\r', '', trim(json_encode($lngs)));?>;
            var _point_description = <?php echo str_replace('\r', '', trim(json_encode($point_description)));?>;

            for (var i = 0; i < _point_description.length; ++i) {
                var marker = new google.maps.Marker({
                    position: {lat: parseFloat(lats[i]),lng: parseFloat(lngs[i])},
                    map: map
                });

                attachPointsToMap(marker, _point_description[i]);
            }
        }

        function attachPointsToMap(marker, point_description) {
            var infowindow = new google.maps.InfoWindow({
                content: point_description
            });

            marker.addListener('click', function() {
                if(current_infowindow){
                    current_infowindow.close();
                }
                infowindow.open(marker.get('map'), marker);
                current_infowindow = infowindow;
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_option('map_api_key');?>&callback=initMap"></script>

    <div class="row">
        <div class="col-md-12 mb-4">
            <h1><?php echo the_title();?></h1>
            <?php if(!empty(get_the_post_thumbnail_url())){?>
                <a title="<?php echo the_title();?>" href="<?php the_permalink(); ?>"><img class="img_thumbnail" src="<?php echo get_the_post_thumbnail_url();?>"/></a>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <?php
            echo '<div id="map"></div>';
            echo '<table class="table">';
                $i = 0;
                foreach($point_description as $_){
                    echo '<tr>';
                        echo '<td>'.$titles[$i].'</td>';
                        echo '<td>'.$lats[$i].'</td>';
                        echo '<td>'.$lngs[$i].'</td>';
                        echo '<td>'.$point_description[$i].'</td>';
                        echo '<td>'.$addresses[$i].'</td>';
                    echo '</tr>';
                    $i++;
                }
            echo '</table>';
            ?>
        </div>
    </div><?php
} 
add_shortcode('get_map', 'botrowocra_print_map');