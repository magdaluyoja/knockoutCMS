<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/header.php"); ?>
<div id="main">
  	<div id="navigation">
    	&nbsp;
  	</div>
  	<div id="page">
    
        <h2>Login</h2>
        <form data-bind = "submit: login">
            <div>
               	<div>Username</div>
               	<div><input type="text" name="username" data-bind = "value: username"></div>
               	<div>Password</div>
               	<div><input type="password" name="password"  data-bind = "value: password"></div>
               	<div><input type="submit" value="Login"></div>
            </div>
        </form>
       <div data-bind="html: msgs, visible: showmsg" class="msgs error"></div>
  	</div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/jsincludes.php"); ?>
<script src="login.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/footer.php"); ?>