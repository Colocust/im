<?php


namespace api;


class ReadMessageRequest extends Request {
  /**
   * @var string[]
   * @uses required
   */
  public $messageIds;
}