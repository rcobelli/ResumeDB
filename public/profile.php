<?php

include '../init.php';

$samlHelper->processSamlInput();

if (!$samlHelper->isLoggedIn()) {
    header("Location: index.php");
    die();
}

$config['type'] = Rybel\backbone\LogStream::console;

$helper = new ProfileHelper($config);

// Boilerplate
$page = new Rybel\backbone\page();
$page->addHeader("../includes/header.php");
$page->addFooter("../includes/footer.php");
$page->addHeader("../includes/navbar.php");

// Start rendering the content
ob_start();
?>
<h1>Profile</h1>

<table class="table table-hover mt-5">
    <tbody>
    <td><?php echo $helper->name(); ?></td>
    <td><?php echo $helper->email(); ?></td>
    <td><?php echo $helper->phone(); ?></td>
    </tbody>
    </table>
<?php

// End rendering the content
$content = ob_get_clean();
$page->render($content);
