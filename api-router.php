<?php
require_once './libs/Router.php';
require_once './app/controllers/song-api.controller.php';
require_once './app/controllers/singer-api.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('songs', 'GET', 'SongApiController', 'getSongs');
$router->addRoute('songs/:ID', 'GET', 'SongApiController', 'getSong');
$router->addRoute('songs/:ID', 'DELETE', 'SongApiController', 'deleteSong');
$router->addRoute('songs', 'POST', 'SongApiController', 'insertSong'); 
$router->addRoute('songs/:ID', 'PUT', 'SongApiController', 'editSong');
$router->addRoute('singers', 'GET', 'SingerApiController', 'getSingers');
$router->addRoute('singers/:ID', 'GET', 'SingerApiController', 'getSinger');
$router->addRoute('singers/:ID', 'DELETE', 'SingerApiController', 'deleteSinger');
$router->addRoute('singers', 'POST', 'SingerApiController', 'insertSinger'); 
$router->addRoute('singers/:ID', 'PUT', 'SingerApiController', 'editSinger');

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);