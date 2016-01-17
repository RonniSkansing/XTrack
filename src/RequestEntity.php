<?php
namespace Skansing\XTrack;

class RequestEntity
{
  public $id;
  public $agent;
  public $ip;
  public $protocol;
  public $method;
  public $uri;
  public $port;
  public $time;
  public $headers;
  public $body;

  public function __construct(
    $protocol,
    $method,
    $port,
    $uri,
    $requestTime,
    $userAgent,
    $ip,
    $headers,
    $body,
    $id = null
  ) {
    $this->protocol = $protocol;
    $this->method = $method;
    $this->port = $port;
    $this->uri = $uri;
    $this->time = $requestTime;
    $this->agent = $userAgent;
    $this->ip = $ip;
    $this->body = $body;
    $this->headers = $headers;
    $this->body = $body;
    $this->id = $id;
  }
}
