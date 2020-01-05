<?

namespace api;

use db\AccountUser;
use service\Sms;

class GetCaptcha extends API {

  public function requestClass(): Request {
    return new GetCaptchaRequest();
  }

  public function doRun(): Response {
    $request = GetCaptchaRequest::fromAPI($this);
    $response = new GetCaptchaResponse();

    $sms = new Sms();

    if ($sms->send($request->telephone)) {
      $response->result = 2;
    }

    return $response;
  }

  protected function needToken(): bool {
    return false;
  }
}