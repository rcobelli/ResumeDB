<?php

include '../init.php';

$samlHelper->processSamlInput();

if (!$samlHelper->isLoggedIn()) {
    header("Location: ?sso");
    die();
}

$config['type'] = Rybel\backbone\LogStream::console;

$resumeDao = new ResumeDao($config);

// Boilerplate
$page = new Rybel\backbone\page();
$page->addHeader("../includes/header.php");
$page->addFooter("../includes/footer.php");
$page->addHeader("../includes/navbar.php");

if ($_REQUEST['action'] == 'delete') {
    if ($helper->delete($_REQUEST['id'])) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
}

// Start rendering the content
ob_start();

?>
<button class="btn btn-success float-right"
    onClick="MyWindow=window.open('newResume.php','MyWindow','width=600,height=900'); return false;">New Resume</button>
<h1>Manage Resumes</h1>
<table class="table table-hover mt-5">
    <thead>
        <tr>
            <th>Internal Resume Names</th>
            <th>Primary Target</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($resumeDao->selectAll() as $i) {
            echo "<tr>";
            echo "<td><a onClick=\"MyWindow=window.open('editResume.php?action=update&id=" . $i['resume_id'] . "','MyWindow','width=600,height=900'); return false;\" href='#'>" . $i['internal_resume_name'] . "</a></td>";
            echo "<td><a onClick=\"MyWindow=window.open('editResume.php?action=update&id=" . $i['resume_id'] . "','MyWindow','width=600,height=900'); return false;\" href='#'>";
            if ($i['machine_first']) {
                echo "Machine";
            } else {
                echo "Human";
            }
            echo "</a></td>";
            echo "<td><a class='btn btn-outline-danger' href='?action=delete&id=" . $i['job_id'] . "'>🗑️</a>&nbsp;<a class='btn btn-outline-info' href='#' onClick=\"MyWindow=window.open('printResume.php?id=" . $i['resume_id'] . "','MyWindow','width=600,height=900'); return false;\">🖨️</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
$page->render($content);
