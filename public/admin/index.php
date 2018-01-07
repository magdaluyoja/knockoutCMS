<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">
      &nbsp;
    </div>
    <div id="page">
        <h2>Admin Menu</h2>
        <p>Welcome to the admin area, <?php echo htmlentities($_SESSION["username"]); ?>.</p>
        <ul>
            <li><a href="/knockoutCMS/public/admin/manage_content">Manage Website Content</a></li>
            <li><a href="/knockoutCMS/public/admin/manage_admins">Manage Admin Users</a></li>
            <li><a href="/knockoutCMS/public/logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/footer.php"); ?>