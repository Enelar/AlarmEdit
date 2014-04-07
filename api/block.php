<?php

class block extends api
{
  protected function Reserve()
  {
    return [
      "design" => "block",
      "result" => "content",
      "data" => ["blocks" => []]
    ];
  }
}