<?php

namespace ESQ;

class Search implements ICompilable {

    protected $from;
    protected $size;
    protected $fields;
    protected $sortList;
    protected $queryObject;
    protected $customFields;


    public function __construct () {
        //initialize values
        $this->size(null);
        $this->from(null);
        $this->fields(null);
        $this->sort();

        $this->queryObject = null;

        $this->customFields = array();
    }

    /**
     * Get structure used for json encoding
     */
    public function compile () {
        $c = $this->customFields;
        //handle sort
        $sort = $this->sortList->compile();
        if ($sort !== null) $c['sort'] = $sort;
        if ($this->size !== null) $c['size'] = $this->size;
        if ($this->from !== null) $c['from'] = $this->from;
        if($this->fields !== null) $c['fields'] = $this->fields;
        
        if($this->queryObject !== null) {
            $c['query'] = $this->queryObject->compile();
        }
        else {
            throw new ESQException('No query defined');
        }
        return $c;
    }

    /**************************
        size and from
    **************************/

    /** 
     * Set size
     */
    public function size($size) {
        //validate input
        if ($size !== null && (!is_int($size) || $size < 0)) {
            throw new \InvalidArgumentException('first argument must be positive integer');
        }
        //set size
        $this->size = $size;
        return $this;
    }

    /**
     * set from
     */
    public function from ($from) {
        //validate input
        if ($from !== null && (!is_int($from) || $from < 0)) {
            throw new \InvalidArgumentException('first argument must be positive integer');
        }
        //set value
        $this->from = $from;
        return $this;
    }

    /**************************
        fields
    **************************/

    /**
     * Select specific fields to be returned
     */
    public function fields($fields) {
        //if null, clear fields
        if($fields === null) {
            $this->fields = null;
        }
        //else merge fields
        else {
            //validate input
            if(is_string($fields)) {
                $fields = array($fields);
            }
            if(!is_array($fields)) {
                throw new \InvalidArgumentException('argument must be string or array of strings');
            }
            //if fields does not exist, create empty array
            if(!is_array($this->fields)) {
                $this->fields = array();
            }

            //merge the two arrays
            $this->fields = array_merge($this->fields, $fields);
        }
        return $this;
    }

    /**************************
        query
    **************************/

    public function query(\ESQ\Query\AbstractQuery $queryObject) {
        $this->queryObject = $queryObject;
        return $this;
    }

    /**
     * Shortcut for creating a match_all query
     */
    public function match_all() {
        $this->query(new \ESQ\Query\MatchAllQuery());
        return $this;
    }

    /**************************
        set custom properties
    **************************/

    public function setKey($key, $value) {
        $this->customFields[$key] = $value;
        return $this;
    }

    public function unsetKey($key) {
        unset($this->customFields[$key]);
        return $this;
    }



    /**************************
        sort
    **************************/

    /**
     * return a proxied SortList
     */
    public function sort($sortList=null) {
        if(is_null($sortList)) {
            if(is_null($this->sortList)) {
                $this->sortList = new \ESQ\Sort\SortList();
            }
        }
        elseif ($sortList instanceof \ESQ\Sort\SortList) {
            $this->sortList = $sortList;
        }
        else {
            throw new \InvalidArgumentException('first argument must be instance of SortList or null');
        }

        $proxy = new Proxy($this->sortList);
        $search = $this;
        return $proxy->register('back', function () use ($search) {
            return $search;
        });
    }

    /**
     * Shortcut for setting sort order, while still returning $search instance
     */
    public function sort_by($field, $option=null) {
        $this->sort()->by($field, $option);
        return $this;
    }

}
