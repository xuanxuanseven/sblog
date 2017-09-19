<?php
include_once('News.php');

class Login extends News{
	public function index()
	{
		$this->load->view('templates/header');//已经写好的
		$this->load->view('news/login');   //点击index页面  和  create页面的login按钮时，会跳转到这里。看似是退出登录了，其实就是直接加载的登录页。 不应该直接加载登录页还是应该跳转到logout  把session中的信息去掉。
		$this->load->view('templates/footer');
	}
	
	function check()
	{
		$this->load->library('encrypt');//加载ci框架库中的函数
		
		$this->load->model('user_test');  //使用自己写的model  user_test.php
		$user = $this -> user_test -> u_select($_POST['u_name']);//调用模型的方法
		
		$passwd = $user[0]->upawd;  //返回user的第一个
		$pawd = $this->encrypt->decode($passwd);  //对密码进行解密

		if($user){
			if($pawd == $_POST['u_pawd']){
				//echo "<script>window.location.href='".base_url('ci/ci/index.php/Login/mainindex')."'</script>";//跳转不过去
				echo "<script>window.location.href='".base_url('ci/ci/index.php/News/index')."'</script>";
		       
				$this->load->library('session');
				$arr = array('s_id' => $user[0]->uid);
				$this -> session -> set_userdata($arr);//把 id保存在session中
			}else{
				echo 'pw wrong';
			}
		}else{
			echo 'name wrong';
		}
	}
	
	function is_login(){
		$this -> load -> library('session');
		if($this -> session -> userdata('s_id')){
			echo "logined";
		}else{
			echo "no login";
		}
	}
	
	function logout()
	{
		$this -> load -> library('session');
		$this -> session -> unset_userdata('s_id');//把seession处理完了后  再url定位到登录页的目录
		echo "<script>window.location.href='".base_url('ci/ci/index.php/login')."'</script>";
	}
	
}


?>