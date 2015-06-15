<?php

namespace ESQ\Sort;

class SimpleSort extends AbstractSort {

    protected $field;
    protected $options;

    public function __construct ($field, $options=null) {
        $this->field = $field;
        $this->options = null;

        if(is_string($options)) {
            $this->options = array('order' => $options);
        }
        elseif(is_array($options)) {
            $this->options = $options;
        }
        elseif($options !== null) {
            throw new \InvalidArgumentException('second argument should be string (sort order) or array (options)');
        }
    }

    public function compile() {
        if($this->options === null) {
            return $this->field;
        }
        else {
            return array($this->field => $this->options);
        }
    }

    public function getField() {
        return $this->field;
    }
}
