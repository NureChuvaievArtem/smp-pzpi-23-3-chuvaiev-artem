<style>
    a {
        text-decoration: none;
        color: black;
        font-family: 'Arial, Helvetica, sans-serif';
        font-size: large;
    }
</style>

<header style="display: flex; justify-content: space-between; align-items: center; margin: 0 auto; height: 30px; padding: 0%;">
    <a style="text-decoration: none;" href="../index.php">
        <i class="fas fa-home" style="font-size:24px"></i> Home
    </a>
    <p>|</p>
    <a href="../index.php?page=products">
        <i class="fas fa-box-open" style="font-size:24px"></i> Products
    </a>
    <p>|</p>
    <?php
    if (isset($_SESSION['username'])) {
        echo '<a href="../index.php?page=cart">
                <i class="fas fa-shopping-cart" style="font-size:24px"></i> Cart
              </a>';
        echo '<p>|</p>';
        echo 
        '<a href="../index.php?page=profile">
            <i class="fas fa-user" style="font-size:24px"></i> Profile
        </a>';
        echo '<p>|</p>';
        echo 
        '<form id="logout-form" action="../scripts/logout.php" method="POST" style="display:inline;">
            <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;">
                <i class="fas fa-user" style="font-size:24px"></i> <a>Logout</a>
            </button>
        </form>';
    } else {
        echo '<a href="../index.php?page=login">
                <i class="fas fa-sign-in-alt" style="font-size:24px"></i> Login
              </a>';
    }
    ?>
</header>