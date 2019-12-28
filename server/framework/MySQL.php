<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/10/8
 * Time: 14:09
 */

namespace tiny;

class MySQL {

  private $host;
  private $port;
  private $database;
  private $username;
  private $password;
  //连接对象
  private $manager;

  protected $connection = 'mysql';

  public function __construct() {
    $connection = $this->connection;
    $this->host = config("db.$connection.host");
    $this->port = config("db.$connection.port");
    $this->database = config("db.$connection.database");
    $this->username = config("db.$connection.username");
    $this->password = config("db.$connection.password");
  }

  private function getManager(): \mysqli {
    $this->manager = new \mysqli(
      $this->host,
      $this->username,
      $this->password,
      $this->database,
      $this->port);
    if ($this->manager->connect_errno)
      throw new \Exception('mysql连接失败');
    return $this->manager;
  }

  //执行sql语句
  protected function execute(string $sql) {
    $rows = $this->getManager()->query($sql);
    if (!$rows)
      throw new \Exception('请检查sql语句' . $sql);
    mysqli_close($this->manager);
    return $rows;
  }

  protected function select(string $sql): array {
    $rows = $this->execute($sql);
    $res = [];
    while ($row = $rows->fetch_assoc()) {
      array_push($res, $row);
    }
    return $res;
  }

  protected function create(string $sql): bool {
    return $this->execute($sql);
  }

  protected function delete(string $sql): bool {
    return $this->execute($sql);
  }

  protected function update(string $sql): bool {
    return $this->execute($sql);
  }
}