<?php

namespace ESQ\Query;

class MatchAllQuery extends AbstractQuery {
    public function __construct () {
    }
    public function compile() {
        return array('match_all' => new \StdClass());
    }
}
