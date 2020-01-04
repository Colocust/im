<?php

namespace api;


class UploadFileRequest extends Request {
  /**
   * @var file
   * @uses required
   */
  public $file;
}