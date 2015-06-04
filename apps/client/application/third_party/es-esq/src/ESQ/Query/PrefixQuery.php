<?php

namespace ESQ\Query;

class PrefixQuery extends AbstractQuery {

    protected $field;
    protected $prefix;
    protected $options;

    public function __construct ($field, $prefix, $options=array()) {
        $this->field = $field;
        $this->prefix = $prefix;
        $this->options = $options;
    }

    public function compile () {
        $base = array( $this->field => array('value' => $this->prefix) );
        return array('prefix' => array_merge($base, $this->options));
    }
}
