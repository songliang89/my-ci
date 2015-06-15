<?php

namespace ESQ\Sort;

class ScriptSort extends AbstractSort {

    protected $script;
    protected $params;
    protected $type;
    protected $order;
    protected $options;

    public function __construct ($script, $params=array(), $type='number', $order='asc', $options=array()) {
        $this->script = $script;
        $this->params = $params;
        $this->type = $type;
        $this->order = $order;
        $this->options = $options;
    }

    public function compile() {
        $base = array(
            'script' => $this->script,
            'type' => $this->type,
            'params' => $this->params,
            'order' => $this->order,
        );
        return array('_script' => array_merge($base, $this->options));
    }

    /**
     * Since we really don't know a field value in a script sort,
     * expose field name as _script, so at least, we still have a reference
     */
    public function getField() {
        return '_script';
    }
}
