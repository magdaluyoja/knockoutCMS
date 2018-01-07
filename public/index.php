<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/includes.php"); ?>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">

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
        <a href="/knockoutCMS/public/login/"> &raquo;Login</a>
    </div>
    <div id="page">
        <div data-bind="visible: subjectVisible">
            <h2 data-bind="html: menu_name"></h2>
            <div>
                <!-- ko foreach: pageList -->
                    <h2 data-bind="text: menu_name">Pages in this subject:</h2>
                    <p data-bind="text: content"></p>
                <!-- /ko --> 
            </div>
        </div>
        <div data-bind="visible: pageVisible">
            <!-- ko foreach: pageData -->
                <h2 data-bind="html: submenu_name"></h2>
                <div data-bind="html: $parent.newcontent(content)"  style="border: 1px solid black; padding: 10px; margin: 15px;"></div><br />
            <!-- /ko --> 
        </div>
        <br />
        <div data-bind = "html: loading"></div>

    </div>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/jsincludes.php"); ?>
<script src="manage_content.js"></script>
<?php include($_SERVER["DOCUMENT_ROOT"]."/knockoutCMS/includes/layouts/footer.php"); ?>