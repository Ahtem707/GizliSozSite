<?php

SqlManager::$share = new SqlManager();

class SqlManager {

  public static $share;

  private $host;
  private $user;
  private $password;
  private $database;

  private $db;

  function __construct() {
    $this->firstConfigure();
  }

  # Первоначальная настройка
  private function firstConfigure() {
    // Подгрузка конфигурации базы данных
    try {
      $sql = _config["sql"] ?? new Exception("No sql section in config.ini");
      $this->host = $sql["host"] ?? new Exception("No sql/host in config.ini");
      $this->user = $sql["user"] ?? new Exception("No sql/user in config.ini");
      $this->password = $sql["password"] ?? new Exception("No sql/password in config.ini");
      $this->database = $sql["database"] ?? new Exception("No sql/database in config.ini");
    } catch(Exception $e) {
        Console::log("SqlManager: Error: ".$e->getMessage());
        return;
    }

    try {
      /* Вы должны включить отчёт об ошибках для mysqli, прежде чем пытаться установить соединение */
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

      $this->db = new mysqli($this->host, $this->user, $this->password, $this->database);

      /* Установите желаемую кодировку после установления соединения, есть поддержка русского языка */
      $this->db->set_charset('utf8mb4');
    } catch(Exception $e) {
      Console::logGroup("Error: ".$e->getMessage(), 'SqlManager');
      return;
    }
  }

  function tokenCheck(string $token) {
    $requestResult = $this->db->query($queryString);
  }

  function request(string $queryString) {
    try {
      $requestResult = $this->db->query($queryString);
    } catch(Exception $e) {
      Console::logGroup("Error: ".$e->getMessage(), 'SqlManager');
      return new Result(null, $e);
    }
    $type = gettype($requestResult);
    if($type == "boolean") {
      return new Result([], null);
    }
    if($type == "object") {
      $result = [];
      
      if ($requestResult->num_rows > 0) {
        while($row = $requestResult->fetch_assoc()) {
          array_push($result, $row);
        }
      }
      return new Result($result, null);
    }
  }
}

function toValue($value) {
  if($value == null) {
      return "NULL";
  } else {
      $v = intval($value);
      return $v ? "$v" : "'$value'";
  }
}