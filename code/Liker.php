<?php
ob_start();
session_start();

class Liker {
    
    private $pdo ;
    public $posts ;

    
    public function __construct(){
        
    $this->pdo = new PDO ("mysql:host=127.0.0.1;dbname=test","root","");
         
    }

    public function fetchPosts(){
        
        $this->posts = $this->pdo->query("select * from posts");
        
        while($data = $this->posts->fetchObject()):
        ?>
        <h1 class="text-center"><?=$data->title?></h1>
        <a href="#" action="like" post="<?=$data->id?>" class="btn btn-info like ">like</a>
        <a href="#" action="dislike"post="<?=$data->id?>" class="btn btn-danger dislike">dislike</a>
        <?php
        endwhile;
    }
    
    public function like($post_id,$username){
        
        $check_liked = $this->pdo->query("select * from likes where post_id = '{$post_id}' and liker = '{$username}'");
        
        
        $results = $check_liked->rowCount();
        
        if($results == 1){
            
            $delete_liked = $this->pdo->query("delete from likes where post_id = '{$post_id}' and liker = '{$username}'");
            
            $delete_disliked = $this->pdo->query("delete from dislikes where post_id = '{$post_id}' and disliker = '{$username}'");
            
            if($delete_liked && $delete_disliked){
                
                echo "back like";
            
            }
        }
        
        else{
            $new_like = $this->pdo->query("insert into likes values ('{$post_id}','{$username}')");
            
            $delete_disliked = $this->pdo->query("delete from dislikes where post_id = '{$post_id}' and disliker = '{$username}'");
            
            if($new_like && $delete_disliked){
                echo "liked!";
            }
        }
         
    
    }
    
    public function dislike($post_id,$username){
            
        $check_disliked = $this->pdo->query("select * from dislikes where post_id = '{$post_id}' and disliker = '{$username}'");
        
        
        $results = $check_disliked->rowCount();
        
        if($results == 1){
            
            $delete_disliked = $this->pdo->query("delete from dislikes where post_id = '{$post_id}' and disliker = '{$username}'");
            
            
            $delete_liked = $this->pdo->query("delete from likes where post_id = '{$post_id}' and liker = '{$username}'");
            
            if($delete_liked && $delete_disliked){
                
                echo "back disliked";
            
            }

        }
        
        else{
            $new_dislike = $this->pdo->query("insert into dislikes values ('{$post_id}','{$username}')");
            
            $delete_liked = $this->pdo->query("delete from likes where post_id = '{$post_id}' and liker = '{$username}'");
            
            if($new_dislike && $delete_liked){
                echo "disliked";
            }
            
        }
        
    
        
    }
    
}

if(isset($_GET['action'],$_GET['post'])){
    
    $liker = new Liker();
    
    $post_id = $_GET['post'];
    $username = $_SESSION['username'];
    
    if($_GET['action'] == "like"){
        
        $liker->like($post_id,$username);
    }
    
    if($_GET['action'] == "dislike"){
        
        $liker->dislike($post_id,$username);
    }
    
}
?>