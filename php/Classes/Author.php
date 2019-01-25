<?php
namespace Nwoodard\ObjectOriented;

require_once("autoload.php");
require_once(dirname(_DIR_, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Author profile
 *
 *This profile is for learning purposes.
 *
 * @author Natalie Woodard <nwoodard1@cnm.edu>
 * @version 3.0.0
 **/
class Author implements \JsonSerializable {
			use ValidateDate;
			use ValidateUuid;
			/**
			 *
			 */
}