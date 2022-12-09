<?php

namespace Finder\Ohdb;

class Ohdb
{
    public config $config;
    public table $table;
    public data $data;
    public edit $edit;
    public license $license;

    public function __construct()
    {
        $this->license = new License;
        if ($this->license->license() == false) {
            print ("License not found");
        } else {
            $this->license->licenseValidation();
            $this->config = new Config;
            $this->table = new Table;
            $this->edit = new Edit;
            $this->data = new Data;
        }
    }
}
