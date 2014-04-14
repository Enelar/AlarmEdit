<?php

class block extends api
{
  protected function Reserve()
  {
    return [
      "design" => "block/entry",
      "result" => "content",
      "data" => LoadModule('api', 'block')->Get()
    ];
  }
  
  protected function Get()
  {
    $res = db::Query("SELECT id, name, BLOCK_PRIORITY as prio FROM dbo.BLOCK");
    return ["data" => ["blocks" => $res]];
  }
  
  protected function Add( $name )
  {
    $res = db::Query("INSERT INTO dbo.BLOCK (name, BLOCK_PRIORITY) VALUES ($1, $2)",
      [$name, 0], true);
  }
}