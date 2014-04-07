<?php

class db
{
  public static function Query( $stmt, $single_row = false )
  {
    $res = mssql_query($stmt);

    if ($res === true)
      return null;
    if (!mssql_num_rows($res))
      $ret = null;
    else
      if ($single_row)
        $ret = mssql_fetch_assoc($res);
      else
      {
        $ret = [];
        while ($row = mssql_fetch_assoc($res))
          array_push($ret, $row);
      }
    mssql_free_result($res);
    return $ret;
  }
}