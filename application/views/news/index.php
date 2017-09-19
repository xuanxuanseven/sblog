  <body>
	
    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="#">Blog</a>
          <a class="blog-nav-item" href="http://www.phptest.com/ci/ci/index.php/news/create">Create</a>
          <a class="blog-nav-item" href="#">Press</a>
          <a class="blog-nav-item" href="#">New hires</a>
          <a class="blog-nav-item" id="logindown" >
             <span>登录</span>
             <ul class="logindown_menu" >
                  <li>用户中心</li>
                  <li>退出当前帐户</li>
             </ul>
          </a>
		                           
          <form class="navbar-form navbar-right" method="get">
            <div class="form-group">
              <input type="text" name="key" placeholder="search" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Search</button>
          </form>

          <form action="upload" id="upload-form" class="navbar-form navbar-left" method="post" enctype="multipart/form-data">
          <div class="form-group">
          <input type="file" name="pic" id="filename" class="form-control"><input type="button" id="msubmit" class="btn btn-success" value="上传">
          </div>
          </form>


         <script>
            $(document).ready(function(){
             // $(".logindown_menu li").hide();
               var logindown_menu = $(this).find('.logindown_menu');
               logindown_menu.slideUp();//为了使菜单最开始是没有显示的

              $("#msubmit").click(function(){
                var filename = $("#filename").val();
                var filename = getFileName(filename);  
                $.post('check',{filename:filename},function(data){
                    data = JSON.parse(data);
   
                    if (data.code == 1) {
                        iscover = confirm('文件已存在，是否覆盖？');
                        if (iscover) {
                          $('#upload-form').submit();
                        }
                    }else{
                      $('#upload-form').submit();
                    }
                });
              });

              function getFileName(o){
                   var pos=o.lastIndexOf("\\");
                   return o.substring(pos+1);  
              }



              if($("#logindown").length!=0){
                   $("#logindown").each(function(e){
                         //var logindown_menu = $(this).find('.logindown_menu');
                         $(this).click(function(){     //只要是在dropdown 类包含的范围内的点击都会使菜单弹出和消失 把类包含的范围内的标签换一个值也还是这样
                         // logindown_menu.show();
                         logindown_menu.slideToggle();   //只要是菜单栏包含的东西都会进行卷进和卷出
                       });

                  $(document).mouseup(function(e) {
                         if (logindown_menu.is(":visible") && $(e.target).parents('#logindown').length == 0) {
                         logindown_menu.slideUp();
                     }
                  });
               });
            }

               $(".logindown_menu li").click(function(){   //判断点击的是哪个li 标签 点击到退出帐户标签的话直接跳转到 login/logout退出该帐户
                if($(this).index() == 1){
                  window.location.href="http://www.phptest.com/ci/ci/index.php/login/logout";
                }
               });
      });
         </script>
        </nav>
      </div>
    </div>

    <div class="container">
	<!--
      <div class="blog-header">
        <h1 class="blog-title">The Bootstrap Blog</h1>
        <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>
      </div>
	-->
      <div class="row">

        <div class="col-sm-8 blog-main">

        <div class="blog-post">
			  <br>
		  
		  	  <?php foreach ($blogs as $blogs_item): ?>

				<h2 class="blog-post-title"><?php echo $blogs_item['title']; ?></h2>
				
				<p class="blog-post-meta">
					<?php echo $blogs_item['dates']; ?>
				</p>
				
				<div class="main">
					<?php echo iconv_substr($blogs_item['contents'],0,100); ?>...
				</div>
				<p><a href="<?php echo base_url('ci/ci/index.php/news/view/'.$blogs_item['Id']); ?>">View article</a></p>
				<p><a href="<?php echo base_url('ci/ci/index.php/news/del/'.$blogs_item['Id']); ?>">Delete</a></p>
			
			  <?php endforeach; ?>
			  <!--·­Ò³Á´½Ó-->
			  <br><br><?php echo $this->pagination->create_links();?>
            
        </div><!-- /.blog-post -->
		
		<!--
          <nav>
            <ul class="pager">
              <li><a href="#">Previous</a></li>
              <li><a href="#">Next</a></li>
            </ul>
          </nav>
		-->
		
        </div><!-- /.blog-main -->

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>
		  <div class="sidebar-module sidebar-module-inset">
            <?php //echo $this->calendar->generate();//remind timezone setting?>
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

	

