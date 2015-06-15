<?php

namespace ESQ\Query;

class TermsQuery extends AbstractQuery {

    protected $field;
    protected $terms;
    protected $options;

    public function __construct ($field, $terms, $options=array()) {
        $this->field = $field;
        $this->terms = $terms;
        $this->options = $options;
    }

    public function compile () {
        $base = array( $this->field => $this->terms );
        return array('terms' => array_merge($base, $this->options));
    }
}
