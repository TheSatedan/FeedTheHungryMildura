<?php
$dbConnection = databaseConnection();
?>

<div class="blackBox">
    <div class="body-content">
        <div class="loginRight">
            <?php
            if (isset($_SESSION['userUsername'])) {
                echo '<font color="black">Logged in as: <font color="white">' . $_SESSION['userUsername'] . ' <a id="supporters" href="index.php?id=Members"><button>Members Area</button></a> <a id="supporters" href="index.php?id=Logout"><button>Logout</button></a><br>';
            } else {
                ?>
                <form method="POST" action="index.php?id=ProcessLogin">
                    <input type="text"	name="username" placeholder="Username" size=15>
                    <input type="password" name="password" placeholder="*********">
                    <input type="submit" name="submit" value="Login"></form>

<?php } ?>
        </div>
    </div>
</div>

<div class="body-content">
    <div id="firstRow">
        <div class="logo-content">
            <img src="Images/logo.svg" width="100%">
        </div>
        <div class="menu-content">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?id=TownServices">Facilities</a></li>
                <li><a href="index.php?id=Supporters">Supporters</a></li>
                <li><a href="index.php?id=Faq">FAQ</a></li>
                <li><a href="index.php?id=Resources">Resources</a></li>
                <li><a href="index.php?id=Contact">Contact</a></li>
<?php
if (isset($_SESSION['userUsername'])) {
    
} else {
    echo '<li><a href="index.php?id=Register">Register</a></li>';
}
?>

            </ul>
        </div>
    </div>
    <div id="secondRow">
        <div class="dontation-conent">
            <a href="index.php?id=Support"><img src="Images/support.png" width="90%"></a><br>
            <a href="index.php?id=CookBook"><img src="Images/cookbook.png" width="90%"></a><br>
            <a href="index.php?id=WishList"><img src="Images/wishlist.png" width="90%"></a>
        </div>
        <div class="whoweare-content">

<?php
$aboutID = 1;

if ($stmt = $dbConnection->prepare("SELECT aboutDescription FROM about WHERE aboutID=? ")) {

    $stmt->bind_param("i", $aboutID);
    $stmt->execute();
    $stmt->bind_result($aboutDescription);
    $stmt->fetch();

    echo nl2br($aboutDescription) . '';
}
?>
        </div>
    </div>
</div>
