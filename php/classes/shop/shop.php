<?php
namespace Edu\Cnm\DataDesign;
require_once("autoload.php");
/**
 * small cross section of an etsy like shop
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>, deepdivebootcampserver,
 * @version 3.0.0
 **/
class shop implements \JsonSerializable {
	use ValidateDate;

	/** shop; this is the primary key
	 * @var int $shopId
	 **/
	private $shopId;
	/**
	 * id of the the name of this shop; this is a foreign key
	 * @var int $shopName
	 **/
	private $shopName;
	/**
	 * actual textual content of this shop
	 * @var string $shopContent
	 **/
	private $shopContent;

	/**
	 * constructor for this shop
	 *
	 * @param int|null $newshopId id of this shop or null if a new shop
	 * @param int $newshopNameProfileId id of the Profile that created this shop
	 * @param string $newshopContent string containing actual shop data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newshopId, ?int $newshopName, string $newshopContent = null) {
		try {
			$this->setshopId($newshopId);
			$this->setTweetProfileId($newshopName);
			$this->setTweetContent($newshopContent);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for shop id
	 *
	 * @return int|null value of tweet id
	 **/
	public function getshopId() : int {
		return($this->shopId);
	}
	/**
	 * mutator method for shop id
	 *
	 * @param int|null $newshopId new value of tweet id
	 * @throws \RangeException if $newTweetId is not positive
	 * @throws \TypeError if $newTweetId is not an integer
	 **/
	public function setshopId(?int $newshopId) : void {
		//if shop id is null immediately return it
		if($newshopId === null) {
			$this->shopId = null;
			return;
		}
		// verify the shop id is positive
		if($newshopId <= 0) {
			throw(new \RangeException("shop id is not positive"));
		}
		// convert and store the shop id
		$this->shopId = $newshopId;
	}
	/**
	 * accessor method for shop Name
	 *
	 * @return int value of shop Name
	 **/
	public function getshopName() : int{
		return($this->shopName);
	}
	/**
	 * mutator method for shop Name
	 *
	 * @param int $new shop name new value of shop Name
	 * @throws \RangeException if $shop name is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setshopName(int $newshopName) : void {
		// verify the profile id is positive
		if($newshopName <= 0) {
			throw(new \RangeException("shop name is not positive"));
		}
		// convert and store the profile id
		$this->shopName = $newshopName;
	}
	/**accessor method for shop content
	 *
	 * @return string value of shop content
	 **/
	public function getshopContent() :string {
		return($this->shopContent);
	}
	/**
	 * mutator method for shop content
	 *
	 * @param string $newshopContent new value of tweet content
	 * @throws \InvalidArgumentException if $newshopContent is not a string or insecure
	 * @throws \RangeException if $newshopContent is > 140 characters
	 * @throws \TypeError if $newshopContent is not a string
	 **/
	public function setshopContent(string $newshopContent) : void {
		// verify the shop content is secure
		$newshopContent = trim($newshopContent);
		$newshopContent = filter_var($newshopContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newshopContent) === true) {
			throw(new \InvalidArgumentException("shop content is empty or insecure"));
		}
		// verify the shop content will fit in the database
		if(strlen($newshopContent) > 140) {
			throw(new \RangeException("shop content too large"));
		}
		// store the tweet content
		$this->shopContent = $newshopContent;
	}

	/**
	 * inserts this shop into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// enforce the shopId is null (i.e., don't insert a shop that already exists)
		if($this->shopId !== null) {
			throw(new \PDOException("not a new shop"));
		}
		// create query template
		$query = "INSERT INTO shop(shopName, shopContent) VALUES(:shopName, :shopContent)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["shopName" => $this->shopName, "shopContent" => $this->shopContent];
		$statement->execute($parameters);
		// update the null shopId with what mySQL just gave us
		$this->shopId = intval($pdo->lastInsertId());
	}
	/**
	 * deletes this shop from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the shopId is not null (i.e., don't delete a shop that hasn't been inserted)
		if($this->shopId === null) {
			throw(new \PDOException("unable to delete a shop that does not exist"));
		}
		// create query template
		$query = "DELETE FROM shop WHERE shopId = :shopId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["shopId" => $this->shopId];
		$statement->execute($parameters);
	}
	/**
	 * updates this shop in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// enforce the shopId is not null (i.e., don't update a shop that hasn't been inserted)
		if($this->shopId === null) {
			throw(new \PDOException("unable to update a shop that does not exist"));
		}
		// create query template
		$query = "UPDATE shop SET shopName = :shopName, tweetContent = :shopContent = :tweetDate WHERE shopId = :shopId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["shopName" => $this->shopName, "shopContent" => $this->shopContent, "shopId" => $this->shopId];
		$statement->execute($parameters);
	}
	/**
	 * gets the shop by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string  content to search for
	 * @return \SplFixedArray SplFixedArray of shops found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getshopByshopContent(\PDO $pdo, string $shopContent) : \SPLFixedArray {
		// sanitize the description before searching
		$shopContent = trim($shopContent);
		$shopContent = filter_var($shopContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($shopContent) === true) {
			throw(new \PDOException("shop content is invalid"));
		}
		// create query template
		$query = "SELECT shopId, shopName, shopContent FROM shop WHERE shopContent LIKE :shopContent";
		$statement = $pdo->prepare($query);
		// bind the tweet content to the place holder in the template
		$tweetContent = "%$shopContent%";
		$parameters = ["shopContent" => $tweetContent];
		$statement->execute($parameters);
		// build an array of shops
		$shops = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$shop = new shop($row["shopId"], $row["shopName"], $row["shopContent"];
				$shops[$shops->key()] = $shop;
				$shops->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($shops);
	}
	/**
	 * gets the shop by shopName
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $shopId shop id to search for
	 * @return Tweet|null shop found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getsshopByshopId(\PDO $pdo, int $shopId) : ?shop {
		// sanitize the shopId before searching
		if($shopId <= 0) {
			throw(new \PDOException("shop id is not positive"));
		}
		// create query template
		$query = "SELECT shopId, shopName, shopContent FROM shop WHERE shopId = :shopId";
		$statement = $pdo->prepare($query);
		// bind the shop id to the place holder in the template
		$parameters = ["shopId" => $shopId];
		$statement->execute($parameters);
		// grab the shop from mySQL
		try {
			$shop = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$shop = new shop($row["shopId"], $row["shopName"], $row["shopContent"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($shop);
	}
	/**
	 * gets the shop by shop Name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $shop name profile id to search by
	 * @return \SplFixedArray SplFixedArray of Tweets found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getshopByshopName(\PDO $pdo, int $shopName) : \SPLFixedArray {
		// sanitize the name/ id before searching
		if($shopName <= 0) {
			throw(new \RangeException("shop name id must be positive"));
		}
		// create query template
		$query = "SELECT shopId, shopName, shopContent FROM shop WHERE shopName = :shopName";
		$statement = $pdo->prepare($query);
		// bind the shop name/ id to the place holder in the template
		$parameters = ["shopName" => $shopName];
		$statement->execute($parameters);
		// build an array of shops
		$shops = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$shop = new shop($row["shopId"], $row["shopName"], $row["shopContent"]);
				$shops[$shops->key()] = $shop;
				$shops->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($shops);
	}
	/**
	 * gets all shops
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of shops found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllshops(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT shopId, shopName, shopContent FROM shop";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of shops
		$shops = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$shop = new shop($row["shopId"], $row["shopName"], $row["shopContent"]);
				$shops[$shops->key()] = $shop;
				$shops->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($shops);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	/**functionfor dates will insert when have date
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		//format the date so that the front end can consume it
		$fields["tweetDate"] = round(floatval($this->tweetDate->format("U.u")) * 1000);
		return($fields)
*/
}