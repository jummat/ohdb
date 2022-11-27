<?php

namespace Finder\Ohdb;

class Ohdb
{
    public table $table;
    public config $config;
    public data $data;
    public edit $edit;

    public function __construct()
    {
        $this->table = new Table;
        $this->config = new Config;
        $this->edit = new Edit;
        $this->data = new Data;
    }
}
