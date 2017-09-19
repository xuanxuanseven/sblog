<?php
class News extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');   //在构造函数中加载  news_model 在下面的函数中才可以直接调用模型中的函数
        $this->load->helper('url_helper');
    }

    public function index()
    {
		$this->load->library('calendar');  //加载日历类

		parse_str($_SERVER['QUERY_STRING'], $_GET);  //把字符串解析到变量中  $_SERVER['QUERY_STRING']获取?号之后的  变量

		$this->load->library('pagination'); //加载分页类
		$this->load->model('news_model');   //加载books模型
		$res = $this->db->get('myblog');    //进行一次查询            
		$config['base_url'] = base_url().'ci/ci/index.php/news/index';    //设置分页的url路径    把这个路径修改了一下就可以了    分页类就能使用了       
		$config['total_rows'] = $res->num_rows();    //得到数据库中的记录的总条数             
		$config['per_page'] = '3';   //每页记录数
		$config['prev_link'] = 'Previous ';
		$config['next_link'] = ' Next';
		
		$this->pagination->initialize($config);//分页的初始化
		
		if (!empty($_GET['key'])) {   //是空的话 不执行 非空时，执行到这里    终于明白了，原来这里是用来根据在搜索中输入的key来进行查询的  只有search的时候才会执行到这里
			$key = $_GET['key'];   //get提交  所以使用get方法来获得key参数
			$w = " title like '%$key%'";
			
		}else{
			$w=1;			//现在执行到这里基本上都是1
		}
		
		//echo $w;//输出1
       
        
		$data['blogs'] = $this->news_model->blogs($w,$config['per_page'],$this->uri->segment(3));//得到数据库记录 第三个参数确实是用来说明从哪个位置开始读取博客数据
		//$data['blogs'] = $this->news_model->blogs($w,$config['per_page'],null);
		//var_dump($this->uri->segment(3));   //返回null  返回一直是null
		//segment 参数是接收index.php往后面数的第三个参数   这个参数是用来表示从第几个数据开始读取。在点击换页符时该数据会变，由于每页的数据是3个  因此是null 3 6 9 这样的频率在变。
		
		$this->load->view('templates/header');
		$this->load->view('news/index', $data);
		$this->load->view('templates/footer');
		
    }

    public function view($id = NULL)
	{
		$this->load->library('calendar'); 

		$data['blogs_item'] = $this->news_model->up_blogs($id);  //把 data推到页面时  可以使用$blogs_item来访问   $blogs_item['title'] $blogs_item['dates'] 等

		if (empty($data['blogs_item']))
		{
			show_404();
		}

	//	$data['title'] = $data['blogs_item']['title'];   //这句话确实没有什么用  
		

		$this->load->view('templates/header');
		$this->load->view('./news/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function del($id = null)
	{
		//echo 'delete 1';
     
		$this->news_model->del_blogs($id);

		//通过js跳回原页面
		echo'
			<script language="javascript"> 
				alert("delete success!"); 
				window.location.href="http://www.phptest.com/ci/ci/index.php/news/index"; 
			</script> ';		
	}
	

	public function create()
	{
		$this->load->library('calendar'); //加载日历类
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Create a news item';

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');

		if ($this->form_validation->run() === FALSE)//get 方式提交  则重新加载创建页
		{
			//echo 'yanzheng error';//create页面中的内容并没有填写
			$this->load->view('templates/header', $data);
			$this->load->view('news/create');
			$this->load->view('templates/footer');

		}
		else
		{
		//	echo 'yanzheng success';
			$this->news_model->add_blogs();   //post方式提交  把新创建的博客添加到数据库
			
			//跳回blog添加页面
			echo'
			<script language="javascript"> 
				alert("create success!"); 
				window.location.href="http://www.phptest.com/ci/ci/index.php/news/create"; 
			</script> ';
			//再次跳转到 news 控制器的create接口  这时表单中没有任何数据，因此执行都到的是if语句中
			//$this->load->view('news');
		}
		
	}

	public function check()
	{
		$filename = $_POST['filename'];  //filename OK
		$path="D:/www/ci/ci/application/uploads/";//定义一个上传后的目录

        $pathfile = $path.$filename;
        $pathfile=iconv('UTF-8','GB2312',$pathfile);   //file_exists 无法判定包含汉字路径的文件是否存在，因此对路径+文件名进行编码。   ok解决了
		if(file_exists($pathfile)){
			echo json_encode(array('code' => 1));
		}else{
			echo json_encode(array('code' => 0));
		}

	}

	public function upload()
	{
		$upfile=$_FILES["pic"];
		
        //把上传文件的内容插入到博客数据库
		$filecontents = file_get_contents($_FILES['pic']['tmp_name']); //获取文件内容  接下来是把数据插入到数据库
		$filecontents = json_decode($filecontents,true);  //把数据放到数组中了
		$title = $filecontents['title'];
		$dates = date("Y-m-d");
		$contents = $filecontents['contents'];

		$data = array(
              'title' => $title,
              'dates' => $dates,
              'contents' => $contents
			);

		$res = $this->news_model->insert_blogs($data);
		if(!$res){
			echo '博客数据插入失败~';
		}

		
		$typelist = array("text/plain");
		$path="D:/www/ci/ci/application/uploads/";//定义一个上传后的目录

		if($upfile["error"]>0){


			switch ($upfile['error']) {

			case 1:
			      $info = "上传文件超过了php.ini中upload_max_filesize选项中的最大值.";
			      break;
			case 2:
			      $info = "上传文件大小超过了html中MAX_FILE_SIZE选项中的最大值.";
			      break;
			case 3:
			      $info = "文件只有部分被上传";
			      break;
			case 4:
			      $info = "没有文件被上传";
			      break;
			case 6:
			      $info = "找不到临时文件夹.";
			      break;
			case 7:
			      $info = "文件写入失败!";
			      break;
		}

		die("上传文件错误原因:".$info);
	}


    if($upfile['size']>100000){
    	die("上传文件大小超过限制");
    }


    if(!in_array($upfile["type"],$typelist)){
    	die("上传文件类型非法！".$upfile["type"]);
    }

    
 /*   $fileinfo  = pathinfo($upfile["name"]);

    do{
    	$newfile = date("YmdHis").rand(1000,9999).".".$fileinfo["extension"];
    }while(file_exists($path.$newfile));  //生成一个不存在的文件名*/

   // var_dump($newfile);die;  //返回一个文件的名字  string(22) "201709151646476336.txt"
       
      $filename =  iconv('utf-8','gb2312',$upfile['name']);

       if(is_uploaded_file($upfile["tmp_name"])){
       	
   	        if(move_uploaded_file($upfile["tmp_name"],$path.$filename)){
   	         	echo'
			<script language="javascript"> 
				alert("文件上传成功！"); 
				window.location.href="http://www.phptest.com/ci/ci/index.php/news/"; 
			</script> ';
        	}else{
   		        die("文件上传失败！");
     	    }
       }else{
   	       die("不是一个上传文件！");
       }



   }

}