<?phpsession_start();if(!empty($_SESSION['message'])){ $message = $_SESSION['message'];}?><!DOCTYPE html><html lang="en"> <head>  <meta charset="UTF-8">  <title>Administration | 3361 World Site</title> </head> <body>  <section id="page_section">   <header id="page_header">    <div>     <div id="logo">      <?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/logo.php'; ?>     </div>     <nav id="page_nav">     </nav>    </div>   </header>   <div id="content_area">    <div id="content">     <div>      <h1>Administration Page</h1>      <?php       if(isset($message)){ echo "<p class='message'>$message</p>" ;} elseif(!empty ($errors)){       echo '<ul class="errors">'; foreach ($errors as $error) {  echo '<li>'. $error . '</li>'; } echo '</ul>';      }                  ?>                 </div>    </div>    <aside id="page_aside">     <div>     </div>    </aside>   </div>   <footer id="page_footer">    <div><?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/mainfooter.php'; ?>     <p>Last Updated: <?php echo date('j F, Y', getlastmod()); ?></p>    </div>   </footer>  </section> </body></html><?php unset($message) ?>