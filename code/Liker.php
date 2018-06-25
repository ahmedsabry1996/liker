<?php
ob_start();
session_start();

class Liker {
    
    private $pdo ;
    public $posts,
            $posts_info,
           $num_of_fans;      
        
    
    public function __construct(){
        
    $this->pdo = new PDO ("mysql:host=127.0.0.1;dbname=test","root","");
         
    }

    public function fetchPosts(){
        
        $this->posts = $this->pdo->query("select * from posts");
        $this->posts_info = array();
        while($data = $this->posts->fetchObject()):
        ?>
    <h1 class="text-center">
        <?=$data->title?>
    </h1>
    <a href="#" action="like" post="<?=$data->id?>" class="btn btn-default like ">
    <i class="fas fa-heart"></i> <code>
<?php echo $this->posts_info ['likes']= $this->fans("likes",$data->id);?>
      </code>
   
   </a>
    <a href="#" action="dislike" post="<?=$data->id?>" class="btn btn-default dislike"> 
    <i class="fas fa-angry"></i>  
    <code>
<?php echo $this->posts_info ['dislikes'] = $this->fans("dislikes",$data->id);?>
  </code>
  
    </a>
    <?php
        endwhile;
        }
    
    public function like($post_id,$user_id){
        
        $check_liked = $this->pdo->query("select * from likes where post_id = '{$post_id}' and liker = '{$user_id}'");
        
        
        echo $results = $check_liked->rowCount();
        
        if($results == 1){
            
            $delete_liked = $this->pdo->query("delete from likes where post_id = '{$post_id}' and liker = '{$user_id}'");
            
            $delete_disliked = $this->pdo->query("delete from dislikes where post_id = '{$post_id}' and disliker = '{$user_id}'");
            
            if($delete_liked && $delete_disliked){
                
                 echo "back like";
            
            }
        }
        
        else{
            $new_like = $this->pdo->query("insert into likes values ('{$post_id}',{$user_id})");
            $delete_disliked = $this->pdo->query("delete from dislikes where post_id = '{$post_id}' and disliker = '{$user_id}'");
            if($new_like && $delete_disliked){

                echo "liked!";
            }
        }
         
    
    }
    
    public function dislike($post_id,$user_id){
            
        $check_disliked = $this->pdo->query("select * from dislikes where post_id = '{$post_id}' and disliker = '{$user_id}'");
        
        
        $results = $check_disliked->rowCount();
        
        if($results == 1){
            
            $delete_disliked = $this->pdo->query("delete from dislikes where post_id = '{$post_id}' and disliker = '{$user_id}'");
            
            
            $delete_liked = $this->pdo->query("delete from likes where post_id = '{$post_id}' and liker = '{$user_id}'");
            
            if($delete_liked && $delete_disliked){
                
                echo "back disliked";
            
            }

        }
        
        else{
            $new_dislike = $this->pdo->query("insert into dislikes values ('{$post_id}','{$user_id}')");
            
            $delete_liked = $this->pdo->query("delete from likes where post_id = '{$post_id}' and liker = '{$user_id}'");
            
            if($new_dislike && $delete_liked){
                echo "disliked";
            }
            
        }
        
    
        
    }
    
    public function fans($table,$post_id){
        $all_reactions = $this->pdo->query("select * from $table where post_id = '{$post_id}'");
        
      echo  $this->num_of_fans= $all_reactions->rowCount();
    }
}

if(isset($_GET['action'],$_GET['post'])){
    
    $liker = new Liker();
    
    $post_id = $_GET['post'];
    $user_id = $_SESSION['user_id'];
    
    if($_GET['action'] == "like"){
        
        $liker->like($post_id,$user_id);
    }
    
    if($_GET['action'] == "dislike"){
        
        $liker->dislike($post_id,$user_id);
    }
}

?>
