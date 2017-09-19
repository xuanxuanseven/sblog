<?php
class News_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
	//获取所有blog
	public function blogs($w,$num,$offset)
	{	
		
		if($w == 1)
		{	
			$query = $this->db->get('myblog',$num,$offset);  //如果不是查询指定的blog  则第三个参数是0   也就是从第一篇博客开始查询
			return $query->result_array();
		
		}elseif(strpos($w,"title like")){
			$query = $this->db->query("select * from myblog where $w order by id desc limit 5;");
			return $query->result_array();
		
		}else{
			$query = $this->db->get('myblog',$num,$offset);
			return $query->result_array();
			
		}
		
	}
	
	//查看一篇blog
	public function up_blogs($id = FALSE)
	{
		if ($id === FALSE)
		{
			$query = $this->db->get('myblog');
			return $query->result_array();
		}
		//更新点击数
		//$this->db->query("update myblog set hits=hits+1 where id='$id';");

		$query = $this->db->get_where('myblog', array('id' => $id));
		return $query->row_array();
	}
	
	//添加一篇blog
	public function add_blogs()
	{
		$this->load->helper('url');

		//$slug = url_title($this->input->post('title'), 'dash', TRUE);
		$d = date("Y-m-d");

		$data = array(
			'title' => $this->input->post('title'),
			'dates' => $d,
			'contents' => $this->input->post('text')
		);

		return $this->db->insert('myblog', $data);
	}
	//删除一篇blog
	public function del_blogs($id = FALSE){
		
		$this->load->helper('url');
		
		if ($id === FALSE)
		{
			$query = $this->db->get('myblog');
			return $query->result_array();
		}

		$array = array(
			'id' => $id
		);

		return $this->db->delete("myblog",$array);
		
	}

	public function insert_blogs($data)
	{
		return $this->db->insert('myblog',$data);
	}
}