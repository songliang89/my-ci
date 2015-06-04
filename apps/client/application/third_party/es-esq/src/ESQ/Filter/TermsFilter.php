<?php

namespace ESQ\Filter;

/**
 * 
 */
class TermsFilter extends AbstractFilter {

    protected $field;
    protected $terms;
    protected $options;

    public function __construct ($field, $terms, $options=array()) {
        $this->field = $field;
        $this->terms = $terms;
        $this->options = $options;
    }

    public function compile() {
        //convert int or float distance to 
        $base = array(
            $this->field => $this->terms,
        );
        return array('terms' => array_merge($base, $this->options));
    }

}
