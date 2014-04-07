<?php

class main extends api
{
  protected function Reserve()
  {
    return [
      "design" => "body"
    ];
  }
  
  protected function Home()
  {
    return LoadModule('api', 'alarm_prio', true)->Reserve();
  }
}