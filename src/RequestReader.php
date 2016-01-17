<?php
namespace Skansing\XTrack;

// @todo add service layer

use Arya\Response,
    Skansing\XTrack\RequestModel;

class RequestReader {

  private $requestModel;
  private $response;

  public function __construct(
    RequestModel $requestModel,
    Response $response
  ){
    $this->response = $response;
    $this->requestModel = $requestModel;
  }

  public function get($offset, $limit, $order)
  {
    // @todo auth via. middleware
    return json_encode(
      $this->requestModel->getPaginated($offset, $limit, $order)
    );
  }
}
