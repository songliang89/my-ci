<?php

namespace ESQ\Sort;

class GeoDistanceSort extends AbstractSort {

    protected $field;
    protected $location;
    protected $options;
    protected $order;

    public function __construct ($field, $location, $order=null, $options=array()) {
        $this->field = $field;
        $this->order = $order;
        $this->location = $location;
        $this->options = $options;

    }

    public function compile() {
        $base = array(
            $this->field => $this->location,
            'unit' => \ESQ\ESQ::DEFAULT_DISTANCE_UNIT,
        );
        if($this->order !== null) $base['order'] = $this->order;
        return array('_geo_distance' => array_merge($base, $this->options));
    }

    public function getField() {
        return $this->field;
    }
}
