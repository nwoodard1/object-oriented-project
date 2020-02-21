<?php
namespace Nwoodard\ObjectOriented;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once ("ValidateUuid.php");

use Ramsey\Uuid\Uuid;

/**
 * Author profile
 *
 *This profile is for learning purposes.
 *
 * @Author Natalie Woodard <nwoodard1@cnm.edu>
 * @version 3.0.0
 **/
class Author {
	use ValidateUuid;

	/**
	 * id for Author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;

	/**
	 * avatar of the Author; this is a foreign key
	 * @var Uuid $authorAvatarUrl ;
	 **/
	private $authorAvatarUrl;

	/**
	 * activation token for Author
	 * @var string $authorActivationToken
	 **/
	private $authorActivationToken;

	/**
	 * email for Author
	 * @var string $authorEmail
	 **/
	private $authorEmail;

	/**
	 * encrypted password of Author
	 * @var string $authorHash
	 */
	private $authorHash;

	/**
	 * username of Author
	 * @var string $authorUsername
	 */
	private $authorUsername;


    /**
     * constructor for this Author
     *
     * @param string|Uuid $newAuthorId id of this Author or null if a new Author
     * @param $newAuthorAvatarURL
     * @param string $newAuthorActivationToken string containing activation token
     * @param string|null $newAuthorEmail string author was activated or null
     * @param string $newAuthorHash string containing encrypted password for author
     * @param string $newAuthorUsername string containing the username of the author
     * @Documentation https://php.net/manual/en/languages.oop5.decon.php
     */

	public function __construct($newAuthorId, $newAuthorAvatarURL, $newAuthorActivationToken, $newAuthorEmail, string $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorAvatarUrl($newAuthorAvatarURL);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
			//determine what exception type was thrown
		} catch(\InvalidArgumentException | \RangeException | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType ($exception->getMessage(),0, $exception));
			}
	}

	/**
	 * accessor method for author id
	 *
	 * @return string value of author id (null if it is a new Author)
	 **/
	public function getAuthorId(): string {
		return ($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid|string $newAuthorId is not positive
	 * @throws \InvalidArgumentException if the id is not a string or is insecure
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if $newAuthorId is not a uuid or string
	 **/
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(InvalidArguementException | \RangeException |Exception |\TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType ($exception->getMessage(), 0, $exception));
		}

		//convert and store author id
		$this->authorId = $uuid;
	}

	/**
	 * accessor method for author avatar url
	 *
	 * @return string value of author avatar url
	 **/

	public function getAuthorAvatarUrl(): string {
		return ($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author avatar url
	 *
	 * @param string $newAuthorAvatarUrl new value author avatar url
	 * @throws \InvalidArgumentException if the author url is empty
	 * @throws \RangeException if the url is longer than 255 characters
	 **/

	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl) {
		if(empty($newAuthorAvatarUrl) == true){
			throw(new \InvalidArgumentException("This URL is empty."));
		}
		//verify the URL is no longer than 255 characters
		if(strlen($newAuthorAvatarUrl)>255) {
			throw(new \RangeException("This URL is too long. It must be no longer than 255 characters."));
		}
		//Store the author avatar URL
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * accessor method for author activation token
	 *
	 * @return string value of author activation token
	 **/

	public function getAuthorActivationToken(): string {
		return ($this->authorActivationToken);
	}

	/**
	 * mutator method for author activation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException if $newAuthorActivationToken is not a string or insecure
	 * @throws \RangeException if $newAuthorActivationToken is > 140 characters
	 * @throws \TypeError if $newAuthorActivationToken is not a string
	 **/
	public function setAuthorActivationToken(string $newAuthorActivationToken): void {
		//verify the author activation token is secure
		// 	$newAuthorActivationToken = trim ($newAuthorActivationToken};
		//$newAuthorActivationToken = filter_var($newAuthorActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new \RangeException("author activation token must be 32 characters long"));
		}
		//Store the author activation token
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 * accessor method for author email
	 *
	 * @param string $newAuthorEmail new value author email
	 * @throws \InvalidArgumentException if the author activation token isn't a string or is insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 **/

	public function getAuthorEmail(): string {
		return ($this->authorEmail);
	}

	/**
	 * mutator method for author email
	 *
	 * @param string|null $newAuthorEmail author email
	 * @throws \InvalidArgumentException if $newAuthorEmail is not a valid object or string
	 * @throws \RangeException if $newAuthorEmail is an email that does not exist
	 *
	 **/
	public function setAuthorEmail($newAuthorEmail): void {
	$newAuthorEmail = trim($newAuthorEmail);
	$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorEmail) === true) {
		throw(new \InvalidArgumentException("The author email address is not valid or is insecure."));
		}
		//Verufy that the email address is no longer than 128 characters
		if(strlen($newAuthorEmail) >128){
			throw (new \RangeException("The email address must be no longer than 128 characters."));
		}
		//Store the author email
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * accessor method for the authorHash
	 *
	 * @return string value of the author hash
	 **/
	public function getAuthorHash(): string {
		return $this->authorHash;
	}
	/**
	 * mutator method for the author hash
	 *
	 * @param string $newAuthorHash new value for the author hash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is linger than 97 character
	 **/

	public function setAuthorHash(string $newAuthorHash): void {
		//Ensure that the hash is formatted correctly
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw (new \InvalidArgumentException("The hash is empty or insecure."));
		}
		//Ensure the hash is an Argon hash
		if(strlen($newAuthorHash) >97) {
			throw (new \RangeException("The hash must be no longer than 97 characters."));
		}
		//Store the hash
		$this->authorHash = $newAuthorHash;
	}

	/**
	 * Accessor method for the authorUsername
	 *
	 * @return string value or the author username
	 **/

	public function getAuthorUsername(): string {
		return $this->authorUsername;
	}
		/**
		 * mutator method for the author username
		 *
		 * @param string $newAuthorUsername new value for the author username
		 * @throws \InvalidArgumentException if $newAuthorUsername is not a string or is insecure
		 * @throws \RangeException if $newAuthorUsername is longer than 32 characters
		 **/

	public function setAuthorUsername(string $newAuthorUsername) : void {
			//Ensure the username is formatted correctly
			$newAuthorUsername = trim($newAuthorUsername);
			$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newAuthorUsername) === true) {
				throw (new \InvalidArgumentException("The user name is invalid or insecure."));
			}
			//Verify the username is no longer than 32 characters
			if(strlen($newAuthorUsername) > 32) {
				throw (new \RangeException("The username cannot be longer."));
			}
		//Store the username
		$this->authorUsername = $newAuthorUsername;
		}



	/**
	 * insert this author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl->getBytes(), "authorActivationToken" => $this->authorActivationToken, "authorEmail"=> $this->authorEmail->getBytes(), "authorUsername"=> $this->authorUsername->getBytes()];
		$statement->execute($parameters);
	}
/**
 * deletes this author from mySQL
*
* @param \PDO $pdo PDO connection object
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError if $pdo is not a PDO connection object
**/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 /**
	 * updates this author in MySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update (\PDO $pdo) : void {

	//create query template
	$query = "UPDATE author SET authorId = :authorId, authorAvatarUrl = :authorAvatarUrl, authorActivationToken = :authorActivationToken, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername";
	$statement = $pdo->prepare($query);

	$parameters = ["authorId"=> $this->authorId->getBytes(), "authorAvatarUrl"=> $this->authorAvatarUrl->getBytes(), "authorActivationToken"=> $this->authorActivationToken->getBytes, "authorEmail"=> $this->authorEmail, "authorHash"=> $this->authorHash, "authorUsername"=> $this->authorUsername];
	$statement->execute($parameters);
	}
	/**
	 * gets the Author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
		// sanitize the authorId before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT authorId, authorAvatarURL, authorActivationToken, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the tweet id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		// grab the author from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row[authorUsername]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($author);
	}
			/**
			 *
	 * gets all Authors
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Authors found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAuthors(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of authors
		$author = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				$author[$author->key()] = $author;
				$author->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($author);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
		$fields["authorAvatarUrl"] = $this->authorAvatarUrl->toString();

		//format the date so that the front end can consume it
		$fields["authorEmail"] = round(floatval($this->authorEmail->format("U.u")) * 1000);
		return($fields);
	}
}