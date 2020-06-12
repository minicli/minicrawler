<?php

namespace App\Service;

use Minicli\App;
use Minicli\ServiceInterface;

class DBService implements ServiceInterface
{
    protected $resource;
    protected $db_file;
    protected $table_name;

    public function load(App $app)
    {
        $this->db_file = $app->config->db_file;
        $this->table_name = $app->config->table_name;

        $this->bootstrapDB();
    }

    public function insertData($url, $views)
    {
        $query = sprintf("INSERT INTO %s (url, views, fetch_date) VALUES('%s', '%s', '%s')", $this->table_name, $url, $views, date('Y-m-d H:i:s'));
        //echo $query;
        return $this->resource->exec($query);
    }

    public function bootstrapDB()
    {
        $this->resource = new \SQLite3($this->db_file);
        $this->resource->exec("CREATE TABLE if not exists $this->table_name(id INTEGER PRIMARY KEY, url STRING, views INTEGER, fetch_date DATETIME)");
    }
}