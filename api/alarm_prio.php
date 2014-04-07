<?php

class alarm_prio extends api
{
  protected function Reserve()
  {
    return [
      "design" => "table",
      "result" => "content",
      "data" => 
      [
        "types" => LoadModule('api', 'alarm_prio')->Types(),
        "tags" => LoadModule('api', 'alarm_prio')->Tags()
      ]
    ];
  }

  protected function Tags()
  {
    $ret = db::Query("SELECT id, CAST(name as text) as name, CAST(description as text) as description FROM [dbo].[TAG] ORDER BY TAG.name ASC");
    return ["data" => $ret];
  }
  
  protected function TagValues( $id )
  {
    $res = mssql_query("SELECT type, priority FROM [dbo].[ALARM] WHERE id_tag=$id");
  }
  
  protected function Types()
  {
    $ret = db::Query("SELECT type FROM [dbo].[ALARM] GROUP BY type");
    return ["data" => $ret];
  }
  
  protected function Value( $tag, $type )
  { // yep i know what is sqlinj
    $ret = db::Query("SELECT * FROM [dbo].[ALARM] WHERE id_tag=(SELECT id FROM [dbo].[TAG] WHERE name='$tag') AND type='$type'");
    if ($ret == null)
      $ret = ["id" => null, "PRIORITY" => null];
    $ret['prio'] = $ret["PRIORITY"];
    return [
      "design" => "input",
      "data" => $ret
    ];
  }
  
  protected function Update( $id, $val )
  { // yep i know what is sqlinj
    db::Query("UPDATE [dbo].[ALARM] SET priority=$val WHERE id=$id");
    $row = db::Query("SELECT priority as p FROM [dbo].[ALARM] WHERE id=$id", true);
    return ["data" => ["res" => $row["p"] == $val]];
  }

}