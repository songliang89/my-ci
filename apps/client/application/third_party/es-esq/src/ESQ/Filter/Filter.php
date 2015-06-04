<?php

namespace ESQ\Filter;
use ESQ;

/**
 * Custom filter class
 */
class Filter extends AbstractFilter {

    protected $type;
    protected $content;

    public function __construct ($type, $content) {
        $this->type = $type;
        $this->content = $content;
    }

    public function compile() {
        return array($this->type => $this->content,);
    }

}
