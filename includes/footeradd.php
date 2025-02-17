<footer>
    <div class="footer-content">
        <p>&copy; <?php echo date("Y"); ?> Admin Panel. All rights reserved.</p>
        <nav class="footer-nav">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</footer>

<style>
    html, body {
        height: 100%;
        margin: 0;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    .content {
        flex: 1;
    }
    footer {
        background-color: #333;
        color: #fff;
        padding: 20px 0;
        text-align: center;
        margin-top: auto;
    }
    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
    }
    .footer-nav ul {
        list-style: none;
        padding: 0;
    }
    .footer-nav ul li {
        display: inline;
        margin: 0 10px;
    }
    .footer-nav ul li a {
        color: #fff;
        text-decoration: none;
    }
    .footer-nav ul li a:hover {
        text-decoration: underline;
    }
</style>