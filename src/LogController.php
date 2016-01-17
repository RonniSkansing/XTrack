<?php
namespace Skansing\XTrack;

// @todo half of this should be in a service layer

use Arya\Request,
    Arya\Response,
    Skansing\XTrack\RequestModel,
    Skansing\XTrack\RequestEntity;

class LogController {

  private $request;
  private $response;

  public function __construct(
    Request $request,
    Response $response,
    RequestModel $requestModel
  ){
    $this->request = $request;
    $this->response = $response;
    $this->requestModel = $requestModel;
  }

  public function log()
  {
    $this->requestModel->persist(
      new RequestEntity( // @todo factory
        $this->request->get('SERVER_PROTOCOL'),
        $this->request->get('REQUEST_METHOD'),
        $this->request->get('SERVER_PORT'),
        $this->request->get('REQUEST_URI'),
        $this->request->get('REQUEST_TIME'),
        $this->request->get('HTTP_USER_AGENT'),
        $this->request->get('REMOTE_ADDR'),
        $this->request->getAllHeaders(),
        $this->request->getBody()
      )
    );

    if($this->request->has('HTTP_REFERER')) {
      $this->response->setStatus(302);
      // @todo this might need some response splitting protection
      $this->setHeader('Location', $this->request->get('HTTP_REFERER'));
    } else {
      $this->response->setStatus(201);
    }
  }
}
