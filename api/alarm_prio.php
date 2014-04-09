<?php

class alarm_prio extends api
{
  protected function Reserve( $level = 1 )
  {
    return [
      "design" => "table",
      "result" => "content",
      "data" => 
      [
        "types" => LoadModule('api', 'alarm_prio')->Types(),
        "tags" => LoadModule('api', 'alarm_prio')->Tags($level)
      ]
    ];
  }

  protected function Tags( $level = 1 )
  {
    $res = db::Query("
      SELECT id, CAST(name as text) as name, CAST(description as text) as description
      FROM [dbo].[TAG]
      WHERE is_analog = 1
      ORDER BY TAG.name ASC");
    $ret = [];
    foreach ($res as $row)
    {
      $row['values'] = $this->TagValues($row['id'], $level);
      if (!count($row['values']))
        continue;
      array_push($ret, $row);
    }
    return ["data" => $ret];
  }

  public function TagValues( $id, $level = 1 )
  {
    $res = db::Query("
      SELECT id, type, priority
      FROM [dbo].[ALARM]
      WHERE id_tag=$id AND base_level = $level");
    $ret = [];
    if (count($res))
      foreach ($res as $row)
        $ret[$row['type']] = $row;
    return $ret;
  }
  
  protected function Types()
  {
    $ret = [];
    foreach (["HI", "LO", "NR", "IOP", "IOP-", "ANS+", "ANS-", "ALM"] as $t)
      array_push($ret, ['name' => $t]);
    return ["data" => $ret];
  }
  
  protected function Update( $id, $val )
  { // yep i know what is sqlinj
    db::Query("UPDATE [dbo].[ALARM] SET priority=$val WHERE id=$id");
    $row = db::Query("SELECT priority as p FROM [dbo].[ALARM] WHERE id=$id", true);
    return ["data" => ["res" => $row["p"] == $val]];
  }

}