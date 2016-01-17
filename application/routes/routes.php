<?php
/**
 * Method Uri Action
 */
return [
  // backend
  [
    'GET',
    '/requests/{offset:\d+}/{limit:\d+}/{order:\w+}',//'/{order:\w+}',
    'Skansing\\XTrack\\RequestReader::get'],
  // log any other request with reasonable method
  ['GET', '/log/{path:.+}', 'Skansing\\XTrack\\LogController::log'],
  ['POST', '/log/{path:.+}', 'Skansing\\XTrack\\LogController::log'],
  ['PUT', '/log/{path:.+}', 'Skansing\\XTrack\\LogController::log'],
  ['DELETE', '/log/{path:.+}', 'Skansing\\XTrack\\LogController::log'],

];
