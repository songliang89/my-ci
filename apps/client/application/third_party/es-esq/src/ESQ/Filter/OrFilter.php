<?php

namespace ESQ\Filter;

/**
 * 
 */
class OrFilter extends AbstractFilter {

    protected $filters;

    public function __construct ($filters) {
        $this->filters = $filters;
    }

    public function compile() {
        $compiledFilters = array();
        foreach($this->filters as $filter) {
            $compiledFilters[] = $filter->compile();
        }
        return array('or' => $compiledFilters);
    }

}
