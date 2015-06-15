<?php

namespace ESQ\Query;

class CustomQuery extends AbstractQuery {

    protected $name;
    protected $options;

    public function __construct ($name, $options) {
        $this->name = $name;
        $this->options = $options;
    }

    public function compile () {
        return array($this->name => $this->options);
    }
}
