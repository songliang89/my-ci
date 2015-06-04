<?php

namespace ESQ\Query;
use ESQ\Filter\AbstractFilter;

class FilteredQuery extends AbstractQuery {

    protected $filter;
    protected $query;
    protected $options;

    public function __construct (AbstractFilter $filter, AbstractQuery $query, $options=array()) {
        $this->filter = $filter;
        $this->query = $query;
        $this->options = $options;
    }

    public function compile () {
        $base = array(
            'filter' => $this->filter->compile(),
            'query' => $this->query->compile(),
        );
        return array('filtered' => array_merge($base, $this->options));
    }
}
