<?php
include '../init.php';

$resumeDao = new ResumeDao($config);

if ($_REQUEST['action'] == 'delete') {
    if ($helper->delete($_REQUEST['id'])) {
        header("Location: ?");
        die();
    } else {
        $errors[] = $helper->getErrorMessage();
    }
}

// Site/page boilerplate
$site = new site($errors);
$site->addHeader("../includes/navbar.php");
init_site($site);

$page = new page();
$site->setPage($page);

// Start rendering the content
ob_start();

?>
<button class="btn btn-success float-right" onClick="MyWindow=window.open('newResume.php','MyWindow','width=600,height=900'); return false;">New Resume</button>
<h1>Manage Resumes</h1>
    <table class="table table-hover mt-5">
        <thead>
        <tr>
            <th>Internal Resume Names</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($resumeDao->selectAll() as $i) {
            echo "<tr>";
            echo "<td><a onClick=\"MyWindow=window.open('editResume.php?action=update&id=" . $i['resume_id'] . "','MyWindow','width=600,height=900'); return false;\" href='#'>" . $i['internal_resume_name'] . "</a></td>";
            echo "<td><a class='btn btn-outline-danger' href='?action=delete&id=" . $i['job_id'] . "'>🗑️</a>&nbsp;<a class='btn btn-outline-info' href='#' onClick=\"MyWindow=window.open('printResume.php?id=" . $i['resume_id'] . "','MyWindow','width=600,height=900'); return false;\">🖨️</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

<?php
$content = ob_get_clean();
$page->setContent($content);

$site->render();
