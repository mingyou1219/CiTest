<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ArticleModel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    function insert($author,$title,$content){
        $this->db->insert("article", 
            Array(
            "Author" =>  $author,
            "Title" => $title,
            "Content" => $content,
            "Views" => 0,
        ));     
        return $this->db->insert_id() ;
    }    
    function get($articleID){
        $this->db->select("article.*,user.account");
        $this->db->from('article');
        $this->db->join('user', 'article.author = user.userID', 'left');
        $this->db->where(Array("articleID" => $articleID));
        $query = $this->db->get();
        if ($query->num_rows() <= 0){
            return null; //無資料時回傳 null
        }
        return $query->row();  //回傳第一筆
    }
    
    function countArticlesByUserID($userID){
        $this->db->select("count(articleID) as ArticleCount");
        $this->db->from('article');
        $this->db->where(Array("author" => $userID));
        $query = $this->db->get();
        
        if ($query->num_rows() <= 0){
        return null; //無資料時回傳 null
        }
        return $query->row()->ArticleCount;
        }
    function getArticlesByUserID($userID,$offset = 0,$pageSize = 20){
        $this->db->select("article.*,user.Account");
        $this->db->from('article');
        $this->db->join('user', 'article.author = user.userID', 'left');
        $this->db->where(Array("author" => $userID));
        $this->db->limit($pageSize,$offset);
        $this->db->order_by("ArticleID","desc");//由大到小排序
        $query = $this->db->get();
        
        return $query->result(); //無資料時回傳 null
    }
    function updateArticle($id,$title,$content){
        $data = array(
        'Title' => $title,
        'Content' => $content
        );
        
        $this->db->where('ArticleID', $id);
        $this->db->update('article', $data);
    }
    function del($id){
        $this->db->delete('article', array('ArticleID' => $id));
    }
    function updateViews($articleID,$views){
        $data = array(
        'views' => $views,
        );
        
        $this->db->where('ArticleID', $articleID);
        $this->db->update('article', $data);
    }
    function getHotArticles($count = 5){
        $this->db->select("article.*,user.Account");
        $this->db->from('article');
        $this->db->join('user', 'article.author = user.userID', 'left');
        $this->db->limit($count, 0);//offset = 0
        $this->db->order_by("Views","desc");//由大到小排序
        $query = $this->db->get();
        
        return $query->result();
        }
        
        function getHotAuthors($count = 5){
        $this->db->select("user.*,max(views) as Views");
        $this->db->from('article');
        $this->db->join('user', 'article.author = user.userID', 'left');
        $this->db->limit($count, 0);//offset = 0
        $this->db->group_by("author");
        
        //根據該作者所有文章裡面，
        //由最大的 views 進行大到小排序
        $this->db->order_by("max(Views) desc");
        $query = $this->db->get();
        
        return $query->result();
        }
}