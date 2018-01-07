<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">
      	<br />
      	<a href="/knockoutCMS/public/admin/">&laquo; Main menu</a><br />
    </div>
    <div id="page">
	    <h2>Manage Admins</h2>


	    <form data-bind="submit: saveAdmin">
            <div>
                <div>Username</div>
                <div><input type="text" name="username" data-bind = "value: username, hasfocus: focused"></div>
                <div>Password</div>
                <div><input type="password" name="password" data-bind = "value: password"></div>
                <div>Confirm Password</div>
                <div><input type="password" name="confirmpassword" data-bind = "value: confirmpassword"></div>
                <div><input type="submit" data-bind="value: saveMode"></div>
            </div>
            <div data-bind = "html: loading"></div>
        </form>

        <div data-bind = "html: loading, visible: showloading" class="loading"></div>
        <div data-bind="html: msgs, visible: showmsg, css: msgClass"></div>

        <br/>
        <br/>
	    <table>
	        <tr>
	          <th >Username</th>
	          <th colspan="2" style="text-align: left;">Actions</th>
	        </tr>
	    	<!-- ko foreach: adminList -->	
		        <tr>
		          <td data-bind="text: username"></td>
		          <td><a href="#" data-bind="click: editAdmin">Edit</a></td>
		          <td><a href="#" data-bind="click: deleteAdmin">Delete</a></td>
		        </tr>
	    	<!-- /ko -->  
	    </table>
    </div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/jsincludes.php"); ?>
<script src="manage_admins.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/footer.php"); ?>