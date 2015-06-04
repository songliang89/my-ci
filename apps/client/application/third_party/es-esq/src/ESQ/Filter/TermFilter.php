<?php

namespace ESQ\Filter;

/**
 * 
 */
class TermFilter extends AbstractFilter {

    protected $field;
    protected $term;
    protected $options;

    public function __construct ($field, $term, $options=array()) {
        $this->field = $field;
        $this->term = $term;
        $this->options = $options;
    }

    public function compile() {
        //convert int or float distance to 
        $base = array(
            $this->field => $this->term,
        );
        return array('term' => array_merge($base, $this->options));
    }

}
