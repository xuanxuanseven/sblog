<?php

class Signin extends CI_Controller {
	
	
	
	public function index()
	{	$this->load->view("templates/header");
		$this->load->view('news/signin');
		$this->load->view('templates/footer');
	}
	
	function regist() {
		$this->load->model('user_test'); //ÔØÈëÎÒÃÇÖ®Ç°´´½¨µÄUser_testÄ£ÐÍ£¬Ê××ÖÄ¸²»ÓÃ´óÐ¡
       
		if(empty($_POST['username']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['password'])){
			echo '字段不能为空~';
			return;
		}

			//判断 用户名、邮箱、手机号是不是已经占用
		if($this ->user_test->u_verify($_POST['username'],1)){
		    echo '抱歉，用户名已被占用~';
		    return;
		}

		if($this ->user_test->u_verify($_POST['phone'],2)){
			echo '抱歉，手机号已被注册~';
			return;
		}

		if($this ->user_test->u_verify($_POST['email'],3)){
            echo '抱歉，邮箱已被注册~';
            return;

		}

		$this->load->library('encrypt'); //³öÊ¼»¯¼ÓÃÜÀà    
		
		$pawd = $this->encrypt->encode($_POST['password']);  //¶ÔÃÜÂë½øÐÐ¼ÓÃÜ
        
        
		$arr = array('uname'=>$_POST['username'],
					 'upawd'=>$pawd,
					 'phone'=>$_POST['phone'],
					 'email'=>$_POST['email'],
					 );


        $this->user_test->u_insert($arr); //µ÷ÓÃuser_testµÄu_insert·½·¨²åÈëÊý¾Ý
        echo 'Register success';		
    }
	
	// ÃÜÂë¼ÓÃÜ²âÊÔ
	function pwdtest(){
		echo 'yunxingdaole';  //没有执行到这个函数  该函数写了没有什么用
		$this->load->library('encrypt');//ÔÚ¿ØÖÆÆ÷ÀïÃæµ÷ÓÃ¼ÓÃÜÀà
		
		/*¼ÓÃÜ¹ý³Ì*/
		//µÚÒ»ÖÖ·½·¨
		$a = 'My secret message';
		$aa = $this->encrypt->encode($a);
		echo $aa;
		echo "<br />";
		//µÚ¶þÖÖ·½·¨
		$b = 'My secret message';
		$b1 = 'super-secret-key';
		$bb = $this->encrypt->encode($b, $b1);
		echo $bb;
		echo "<br />";
		/*½âÃÜ¹ý³Ì*/
		//µÚÒ»ÖÖ·½·¨
		$c = $aa;
		$cc = $this->encrypt->decode($c);
		echo $cc;
		echo "<br />";
		//µÚ¶þÖÖ·½·¨
		$d = $bb;
		$d2 = 'super-secret-key';
		$dd = $this->encrypt->decode($d, $d2);
		echo $dd;
	}

}