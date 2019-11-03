<?php

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);