<?php
class User_test extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this -> load -> database();//读取配置文件中的数据库信息
	}
	
	function u_insert($arr)
	{
		$this -> db -> insert('user',$arr);  //向 user 表中插入信息$arr   $arr 是关联数组
	}
	
	function u_update($id,$arr)
	{
		$this -> db ->where('uid',$id);
		$this -> db ->update('user',$arr);//更新表中的信息
	}
	
	function u_del($id)
	{
		$this -> db ->where('uid',$id);
		$this -> db ->delete('user'); //删除表中的指定信息
	}
	
	function u_select($name)
	{
		$this -> db ->where('uname',$name);  //  where 条件是 uname = $name
		$this -> db ->select('*');   //select * from user where uname='$name'
		$query = $this -> db ->get('user');//获取表中的信息并返回结果
		return $query -> result();
	}

	function u_verify($str,$flag)
	{
		if($flag == 1){
			$this->db->where('uname',$str);
		}else if($flag == 2){
			$this->db ->where('phone',$str);
		}else if($flag ==3){
			$this->db ->where('email',$str);
		}else{
			//什么也不做
		}

		$this -> db ->select('*');
		$query = $this -> db ->get('user');
		$count = $query->num_rows();
        return $count;     
	    
	}

}



?>