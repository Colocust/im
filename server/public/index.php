<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 10:46
 */

namespace tiny;

require '../framework/Loader.php';

Loader::register();
Container::get("app")->run();
