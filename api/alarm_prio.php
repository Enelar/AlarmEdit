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
    $res = mssql_query("SELECT id, CAST(name as text) as name, CAST(description as text) as description FROM [dbo].[TAG] ORDER BY TAG.name ASC");
    $ret = [];
    
    do {
      while ($row = mssql_fetch_assoc($res)) {
        array_push($ret, $row);
      }
    } while (mssql_next_result($res));

    return ["data" => $ret];
  }
  
  protected function Types()
  {
    $res = mssql_query("SELECT type FROM [dbo].[ALARM] GROUP BY type");
    $ret = [];
    do {
      while ($row = mssql_fetch_row($res)) {
        array_push($ret, ["name" => $row[0]]);
      }
    } while (mssql_next_result($res));
    
    return ["data" => $ret];
  }
  
  protected function Value( $tag, $type )
  { // yep i know what is sqlinj
    $res = mssql_query("SELECT * FROM [dbo].[ALARM] WHERE id_tag=(SELECT id FROM [dbo].[TAG] WHERE name='$tag') AND type='$type'");
    if (mssql_num_rows($res))
      $ret = mssql_fetch_assoc($res);
    else
      $ret = ["id" => null, "PRIORITY" => null];
    $ret['prio'] = $ret["PRIORITY"];
    return [
      "design" => "input",
      "data" => $ret
    ];
  }
  
  protected function Update( $id, $val )
  { // yep i know what is sqlinj
    $res = mssql_query("UPDATE [dbo].[ALARM] SET priority=$val WHERE id=$id");
  }

}