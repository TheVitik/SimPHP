<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("config.php");
require_once(ROOT."/core/Router.php");
require_once(ROOT."/core/Process.php");
require_once(ROOT."/core/Database.php");
require_once(ROOT."/core/default/Controller.php");
require_once(ROOT."/core/default/Model.php");
require_once(ROOT."/core/default/Access.php");
use Core\Router;
use Core\Database;
Database::init();
$router = new Router(include(ROOT."/data/routes.php"));
$process = $router->run();
$router->execute($process);