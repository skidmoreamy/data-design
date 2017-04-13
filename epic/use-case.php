<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><center>Data Design Etsy</center></title>
</head>
	<body><h1><strong>Data Design Using Etsy</h1></strong></body>
	<h2>
		<strong>Persona</strong>
	</h2>
	<p><br><strong>Name:</strong> Amber</br>
		<br><strong>Age:</strong> 21</br>
		<br><strong>Profession:</strong> Artist</br>
		<br><strong>Technology:</strong> MacBooK Pro laptop, an Iphone Six Plus, and an Ipad Pro; all with unlimited data.</br>
		<br><strong>Attitudes:</strong> She works from home making her own schedule. She spends several hours per day online, including frequnetly browsing Etsy to update her art shop, as well as to browse others shops for interesting items to add to her growing collection. She frequently uses social media to promote her gallary showings and the art shop she maintains on Etsy.</br>
		<br><strong>Frustrations and Needs:</strong> Amber is frustrated with the amout of traffic and sales her shop gets. She needs to increase traffic to her Etsy shop in-order to promote sales and recognition.</br>
		<br><strong>Goals:</strong> Amber goals include; increasing traffic to her shop, increasing sales from the shop, and increasing recoginition of her art.</br>
	</p>
	<h2><strong>Use Case</strong>
	</h2>
	<p><br>Amber is a frequent user of technology and has applied this to her work. She uses Etsy to promote, sell, and show her art. Amber has recently taken to browsing other shops that she likes and favoriting them inorder to raise recognition for her own shop. To do this Amber will access the site, select a specific shop, and click the favorite button.</br>
		<br>A user favorites an Etsy shop by:</br>
	<li>The user accesses Etsy</li>
	<li>The user selects the shop</li>
	<li>The user clicks the favorites button</li></p>
	<h2><strong>Conceptual Model</strong></h2>
	<p><br><strong>PROFILE</strong></br>

	<li>profileId (primary key)</li>
	<li>profileActivationToken (for account verification)</li>
	<li>profileAtHandle</li>
	<li>profileEmail</li>
	<li>profileHash (for account password)</li>
	<li>profilePhone</li>
	<li>profileSalt (for account password)</li>
	<strong>Etsy</strong>
	<li>etsyid (primary key)</li>
	<li>etsyProfiled</li>
	<li>shopProfile</li>
	<strong>Favorite</strong>
	<li>favoriteProfileid (foreign key)</li>
	<li>favoriteShopId(foreign id)</li>
	<li>favoriteDate</li>
	<strong>Relations:</strong>
	<li>Many users can favorite many shops</li>
	<li>Many shops can be favorited by many users</li>
	</p>
</html>
