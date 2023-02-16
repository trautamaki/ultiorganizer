<?php

class Database
{
  private $connection;

  public function __construct()
  {
    try {
      $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

      if (mysqli_connect_errno()) {
        throw new Exception("Could not connect to database.");
      }

      $this->connection->set_charset('utf8');

      //check if database is up-to-date
      if (!isset($_SESSION['dbversion'])) {
        $this->CheckDB();
        $_SESSION['dbversion'] = $this->getDBVersion();
      }
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  function __destruct()
  {
    $this->connection->close();
  }

  /**
   * Executes sql query and  returns result as an mysql array.
   *
   * @param string $query database query
   * @return Array of rows
   */
  function DBQuery($query)
  {
    $result = $this->connection->query($query);
    if (!$result) {
      die('Invalid query: ("' . $query . '")' . "<br/>\n" . $this->connection->error);
    }
    return $result;
  }

  /**
   * Executes sql query and returns the ID generated the query.
   *
   * @param string $query database query
   * @return id
   */
  function DBQueryInsert($query)
  {
    $result = $this->connection->query($query);
    if (!$result) {
      die('Invalid query: ("' . $query . '")' . "<br/>\n" . $this->connection->error);
    }
    return $this->connection->insert_id;
  }

  /**
   * Executes sql query and  returns result as an value.
   *
   * @param string $query database query
   * @return Value of first cell on first row
   */
  function DBQueryToValue($query, $docasting = false)
  {
    $result = $this->connection->query($query);
    if (!$result) {
      die('Invalid query: ("' . $query . '")' . "<br/>\n" . $this->connection->error);
    }

    if ($result->num_rows) {
      $row = $result->fetch_row($result);
      if ($docasting) {
        $row = $this->DBCastArray($result, $row);
      }
      return $row[0];
    } else {
      return -1;
    }
  }

  /**
   * Executes sql query and returns number of rows in resultset
   *
   * @param string $query database query
   * @return number of rows
   */
  function DBQueryRowCount($query)
  {
    $result = $this->connection->query($query);
    if (!$result) {
      die('Invalid query: ("' . $query . '")' . "<br/>\n" . $this->connection->error);
    }

    return $result->num_rows;
  }

  /**
   * Executes sql query and copy returns to php array.
   *
   * @param string $query database query
   * @return Array of rows
   */
  function DBQueryToArray($query, $docasting = false)
  {
    $result = $this->connection->query($query);
    if (!$result) {
      die('Invalid query: ("' . $query . '")' . "<br/>\n" . $this->connection->error);
    }
    return $this->DBResourceToArray($result, $docasting);
  }

  /**
   * Converts a db resource to an array
   *
   * @param $result The database resource returned from mysql_query
   * @return array of rows
   */
  function DBResourceToArray($result, $docasting = false)
  {
    $retarray = array();
    while ($row = $result->fetch_assoc($result)) {
      if ($docasting) {
        $row = $this->DBCastArray($result, $row);
      }
      $retarray[] = $row;
    }
    return $retarray;
  }

  /**
   * Executes sql query and copy returns to php array of first row.
   *
   * @param string $query database query
   * @return first row in array
   */
  function DBQueryToRow($query, $docasting = false)
  {
    $result = $this->connection->query($query);
    if (!$result) {
      die('Invalid query: ("' . $query . '")' . "<br/>\n" . $this->connection->error);
    }
    $ret = $result->fetch_assoc();
    if ($docasting && $ret) {
      $ret = $this->DBCastArray($result, $ret);
    }
    return $ret;
  }

  /**
   * Set data into database by updating existing row.
   * @param string $name Name of the table to update
   * @param array $row Data to insert: key=>field, value=>data
   */
  function DBSetRow($name, $data, $cond)
  {

    $values = array_values($data);
    $fields = array_keys($data);

    $query = "UPDATE " . $this->connection->real_escape_string($name) . " SET ";

    for ($i = 0; $i < count($fields); $i++) {
      $query .= $this->connection->real_escape_string($fields[$i]) . "='" . $values[$i] . "', ";
    }
    $query = rtrim($query, ', ');
    $query .= " WHERE ";
    $query .= $cond;
    return $this->DBQuery($query);
  }

  /**
   * Copy mysql_associative array row to regular php array.
   *
   * @param $result return value of mysql_query
   * @param $row mysql_associative array row
   * @return php array of $row
   */
  function DBCastArray($result, $row)
  {
    $ret = array();
    $i = 0;
    foreach ($row as $key => $value) {
      if ($result->fetch_field_direct($result, $i)->type == "int") {
        $ret[$key] = (int)$value;
      } else {
        $ret[$key] = $value;
      }
      $i++;
    }
    return $ret;
  }

  /**
   * Checks if there is need to update database and execute upgrade functions.
   */
  function CheckDB()
  {
    $installedDb = $this->getDBVersion();
    for ($i = $installedDb; $i <= DB_VERSION; $i++) {
      $upgradeFunc = 'upgrade' . $i;
      LogDbUpgrade($this, $this, $i);
      $upgradeFunc($this);
      $query = sprintf("insert into uo_database (version, updated) values (%d, now())", $i + 1);
      runQuery($this, $query);
      LogDbUpgrade($this, $this, $i, true);
    }
  }

  /**
   * Returns ultiorganizer database internal version number.
   *
   * @return integer version number
   */
  function getDBVersion()
  {
    $query = "SELECT max(version) as version FROM uo_database";
    $result = $this->connection->query($query);
    if (!$result) {
      $query = "SELECT max(version) as version FROM pelik_database";
      $result = $this->connection->query($query);
    }
    if (!$result) return 0;
    if (!$row = $result->fetch_assoc()) {
      return 0;
    } else return $row['version'];
  }

  function RealEscapeString($string)
  {
    return $this->connection->real_escape_string($string);
  }

  public static function GetServerName()
  {
    if (isset($_SERVER['SERVER_NAME'])) {
      return $_SERVER['SERVER_NAME'];
    } elseif (isset($_SERVER['HTTP_HOST'])) {
      return $_SERVER['HTTP_HOST'];
    } else {
      die("Cannot find server address");
    }
  }
}
