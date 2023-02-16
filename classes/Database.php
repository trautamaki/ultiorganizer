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

  function GetConnection()
  {
    return $this->connection;
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

    if ($this->NumRows($result)) {
      $row = $result->fetch_row();
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

    return $this->NumRows($result);
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
   * @param $result The database resource returned from $database->DBQuery
   * @return array of rows
   */
  function DBResourceToArray($result, $docasting = false)
  {
    $retarray = array();
    while ($row = $this->FetchAssoc($result)) {
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
    $ret = $this->FetchAssoc($result);
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

    $query = "UPDATE " . $this->RealEscapeString($name) . " SET ";

    for ($i = 0; $i < count($fields); $i++) {
      $query .= $this->RealEscapeString($fields[$i]) . "='" . $values[$i] . "', ";
    }
    $query = rtrim($query, ', ');
    $query .= " WHERE ";
    $query .= $cond;
    return $this->DBQuery($query);
  }

  /**
   * Copy mysql_associative array row to regular php array.
   *
   * @param $result return value of $database->DBQuery
   * @param $row mysql_associative array row
   * @return php array of $row
   */
  function DBCastArray($result, $row)
  {
    $ret = array();
    $i = 0;
    foreach ($row as $key => $value) {
      if ($result->fetch_field_direct($i)->type == "int") {
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
      LogDbUpgrade($this, $i);
      $upgradeFunc($this);
      $query = sprintf("insert into uo_database (version, updated) values (%d, now())", $i + 1);
      runQuery($this, $query);
      LogDbUpgrade($this, $i, true);
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
    if (!$row = $this->FetchAssoc($result)) {
      return 0;
    } else return $row['version'];
  }

  function RealEscapeString($string)
  {
    return $this->connection->real_escape_string($string);
  }

  function FetchAssoc($data)
  {
    return $data->fetch_assoc();
  }

  function NumRows($data)
  {
    return $data->num_rows;
  }

  function DataSeek($data, $row)
  {
    return $data->data_seek($row);
  }

  function FetchRow($data)
  {
    return $data->fetch_row();
  }

  function FieldType($data, $i)
  {
    return $data->fetch_field_direct($i)->type;
  }

  function FetchField($data)
  {
    return $data->fetch_field();
  }

  function FetchArray($data)
  {
    return $data->fetch_array();
  }

  function FieldName($data, $field_offset)
  {
      $properties = mysqli_fetch_field_direct($data, $field_offset);
      return is_object($properties) ? $properties->name : null;
  }

  function AffectedRows()
  {
    return $this->connection->affected_rows;
  }

  function FreeResult($data) {
    $data->free_result();
  }

  function GetServerInfo()
  {
    return $this->connection->server_info;
  }

  function GetClientInfo()
  {
    return $this->connection->client_info;
  }

  function GetHostInfo()
  {
    return $this->connection->host_info;
  }

  function Stat()
  {
    return $this->connection->stat;
  }

  function GetProtocolVersion() {
    return $this->connection->protocol_version;
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
