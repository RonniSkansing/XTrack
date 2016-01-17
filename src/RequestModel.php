<?php
namespace Skansing\XTrack;

use Skansing\XTrack\RequestEntity;
use SQLite3;

class RequestModel
{
  private $storage;
  private $requestEntity;

  public function __construct(
    SQLite3 $storage
  ) {
    $this->storage = $storage;
  }

  public function persist(RequestEntity $entity)
  {
    $statement = $this->storage->prepare('
      INSERT INTO requests (
        time, protocol, method, uri, port, agent, ip, headers, body
      ) VALUES (
        :time, :protocol, :method, :uri, :port, :agent, :ip, :headers, :body
      )
    ');
    $statement->bindValue(':time', $entity->time, SQLITE3_INTEGER);
    $statement->bindValue(':protocol', $entity->protocol, SQLITE3_TEXT);
    $statement->bindValue(':method', $entity->method, SQLITE3_TEXT);
    $statement->bindValue(':port', $entity->port, SQLITE3_INTEGER);
    $statement->bindValue(':uri', $entity->uri, SQLITE3_TEXT);
    $statement->bindValue(':agent', $entity->agent, SQLITE3_TEXT);
    $statement->bindValue(':ip', $entity->ip, SQLITE3_TEXT);
    $statement->bindValue(':headers', implode(':', $entity->headers), SQLITE3_TEXT);
    $statement->bindValue(':body', (string) $entity->body, SQLITE3_TEXT);
    $statement->execute();
  }

  public function getPaginated($offset = 0, $limit = 0, $order = 'ASC')
  {
    $order = strtoupper($order);
    if($order !== 'ASC' AND $order !== 'DESC')
    {
      throw new \InvalidArgumentException('Order is not whitelisted');
    }
    try {
      $result = $this->storage->query(
        'SELECT * FROM requests'
        . ' ORDER BY time ' . $order
        . ' LIMIT ' . (int) $limit
        . ' OFFSET ' . (int) $offset
      );
      if($result === false)
      {
        throw new \Exception('SQL execution failed');
      }
      $results = [];
      while($request = $result->fetchArray(SQLITE3_ASSOC))
      {
        $results[] = $request;
      }

      return $results;
    } catch(\Exception $e) {
      // @todo
      die(__FILE__.'::'.__LINE__);
    }
  }
}
