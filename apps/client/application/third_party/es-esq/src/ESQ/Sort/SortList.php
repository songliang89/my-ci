<?php

namespace ESQ\Sort;
use ESQ\Sort\AbstractSort;
use ESQ\Sort\SimpleSort;

class SortList implements \ESQ\ICompilable {

    protected $items;

    public function __construct () {
        $this->items = null;
    }

    public function compile() {
        if ($this->items === null) {
            return null;
        }
        else {
            $sort = array();
            foreach ($this->items as $item) {
                $sort[] = $item->compile();
            }
            return $sort;
        }
    }

    /**
     * Append a sort option to this sort list.
     * Either give it an intance of AbstractSort or
     * pass a fieldname and options as a shortcut to creating a SimpleSort
     * e.g. ->by('my_field', 'desc')
     */
    public function by($field, $options=null) {
        if($this->items === null) {
            $this->items = array();
        }

        if($field instanceof AbstractSort) {
            $this->items[] = $field;
        }
        else {
            $this->items[] = new SimpleSort($field, $options);
        }
        return $this;
    }

    /**
     * Clear sort order, optionally accept $field as a shortcut to clear_field 
     */
    public function clear($field=null) {
        if($field !== null) {
            $this->clear_field($field);
        }
        else {
            $this->items = null;
        }
        return $this;
    }

    public function clear_field($field) {
        if(is_array($this->items)) {
            $keptItems = array();
            foreach($this->items as $item) {
                if ($item->getField() !== $field) {
                    $keptItems[] = $item;
                }
            }
            $this->items = $keptItems;
        }
        return $this;
    }

}
