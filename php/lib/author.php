<?php
namespace Nwoodard\ObjectOriented;

require_once("../classes/autoload.php");
require_once(dirname(_DIR_, 2) . "/vendor/Author.php");

use Ramsey\Uuid\Uuid;

$pal = new Author("5671366c-5e84-48cf-90cc-f0daf1fb06bf",
	"www.whatever.com",
	"nananananananananananananananana",
	"whatever_whatever@gmail.com", "nananananananananananananananananananananananananananananananananananananananananananananananana", "whatever_whatever");


var_dump("$pal");
