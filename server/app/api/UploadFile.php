<?php

namespace api;


use service\Upload;

class UploadFile extends API {

  public function requestClass(): Request {
    return new UploadFileRequest();
  }

  public function doRun(): Response {
    $request = UploadFileRequest::fromAPI($this);
    $response = new UploadFileResponse();

    $response->url = Upload::uploadFile($request->file);

    return $response;
  }
}