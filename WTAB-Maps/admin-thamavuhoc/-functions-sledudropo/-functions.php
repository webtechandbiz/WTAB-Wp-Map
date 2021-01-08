<?php

function get_points($_points){
    $n = 0;
    foreach($_points as $line){
        $_points_cols = explode(',', $line);
        $lat = $_points_cols[0];
        $lats[$n] = $lat;
        $lng = $_points_cols[1];
        $lngs[$n] = $lng;

        if($lat !== ''){
            $title = $_points_cols[2];
            $address = $_points_cols[3];
            $point_description[$n] = $title.'<br>'.$address;
            $addresses[$n] = $address;
            $titles[$n] = $title;
            $n++;
        }
    }
    return array('lats' => $lats, 'lngs' => $lngs, 'point_description' => $point_description, 'addresses' => $addresses, 'titles' => $titles);
}