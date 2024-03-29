<?php

include '../init.php';

$samlHelper->processSamlInput();

if (!$samlHelper->isLoggedIn()) {
    header("Location: index.php");
    die();
}

$config['type'] = Rybel\backbone\LogStream::console;

$helper = new CertificationDao($config);

// Boilerplate
$page = new Rybel\backbone\page();
$page->addHeader("../includes/header.php");
$page->addFooter("../includes/footer.php");
$page->addHeader("../includes/navbar.php");

// Application logic
if ($_REQUEST['action'] == 'delete') {
    if ($helper->delete($_REQUEST['id'])) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
} elseif ($_REQUEST['submit'] == 'create') {
    if ($helper->insert($_POST)) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
} elseif ($_REQUEST['submit'] == 'update') {
    if ($helper->update($_POST['id'], $_POST)) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
}


// Start rendering the content
ob_start();

if ($_REQUEST['action'] != 'create') {
    ?>
    <button class="btn btn-success float-right" onclick="window.location = '?action=create'">New Certification</button>
    <?php
}
?>
<h1>Manage Certifications</h1>

<?php

if ($_REQUEST['action'] == 'create') {
    include_once('../components/newCertForm.php');
} elseif ($_REQUEST['action'] == 'update') {
    $data = $helper->select($_REQUEST['id']);
    include_once('../components/editCertForm.php');
} else {
    ?>
    <table class="table table-hover mt-5">
        <thead>
        <tr>
            <th>Internal Name</th>
            <th>External Name</th>
            <th>Expiration</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($helper->selectAll() as $i) {
            if ($i['expiration'] != null) {
                $i['expiration'] = date('m/d/Y', strtotime($i['expiration']));
            }

            echo "<tr>";
            echo "<td><a href='?action=update&id=" . $i['certification_id'] . "'>" . $i['internal_certification_name'] . "</a></td>";
            echo "<td><a  href='?action=update&id=" . $i['certification_id'] . "'>" . $i['external_certification_name'] . "</a></td>";
            echo "<td><a  href='?action=update&id=" . $i['certification_id'] . "'>" . $i['expiration'] . "</a></td>";
            echo "<td><a class='btn btn-outline-danger' href='?action=delete&id=" . $i['certification_id'] . "'>🗑️</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
}


// End rendering the content
$content = ob_get_clean();
$page->render($content);
