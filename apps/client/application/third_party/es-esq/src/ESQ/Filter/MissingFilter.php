<?php

namespace ESQ\Filter;

/**
 * RangeFilter, compiles to elasticsearch range filter
 */
class MissingFilter extends AbstractFilter {

    protected $field;

    public function __construct ($field) {
        $this->field = $field;
    }

    public function compile() {
        return array('missing' => array(
            'field' => $this->field
        ));
    }

}
