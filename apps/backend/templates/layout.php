<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php use_stylesheet('admin.css')?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body>
    <div id="header">
      Hangman
    </div>
    <div id="content">
	    <?php if($sf_user->isAuthenticated()): ?>
	    <div id="menu">
	      <ul>
	        <li>
	          <?=link_to('Wörter', '@words')?>
	        </li>
	        <li>
	          <?=link_to('Logout', '@sf_guard_signout')?>
	        </li>
	      </ul>
	    </div>
	    <?php endif;?>
     <?php echo $sf_content ?>
    </div>
  </body>
</html>
