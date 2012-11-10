<?php
// Create or access an existing session
session_start();

//Check for Login Information
$clientid = $_SESSION['clientid'];
$clientfirst = $_SESSION['clientfirst'];
$clientlast = $_SESSION['clientlast'];
$clientemail = $_SESSION['clientemail'];
$clientrights = $_SESSION['clientrights'];
$loginflag = $_SESSION['loginflag'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Home | 336 World Site</title>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/head.php'; ?>
  </head>
  <body>
    <section id="page_section">
      <header id="page_header">
        <div id="logo"><?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/logo.php'; ?></div>
        <div id="tools"><?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/maintools.php'; ?></div>
      </header>
      <nav id="page_nav"></nav>
      <div id="content_area">
        <div id="content">
          <div>
<h1>World Learning Site</h1>
    <p>This site is for learning about the world while learning PHP.</p>

          </div>
        </div>
        <aside id="page_aside">
          <div>
          </div>
        </aside>
      </div>
      <footer id="page_footer">
        <div>
          <?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/mainfooter.php'; ?>
          <p>Last Updated: <?php echo date('j F, Y', getlastmod()); ?></p>
        </div>
      </footer>
    </section>
  </body>
</html>