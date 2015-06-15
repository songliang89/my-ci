<?php

namespace ESQ\Filter;

/**
 * RangeFilter, compiles to elasticsearch range filter
 */
class RangeFilter extends AbstractFilter{

    protected $field;
    protected $range;

    public function __construct ($field, $range) {
        $this->field = $field;
        $this->range = $range;
    }

    public function compile() {
        return array('range' => array(
            $this->field => $this->range
        ));
    }

}
