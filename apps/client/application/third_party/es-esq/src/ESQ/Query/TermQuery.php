<?php

namespace ESQ\Query;

class TermQuery extends AbstractQuery {

    protected $field;
    protected $term;
    protected $options;

    public function __construct ($field, $term, $options=array()) {
        $this->field = $field;
        $this->term = $term;
        $this->options = $options;
    }

    public function compile () {
        $base = array( $this->field => array('value' => $this->term) );
        return array('term' => array_merge($base, $this->options));
    }
}
