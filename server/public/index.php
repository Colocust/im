<?php

namespace tiny;

require '../framework/Loader.php';

Loader::register();
Container::get("app")->run();
