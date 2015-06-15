<?php

namespace ESQ\Filter;

/**
 * 
 */
class GeoDistanceRangeFilter extends AbstractGeoFilter {

    protected $field;
    protected $point;
    protected $from;
    protected $to;
    protected $options;

    public function __construct ($field, $from, $to, $point, $options=array()) {
        $this->field = $field;
        $this->point = $point;
        $this->from = $this->parseDistance($from);
        $this->to = $this->parseDistance($to);
        $this->options = $options;
    }

    public function compile() {
        //convert int or float distance to 
        $base = array(
            'from' => $this->from,
            'to' => $this->to,
            $this->field => $this->point,
        );
        return array('geo_distance_range' => array_merge($base, $this->options));
    }

}
