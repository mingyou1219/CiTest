<? session_start() ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Article extends CI_Controller {
	public function author($author = null,$offset = 0)
	{
		if($author == null){
			show_404("Author not found !");
			return true;
		}
		//引入 model
		$this->load->model("UserModel");
		$this->load->model("ArticleModel");
	 	//先查詢使用者是否存在
		$user = $this->UserModel->getUserByAccount($author);
		if($user == null){
			show_404("Author not found !");
		}
		$pageSize = 20;
	    $this->load->library('pagination');
	    $config['uri_segment'] = 4;
	    $config['base_url'] = site_url('/article/author/'.$author.'/');
	    //取得總數量
	    $config['total_rows'] = $this->ArticleModel->countArticlesByUserID($user->UserID);
	    $config['per_page'] = $pageSize;
		$this->load->library('pagination');
	    $this->pagination->initialize($config);
			
	    $results = $this->ArticleModel->getArticlesByUserID($user->UserID,$offset,$pageSize);
		$this->load->view('article_author',
			Array(
				"pageTitle" => "發文系統 - ".$user->Account." 的文章列表",
				"results" => $results,
				"user" => $user,
				"pageLinks" => $this->pagination->create_links()
			)
		);
	}
	public function post(){
		if (!isset($_SESSION["user"])){//尚未登入時轉到登入頁
			redirect(site_url("/user/login")); //轉回登入頁
			return true;
		}
		$this->load->view('article_post',Array(
			"pageTitle" => "發文系統 - 發表文章"
		));	
	}
	public function posting(){
		if (!isset($_SESSION["user"])){//尚未登入時轉到登入頁
			redirect(site_url("/user/login")); //轉回登入頁
			return true;
		}
		$title = trim($this->input->post("title"));
		$content= trim($this->input->post("content"));
		
		if( $title =="" || $content =="" ){
			$this->load->view('article_post',Array(
				"pageTitle" => "發文系統 - 發表文章",
				"errorMessage" => "Title or Content shouldn't be empty,please check!" ,
				"title" => $title,
				"content" => $content
			));
			return false;
		}
		$this->load->model("ArticleModel");
		$insertID = $this->ArticleModel->insert($_SESSION["user"]->UserID,$title,$content);  //完成新增動作
		redirect(site_url("article/postSuccess/".$insertID));
	}	
	public function postSuccess($articleID){
		$this->load->view('article_success',Array(
				"pageTitle" => "發文系統 - 文章發表成功",
				"articleID" => $articleID
		));
	}
	public function view($articleID = null){
		if($articleID == null){
		show_404("Article not found !");
		return true;
		}
		
		$this->load->model("ArticleModel");
		//完成取資料動作
		$article = $this->ArticleModel->get($articleID);
		if($article == null){
		show_404("Article not found !");
		return true;
		}
		
		//更新文章計數
		$this->ArticleModel->updateViews($articleID,$article->Views +1 );
		
		$this->load->view('article_view',Array(
		//設定網頁標題
		"pageTitle" => "發文系統 - 文章 [".$article->Title."] ",
		"article" => $article
		));
	}
	public function edit($articleID = null){
		if (!isset($_SESSION["user"]) || $_SESSION["user"] == null ){
		//沒有登入的，直接送他去登入。
		redirect(site_url("/user/login"));
		return true;
		}
		
		if ( $articleID == null){
		show_404("Article not found !");
		return true;
		}
		
		$this->load->model("ArticleModel");
		//完成取資料動作
		$article = $this->ArticleModel->get($articleID);
		
		if ($article->Author != $_SESSION["user"]->UserID ){
		show_404("Article not found !");
		//不是作者又想編輯，顯然是來亂的，送他回首頁。
		redirect(site_url("/"));
		return true;
		}
		
		$this->load->view('article_edit',Array(
		"pageTitle" => "修改文章 [".$article->Title."]",
		"article" => $article
		));
		}
		public function update(){
			$articleID = $this->input->post("articleID");
		
			//就算是進行更新動作，該做的檢查還是都不能少
			if (!isset($_SESSION["user"]) || $_SESSION["user"] == null ){
				//沒有登入的，直接送他去登入。
				redirect(site_url("/user/login")); 
				return true;
			}		
		
			if ( $articleID == null){
				show_404("Article not found !");
				return true;
			}
		
			$this->load->model("ArticleModel");
			//完成取資料動作
			$article = $this->ArticleModel->get($articleID);  
		
			if ($article->Author != $_SESSION["user"]->UserID ){
				show_404("Article not found !");
				//不是作者又想編輯，顯然是來亂的，送他回首頁。
				redirect(site_url("/")); 
				return true;
			}
		
			$this->ArticleModel->updateArticle(
				$articleID,
				$this->input->post("title"),
				$this->input->post("content")
			);
		
			//更新完後送他回文章檢視頁面
			redirect(site_url("article/view/".$articleID));
		}
		public function del($articleID = null){
			//就算是進行更新動作，該做的檢查還是都不能少
			if (!isset($_SESSION["user"]) || $_SESSION["user"] == null ){
			//沒有登入的，直接送他去登入。
			redirect(site_url("/user/login"));
			return true;
			}
			
			if ( $articleID == null){
			show_404("Article not found !");
			return true;
			}
			
			$this->load->model("ArticleModel");
			//完成取資料動作
			$article = $this->ArticleModel->get($articleID);
			
			if ($article->Author != $_SESSION["user"]->UserID ){
			show_404("Article not found !");
			//不是作者又想編輯，顯然是來亂的，送他回首頁。
			redirect(site_url("/"));
			return true;
			}
			
			$this->ArticleModel->del(
			$articleID
			);
			
			//更新完後送他回個人文章頁面
			redirect(site_url("article/author/".$_SESSION["user"]->Account));
			}
}