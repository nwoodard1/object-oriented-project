<?php
namespace Nwoodard\ObjectOriented;

require_once("autoload.php");
require_once(dirname(_DIR_, 2) . "/vendor/autoload.php");

use http\Exception\BadQueryStringException;
use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;

/**
 * Author profile
 *
 *This profile is for learning purposes.
 *
 * @Author Natalie Woodard <nwoodard1@cnm.edu>
 * @version 3.0.0
 **/
class Author implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for Author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;
	/**
	 * id of the Author; this is a foreign key
	 * @var Uuid $authorId ;
	 **/
	private $authorAvatarUrl;
	/**
	 * avatar image of this author
	 * @var string $authorAvatarUrl
	 **/
	private $authorActivationToken;
	/**
	 * date and time this Author signed in, in a PHP DateTime object
	 * @var \DateTime $authorActivationToken
	 **/
	private $authorEmail;
	/**
	 * e-mail address of Author
	 * @var
	 */

	private $authorHash;
	/**
	 * encrypted password assigned to author
	 */
	private $authorUsername;

	/**
	 * constructor for this Author
	 *
	 * @param string|Uuid $newAuthorId id of this Author or null if a new Author
	 * @param string|Uuid $newAuthor
	 * @param string $newAuthorActivationToken string containing actual author data
	 * @param \DateTime|string|null $newAuthorDate date and time author was activated or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not InvalidArgumentException
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/languages.oop5.decon.php
	 **/
	public function _construct($newAuthorId, $newAuthorAvatarURL, $newAuthorActivationToken, $newAuthorEmail, string $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorAvatarUrl($newAuthorAvatarURL);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		}
			 }

	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id
	 **/
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid|string $newAuthorId is not positive
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
		$this->authorAvatarUrl = $uuid;
	}

	/**
	 * accessor method for author avatar url
	 *
	 * @return string value of author avatar url
	 **/
	public function getAuthorActivationToken(): string {
		return ($this->authorActivationToken);
	}

	/**
	 * mutator method for author activation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException if $newAuthorActivationToken is not a string or insecure
	 * @throws \RangeExeption if $newAuthorActivationToken is > 140 characters
	 * @throws \TypeError if $newAuthorActivationToken is not a string
	 **/
	public function setAuthorActivationToken(string $newAuthorActivationToken): void {
		//verify the author activation token is secure
		// 	$newAuthorActivationToken = trim ($newAuthorActivationToken};
		$newAuthorActivationToken = filter_var($newAuthorActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorActivationToken) === true) {
			throw(new\InvalidArgumentException("author activation token is empty or insecure"));
		}

		// verify the author activation token will fit in the database
		if(strlen($newAuthorActivationToken) > 140) {
			throw(new \RangeException("author activation token is too large"));

		}
		//store the author activation token
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 * accessor method for AuthorEmail
	 *
	 * @return \DateTime value of author email
	 **/
	public function getAuthorEmail(): \DateTime {
		return ($this->authorEmail);
	}

	/**
	 * mutator method for author email
	 *
	 * @param \DateTime|string|null $newAuthorEmail author email as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newAuthorEmail is not a valid object or string
	 * @throws \RangeException if $newAuthorEmail is an email that does not exist
	 **/
	public function setAuthorEmail($newAuthorEmail = null): void {
		//base case: if the email is null, use the previous email
		if($newAuthorEmail === null) {
			$this->authorEmail = new \DateTime();
		}
//store the like date using the ValidateDate trait
		try {
			$newAuthorEmail = self::validateDateTime($newAuthorEmail);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->authorEmail = $newAuthorEmail;
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
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash) VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, authorHash)";
		$statement = $pdo->prepare($query);

//bind the member variables to the place holders in the template
		$formattedDate = $this->authorEmail->format("Y-m-d H:i:s.u");
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl->getBytes(), "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["tweetId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the author by authorId
	 *
	 * @param \PDO $pdo connection object
	 * @param Uuuid|string $authorId author id to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId): ?Author {
		// sanitize the authorId before searching
			try {
						$authorId = self::validateUUid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				throw(new \PDOException($exception->getmessage(), 0, $exception));
			}
			// create query template
			$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash FROM author WHERE authorId = :authorId";
			$statement = $pdo->prepare($query);

			// bind the author id to the place holder in the template
			$parameters = ["authorId" => $authorId->getBytes()];
			$statement->execute($parameters);

			//grab the author from mySQL
			try {
						$author = null;
						$statement->setFetchMode(\PDO::FETCH_ASSOC);
						$row = $statement->fetch();
						if($row !== false) {
									$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
						}
			} catch(\Exception $exception){
						//if the row couldn't be converted, rethrow it
						throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($author);
}
/**
 * gets the Author by author id
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $authorAvatarUrl author id to search by
 * @return \SplFixedArray SplFixedArray of Author found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getAuthorByAuthorAvatarUrl(\PDO $pso, $authorAvatarUrl) : \SplFixedArray {
			try {
						$authorAvatarUrl = self::validateUuid($authorAvatarUrl);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
						throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			//create query template
			$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author WHERE authorAvatarUrl = :authorAvatarUrl";
			$statement = $pdo->prepare($query);
			// bind the authorAvatarUrl id to the place holder in the template
	/		$parameters = ["authorAvatarUrl" => $authorAvatarUrl->getBytes()];
			$statement->execute($parameters);
			//build an array of authors
}
}