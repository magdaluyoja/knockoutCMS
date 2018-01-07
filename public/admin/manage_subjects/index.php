<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">
      	<br />
      	<a href="/knockoutCMS/public/admin/">&laquo; Main menu</a><br />
        <a href="/knockoutCMS/public/admin/manage_content/"> &laquo; Manage contents</a><br/><br/>
        <a href="/knockoutCMS/public/admin/manage_pages/"> &raquo; Manage pages</a>
    </div>
    <div id="page">

	    <h2>Create Subject</h2>

        <form data-bind="submit: saveSubject">
            <p>Menu name:
                <input type="text" name="menu_name" data-bind="value: menuName, hasfocus: focused" />
            </p>
            <p>Position:
                <select name="position" data-bind="value:position,options: positionList"></select>
            </p>
            <p>Visible:
                <label><input type="radio" name="visible" value="0" data-bind="checked: visible"/> No</label>
                &nbsp;
                <label><input type="radio" name="visible" value="1" data-bind="checked: visible"/> Yes</label>
            </p>
            <input type="submit" name="submit" data-bind="value: saveMode" />
        </form>

        <div data-bind = "html: loading, visible: showloading" class="loading"></div>
        <div data-bind="html: msgs, visible: showmsg, css: msgClass"></div>

        <br/>
        <br/>
        <table>
            <tr>
              <th style="text-align: left; width: 200px;">Menu</th>
              <th style="text-align: left;">Position</th>
              <th style="text-align: left;">Visible</th>
            </tr>
            <!-- ko foreach: subjectList -->  
                <tr>
                  <td data-bind="text: menu_name"></td>
                  <td data-bind="text: position"></td>
                  <td data-bind="text: isVisible(visible)"></td>
                  <td><a href="#" data-bind="click: editSubject">Edit</a></td>
                  <td><a href="#" data-bind="click: deleteSubject">Delete</a></td>
                </tr>
            <!-- /ko -->  
        </table>
    </div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/jsincludes.php"); ?>
<script src="manage_subjects.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/footer.php"); ?>