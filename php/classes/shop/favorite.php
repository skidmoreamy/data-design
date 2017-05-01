<?php
namespace Edu\Cnm\DataDesign;
require_once("autoload.php");
/**
 * Cross Section of a etsy shop favorite
 *
 * This is a cross section of what probably occurs when a user likes an etsy shop. It is an intersection table (weak
 * entity) from an m-to-n relationship between profile and shop.
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 4.0.0
 **/
class favorite implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id of the shop being favorite; this is a component of a composite primary key (and a foreign key)
	 * @var int $favoriteShopId.
	 **/
	private $favoriteShopId;
	/**
	 * id of the Profile who favorited; this is a component of a composite primary key (and a foreign key)
	 * @var int $favoriteProfileId
	 **/
	private $favoriteProfileId;
	/**
	 * date and time the shop was favorite
	 * @var \DateTime $favoriteDate
	 **/
	private $favoriteDate;
	/**
	 * constructor for this favorite
	 *
	 * @param int $newfavoriteProfileId id of the parent Profile
	 * @param int $newfavoriteShopId id of the parent shop
	 * @param \DateTime|null $newfavoriteDate date the shop was favorite (or null for current time)
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct(int $newfavoriteProfileId, int $newfavoriteShopId, $newfavoriteDate = null) {
		// use the mutator methods to do the work for us!
		try {
			$this->setfavoriteProfileId($newfavoriteProfileId);
			$this->setfavoriteShopId($newfavoriteShopId);
			$this->setLikeDate($newfavoriteDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			// determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for profile id
	 *
	 * @return int value of profile id
	 **/
	public function getfavoriteProfileId() : int {
		return ($this->favoriteProfileId);
	}
	/**
	 * mutator method for favorite profile id
	 *
	 * @param int $newProfileId new value of favorite profile id
	 * @throws \RangeException if $newfavoriteProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setfavoriteProfileId(int $newfavoriteProfileId) : void {
		// verify the profile id is positive
		if($newfavoriteProfileId <= 0) {
			throw(new \RangeException("favorite profile id is not positive"));
		}
		// convert and store the profile id
		$this->favoriteProfileId = $newfavoriteProfileId;
	}
	/**
	 * accessor method for shop id
	 *
	 * @return int value of shop id
	 **/
	public function getfavoriteShopId() : int {
		return ($this->favoriteShopId);
	}
	/**
	 * mutator method for favorite id
	 *
	 * @param int $newfavoriteShopId new value of shop id
	 * @throws \RangeException if $newshopId is not positive
	 * @throws \TypeError if $newshopId is not an integer
	 **/
	public function setfavoriteShopId(int $newfavoriteShopId) : void {
		// verify the shop id is positive
		if($newfavoriteShopId <= 0) {
			throw(new \RangeException("shop id is not positive"));
		}
		// convert and store the profile id
		$this->favoriteShopId = $newfavoriteShopId;
	}
	/**
	 * accessor method for favorite date
	 *
	 * @return \DateTime value of favorite date
	 **/
	public function getfavoriteDate() : \DateTime {
		return ($this->favoriteDate);
	}
	/**
	 * mutator method for favorite date
	 *
	 * @param \DateTime|string|null $newfavoriteDate favorite date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newfavoriteDate is not a valid object or string
	 * @throws \RangeException if $newfavoriteDate is a date that does not exist
	 **/
	public function setLikeDate($newfavoriteDate): void {
		// base case: if the date is null, use the current date and time
		if($newfavoriteDate === null) {
			$this->favoriteDate = new \DateTime();
			return;
		}
		// store the favorite date using the ValidateDate trait
		try {
			$newfavoriteDate = self::validateDateTime($newfavoriteDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->likeDate = $newfavoriteDate;
	}
	/**
	 * inserts this favorite into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// ensure the object exists before inserting
		if($this->favoriteProfileId === null || $this->favoriteShopId === null) {
			throw(new \PDOException("not a valid favorite"));
		}
		// create query template
		$query = "INSERT INTO `favorite`(favoriteProfileId, favoriteShopId, favoriteDate) VALUES(:favoriteProfileId, :favoriteShopId, :favoriteDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteDate->format("Y-m-d H:i:s");
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteShopId" => $this->favoriteShopId, "favoriteDate" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * deletes favorite from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// ensure the object exists before deleting
		if($this->favoriteProfileId === null || $this->favoriteShopId === null) {
			throw(new \PDOException("not a valid favorite"));
		}
		// create query template
		$query = "DELETE FROM `favorite` WHERE favoriteProfileId = :favoriteProfileId AND favoriteShopId = :favoriteShopId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteShopId" => $this->favoriteShopId];
		$statement->execute($parameters);
	}
	/**
	 * gets the Like by tweet id and profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteProfileId profile id to search for
	 * @param int $favoriteShopId shop id to search for
	 * @return favorite|null favorite found or null if not found
	 */
	public static function getfavoriteByfavoriteShopIdAndfavoriteProfileId(\PDO $pdo, int $favoriteProfileId, int $favoriteShopId) : ?favorite {
		// sanitize the shop id and profile id before searching
		if($favoriteProfileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		if($favoriteShopId <= 0) {
			throw(new \PDOException("shop id is not positive"));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteShopId, favoriteDate FROM `favorite` WHERE favoriteProfileId = :favoriteProfileId AND favoriteShopId = :favoriteShopId";
		$statement = $pdo->prepare($query);
		// bind the shop id and profile id to the place holder in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId, "favoriteShopId" => $favoriteShopId];
		$statement->execute($parameters);
		// grab the like from mySQL
		try {
			$favorite = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$favorite = new favorite($row["favoriteProfileId"], $row["favoriteShopId"], $row["favoriteDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($favorite);
	}
	/**
	 * gets the favorite by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteProfileId profile id to search for
	 * @return \SplFixedArray SplFixedArray of favorite found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getfavoriteByfavoriteProfileId(\PDO $pdo, int $favoriteProfileId) : \SPLFixedArray {
		// sanitize the profile id
		if($favoriteProfileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteShopId, favoriteDate FROM `favorite` WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId];
		$statement->execute($parameters);
		// build an array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new favorite($row["favoriteProfileId"], $row["favoriteShopId"], $row["favoriteDate"]);
				$favorite[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
	}
	/**
	 * gets the favorite by shop id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteShopId shop id to search for
	 * @return \SplFixedArray array of favorites found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getfavoriteByfavoriteShopId(\PDO $pdo, int $favoriteShopId) : \SplFixedArray {
		// sanitize the shop id
		$favoriteShopId = filter_var($favoriteShopId, FILTER_VALIDATE_INT);
		if($favoriteShopId <= 0) {
			throw(new \PDOException("shop id is not positive"));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteShopId, favoriteDate FROM `favorite` WHERE favoriteShopId = :favoriteShopId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["favoriteShopId" => $favoriteShopId];
		$statement->execute($parameters);
		// build the array of favorite
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new favorite($row["favoriteProfileId"], $row["favoriteShopId"], $row["favoriteDate"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		//format the date so that the front end can consume it
		$fields["favoriteDate"] = round(floatval($this->favoriteDate->format("U.u")) * 1000);
		return ($fields);
	}
}