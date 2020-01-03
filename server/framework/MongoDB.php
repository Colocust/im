<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 10:49
 */

namespace tiny;

use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Command;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Query;

class MongoDB {
  private $manager = null;
  private $dbName;
  private $address;
  private $user;
  private $password;

  protected $table;

  public function __construct() {
    $this->address = config('db.mongodb.address');
    $this->manager = null;
    $this->dbName = config('db.mongodb.db_name');
    $this->user = config('db.mongodb.user');
    $this->password = config('db.mongodb.password');
  }

  protected function getNs(): string {
    return $this->dbName . "." . $this->table;
  }

  protected function getDbName(): string {
    return $this->dbName;
  }

  //where条件
  private static $where = [];
  //查询条数
  private static $options = [];
  //更新操作
  private static $newObject = [];


  /**
   * 获取连接对象
   * @return \MongoDB\Driver\Manager|null
   */
  protected function getManager() {
    if ($this->manager === null) {
      $this->manager = new \MongoDB\Driver\Manager($this->address
        , ['password' => $this->password, 'username' => $this->user]);
    }
    return $this->manager;
  }

  //查询
  protected function find(): Cursor {
    $manager = $this->getManager();
    $res = $manager->executeQuery($this->getNs(), new Query(self::$where, self::$options));

    $this->init();

    return $res;
  }

  //新增
  protected function create(array $values): bool {
    $bulk = new BulkWrite();
    $bulk->insert($values);
    try {
      $this->getManager()->executeBulkWrite($this->getNs(), $bulk);
      return true;
    } catch (BulkWriteException $e) {
      Logger::getInstance()->warn("executeBulkWrite BulkWriteException");
    } catch (\Exception $e) {
      Logger::getInstance()->error("executeBulkWrite");
    }
    return false;
  }

  //更新
  protected function update(bool $upsert = false, bool $multi = false): bool {
    $bulk = new BulkWrite();
    $bulk->update(self::$where, self::$newObject, ['upsert' => $upsert, 'multi' => $multi]);
    try {
      $this->getManager()->executeBulkWrite($this->getNs(), $bulk);
      return true;
    } catch (BulkWriteException $e) {
      Logger::getInstance()->warn("executeBulkWrite BulkWriteException" . $e);
    } catch (\Exception $e) {
      Logger::getInstance()->error("executeBulkWrite" . $e);
    }

    $this->init();

    return false;
  }

  //删除数据
  protected function delete(): bool {
    try {
      $bulk = new BulkWrite();
      $bulk->delete(self::$where);
      $this->getManager()->executeBulkWrite($this->getNs(), $bulk);
      return true;
    } catch (\Exception $e) {
      Logger::getInstance()->error("error remove");
    }

    $this->init();

    return false;
  }

  protected function where(string $field, string $op, $value): self {
    switch ($op) {
      case '=':
        self::$where[$field] = $value;
        break;
      case '>':
        self::$where[$field] = ['$gt' => $value];
        break;
      case '>=':
        self::$where[$field] = ['$gte' => $value];
        break;
      case '<':
        self::$where[$field] = ['$lt' => $value];
        break;
      case '<=':
        self::$where[$field] = ['$lte' => $value];
        break;
      case '!=':
        self::$where[$field] = ['$ne' => $value];
        break;
      default:
        throw new \Exception('wrong op');
    }
    return $this;
  }

  protected function in(string $filed, array $value): self {
    self::$where[$filed] = ['$in' => $value];
    return $this;
  }

  protected function or(string $field, string $op, $value): self {
    switch ($op) {
      case '=':
        self::$where['$or'][] = [$field => $value];
        break;
      case '>':
        self::$where['$or'][] = [$field => ['$gt' => $value]];
        break;
      case '>=':
        self::$where['$or'][] = [$field => ['$gte' => $value]];
        break;
      case '<':
        self::$where['$or'][] = [$field => ['$lt' => $value]];
        break;
      case '<=':
        self::$where['$or'][] = [$field => ['$lte' => $value]];
        break;
      case '!=':
        self::$where['$or'][] = [$field => ['$ne' => $value]];
        break;
      default:
        throw new \Exception('wrong op');
    }
    return $this;
  }

  protected function limit(int $num): self {
    self::$options['limit'] = $num;
    return $this;
  }

  protected function sort(string $field, int $sort): self {
    switch ($sort) {
      case 1:
        self::$options['sort'] = [$field => 1];
        break;
      case -1:
        self::$options['sort'] = [$field => -1];
        break;
      default:
        throw new \Exception('wrong sort');
    }
    return $this;
  }

  protected function field(string $fields): self {
    $fields = explode(',', $fields);
    foreach ($fields as $field) {
      self::$options['projection'][$field] = 1;
    }
    return $this;
  }

  protected function set(string $field, $value): self {
    self::$newObject['$set'][$field] = $value;
    return $this;
  }

  protected function inc(string $field, int $value): self {
    self::$newObject['$inc'][$field] = $value;
    return $this;
  }

  protected function unset(string $field): self {
    self::$newObject['$unset'][$field] = 1;
    return $this;
  }

  protected function push(string $field, $value): self {
    self::$newObject['$push'][$field] = $value;
    return $this;
  }

  protected function addToSet(string $field, $value): self {
    self::$newObject['$addToSet'][$field] = $value;
    return $this;
  }

  protected function pop(string $field, $value): self {
    self::$newObject['$pop'][$field] = $value;
    return $this;
  }

  protected function pull(string $field, $value): self {
    self::$newObject['$pull'][$field] = $value;
    return $this;
  }

  protected function aggregate(array $pipeline): array {
    $cmd['aggregate'] = $this->table;
    $cmd['pipeline'] = $pipeline;
    $cmd['cursor'] = new \stdClass();
    try {
      return $this->getManager()->executeCommand($this->dbName, new Command($cmd))->toArray();
    } catch (\MongoDb\Driver\Exception\Exception $e) {
      Logger::getInstance()->error($e->getMessage());
    }
    return [];
  }

  //操作执行完毕后初始化where options
  private function init(): void {
    self::$where = [];
    self::$options = [];
    self::$newObject = [];
  }
}
