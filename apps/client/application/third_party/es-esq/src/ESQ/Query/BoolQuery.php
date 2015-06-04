<?php

namespace ESQ\Query;
use ESQ\ESQ;

class BoolQuery extends AbstractQuery {

    protected $must;
    protected $should;
    protected $must_not;
    protected $options;

    public function __construct (array $options=array()) {
        $this->must(null);
        $this->should(null);
        $this->mustNot(null);

        if(isset($options['must'])) $this->must($options['must']);
        if(isset($options['should'])) $this->should($options['should']);
        if(isset($options['must_not'])) $this->mustNot($options['must_not']);
        unset($options['must']);
        unset($options['should']);
        unset($options['must_not']);

        $this->options = $options;
    }

    public function compile () {
        $base = array();
        if(!empty($this->must)) {
            $base['must'] = ESQ::walkCompile($this->must);
        }
        if(!empty($this->should)) {
            $base['should'] = ESQ::walkCompile($this->should);
        }
        if(!empty($this->must_not)) {
            $base['must_not'] = ESQ::walkCompile($this->must_not);
        }
        return array('bool' => array_merge($base, $this->options));
    }

    /**
     * Set custom keys like boost or minimum_should_match
     */
    public function setKey($key, $value) {
        $this->options[$key] = $value;
        return $this;
    }
    public function unsetKey($key) {
        unset($this->options[$key]);
        return $this;
    }



    /**
     * must adds to the must field of the bool query.
     * Pass null as first argument to clear the internal must field.
     */
    public function must ($queries = array()) {
        if($queries === null) { 
            $this->must = array();
        }
        else {
            if(!is_array($queries)) {
                $queries = array($queries);
                $this->must = array_merge($this->must, $queries);
            }
        }
        return $this;
    }

    /**
     * should adds to the should field of the bool query.
     * Pass null as first argument to clear the internal should field.
     */
    public function should ($queries = array()) {
        if($queries === null) { 
            $this->should = array();
        }
        else {
            if(!is_array($queries)) {
                $queries = array($queries);
                $this->should = array_merge($this->should, $queries);
            }
        }
        return $this;
    }

    /**
     * mustNot adds to the must_not field of the bool query.
     * Pass null as first argument to clear the internal must_not field.
     */
    public function mustNot ($queries = array()) {
        if($queries === null) { 
            $this->must_not = array();
        }
        else {
            if(!is_array($queries)) {
                $queries = array($queries);
                $this->must_not = array_merge($this->must_not, $queries);
            }
        }
        return $this;
    }
    //wraps mustNot
    public function must_not ($queries = array()) {
        return $this->mustNot($queries);
    }


}
