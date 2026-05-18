<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';

use Framework\Router;

$router = new Router();

$routes = require basePath('routes.php');

$router->route(normalizeUri());