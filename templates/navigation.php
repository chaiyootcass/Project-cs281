<div id="navigation">

    <ul>
        <li><a title="Home" href="index.php">Home</a></li>
        <li><a title="Catalog" href="catalog.php">Catalog</a></li>
        <li><a title="Shirts" href="shirts.php">Shirts</a></li>
        <li><a title="Pants" href="pants.php">Pants</a></li>

        <li><a title="Contact Us" href="contact.php">Contact Us</a></li>
        <li><a title="About Us" href="aboutus.php">About Us</a></li>
        <?php if (!isset($_SESSION['id'])) {
    ?>
            <li><a title="Sign Up" href="signup.php">Sign Up</a></li>
        <?php
} else {
    ?>
            <li><a title="Auction" href="auction.php">Auction</a></li>
            <li><a title="My Favorite" href="favorite.php">Farvoite</a></li>
            <li><a title="Log out" href="logout.php">Log Out</a></li>
        <?php
}
?>
    </ul>
</div>
<div class="cl"></div>
