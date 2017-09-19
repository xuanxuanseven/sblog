<body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item" href="http://www.phptest.com/ci/ci/index.php/news">Blog</a>
          <a class="blog-nav-item" href="http://www.phptest.com/ci/ci/index.php/news/create">Create</a>
          <a class="blog-nav-item" href="#">Press</a>
          <a class="blog-nav-item" href="#">New hires</a>
          <a class="blog-nav-item" href="http://www.phptest.com/ci/ci/index.php/login">Login</a>
        </nav>
      </div>
    </div>

<div class="container">
	
    <div class="row">

        <div class="col-sm-8 blog-main">

        <div class="blog-post">
				<br>
				<h2 class="blog-post-title"><?php echo $blogs_item['title']; ?></h2>
				
				<p class="blog-post-meta">
					<?php echo $blogs_item['dates']; ?>
					
				</p>
				
				<div class="main">
					<?php echo $blogs_item['contents']; ?>
				</div>
		    </div><!-- /.blog-post -->
		
		</div><!-- /.blog-main -->

		
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>
		  <div class="sidebar-module sidebar-module-inset">
            <?php //echo $this->calendar->generate(); ?>
          </div>
          <div class="sidebar-module">
            <h4>Archives</h4>
            <ol class="list-unstyled">
              <li><a href="#">March 2014</a></li>
              <li><a href="#">February 2014</a></li>
              <li><a href="#">January 2014</a></li>
              <li><a href="#">December 2013</a></li>
              <li><a href="#">November 2013</a></li>
              <li><a href="#">October 2013</a></li>
              <li><a href="#">September 2013</a></li>
              <li><a href="#">August 2013</a></li>
              <li><a href="#">July 2013</a></li>
              <li><a href="#">June 2013</a></li>
              <li><a href="#">May 2013</a></li>
              <li><a href="#">April 2013</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Elsewhere</h4>
            <ol class="list-unstyled">
              <li><a href="#">GitHub</a></li>
              <li><a href="#">Twitter</a></li>
              <li><a href="#">Facebook</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

    </div><!-- /.row -->

</div><!-- /.container -->