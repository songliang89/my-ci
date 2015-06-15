<?php

namespace ESQ\Filter;

/**
 * 
 */
class GeoDistanceFilter extends AbstractGeoFilter {

    protected $field;
    protected $distance;
    protected $point;
    protected $options;

    public function __construct ($field, $distance, $point, $options=array()) {
        $this->field = $field;
        $this->point = $point;
        $this->options = $options;
        $this->distance = $this->parseDistance($distance);
    }

    public function compile() {
        //convert int or float distance to 
        $base = array(
            'distance' => $this->distance,
            $this->field => $this->point,
        );
        return array('geo_distance' => array_merge($base, $this->options));
    }

}
