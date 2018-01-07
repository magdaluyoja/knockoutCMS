<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">
      	<br />
      	<a href="/knockoutCMS/public/admin/">&laquo; Main menu</a><br />

        <?php // echo public_navigation($current_subject, $current_page); ?>
        <ul data-bind="foreach: subjects" class="subjects">
            <l1>
                <a data-bind="text:menu_name, click: $parent.getSubjectContent, css: $parent.isSelected()" href="#"></a>
                <ul data-bind = "foreach: sub_menu" class="pages">
                    <li>
                        <a data-bind="text: sub_menu_name, click: $root.getPageContent" href="#"></a>
                    </li>
                </ul>
            </li>
        </ul>
        <br/>
        <a href="/knockoutCMS/public/admin/manage_subjects/"> &raquo;Manage subjects</a><br/>
        <a href="/knockoutCMS/public/admin/manage_pages/"> &raquo;Manage pages</a>
    </div>
    <div id="page">
        <div data-bind="visible: subjectVisible">
            <h2>Manage Subject</h2>
            Menu name: <span data-bind="html: menu_name"></span><br />
            Position: <span data-bind="html: position"></span><br />
            Visible: <span data-bind="html: isVisible(visible)"></span><br />
            <br />
            
            <div style="margin-top: 2em; border-top: 1px solid #000000;">
                <h3>Pages in this subject:</h3>
                <ul data-bind="foreach: pageList">
                    <li data-bind="text: $data"></li>
                </ul>
                <br />
            </div>
        </div>
        <div data-bind="visible: pageVisible">
            <h2>Manage Page</h2>
            <!-- ko foreach: pageData -->
                Menu name: <span data-bind="html: submenu_name"></span><br />
                Position: <span data-bind="html: position"></span><br />
                Visible: <span data-bind="html: $parent.isVisible(visible)"></span><br />
                Content:<div data-bind="html: $parent.newcontent(content)"  style="border: 1px solid black; padding: 10px; margin: 15px;"></div><br />
            <!-- /ko --> 
        </div>
        <br />
        <div data-bind = "html: loading, visible: showloading" class="loading"></div>
    </div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/jsincludes.php"); ?>
<script src="manage_content.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/footer.php"); ?>