<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">
      	<br />
      	<a href="/knockoutCMS/public/admin/">&laquo; Main menu</a><br />
        <a href="/knockoutCMS/public/admin/manage_content/"> &laquo; Manage contents</a><br/><br/>
        <a href="/knockoutCMS/public/admin/manage_subjects/"> &raquo; Manage subjects</a>
    </div>
    <div id="page">
    
        <h2>Create Page</h2>
        <form data-bind="submit: savePage">
            <p>Menu name:
                <select name="menu_name" data-bind="options: subjectList,
                       optionsText: 'menu_name',
                       optionsValue: 'id',
                       value: subjectId, 
                       optionsCaption: 'Choose Menu'"></select>
            </p>
            <p>Sub menu name:
                <input type="text" name="submenu_name" data-bind="value:submenu_name" />
            </p>
            <p>Position:
                <select name="position" data-bind="value:position,options: positionList"></select>
            </p>
            <p>Visible:
                <label><input type="radio" name="visible" value="0" data-bind="checked: visible"/> No</label>
                &nbsp;
                <label><input type="radio" name="visible" value="1" data-bind="checked: visible"/> Yes</label>
            </p>
            <p>Content:<br />
                <textarea name="content" rows="20" cols="80"  data-bind="value: content"></textarea>
            </p>
            <input type="submit" name="submit" data-bind="value: saveMode" />
        </form>
        <br />

        <div data-bind = "html: loading, visible: showloading" class="loading"></div>
        <div data-bind="html: msgs, visible: showmsg, css: msgClass"></div>

        <br/>
        <br/>
        <table>
            <tr>
              <th style="text-align: left; width: 200px;">Menu</th>
              <th style="text-align: left; width: 200px;">Sub Menu</th>
              <th style="text-align: left;">Position</th>
              <th style="text-align: left;">Visible</th>
              <th style="text-align: left;">Content</th>
            </tr>
            <!-- ko foreach: pageList -->  
                <tr>
                  <td data-bind="text: subject_name"></td>
                  <td data-bind="text: submenu_name"></td>
                  <td data-bind="text: position"></td>
                  <td data-bind="text: isVisible(visible)"></td>
                  <td data-bind="html: newcontent(content)"></td>
                  <td><a href="#" data-bind="click: editPage">Edit</a></td>
                  <td><a href="#" data-bind="click: deletePage">Delete</a></td>
                </tr>
            <!-- /ko -->  
        </table>
    </div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/jsincludes.php"); ?>
<script src="manage_pages.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/footer.php"); ?>