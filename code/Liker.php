<?php
ob_start();
session_start();

class Liker {
    
    private $pdo ;
    public $posts,
            $posts_info,
            $num_of_fans,
            $fans_name    ;      
        
    
    public function __construct(){
        
    $this->pdo = new PDO ("mysql:host=127.0.0.1;dbname=test","root","");
         
    }

    public function fetchPosts(){
        
        $this->posts = $this->pdo->query("select * from posts");
        $this->posts_info = array();
        ?>
        <div class="row text-center" id="posts">
        <?php
        while($data = $this->posts->fetchObject()):
        ?> 
        <div class="col-sm-12 text-center">
        <h1 class="text-center"><?=$data->title?></h1>
    <!--like-->
    
    <a href="#" action="like" post="<?=$data->id?>" class="btn btn-default like text-center action">
    <i class="fas fa-heart"></i> <code>
    <?php echo $this->posts_info ['likes']= $this->fans("likes",$data->id);?>
      </code>
   </a>
        <a href="#" class="btn btn-success btn-md"  data-toggle="modal" data-target="#myModal-like-<?php echo $data->id;?>">likers</a> 
         
         <div id="myModal-like-<?php echo $data->id;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Likers</h4>
      </div>
      <div class="modal-body">
      <div class="liker"><?php $this->fan_name("likes","liker",$data->id);?></div>
          
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
         
         
          <br>
          <br>
   <!--dislike-->
   <a href="#" action="dislike" post="<?=$data->id?>" class="btn btn-default dislike action"> 
    <i class="fas fa-angry"></i>  
    <code>
<?php echo $this->posts_info ['dislikes'] = $this->fans("dislikes",$data->id);?>
  </code>
   
    </a>
      
        <a   data-toggle="modal" data-target="#myModal-dislikes-<?php echo $data->id;?>" href="#" class="btn btn-success btn-sm">dislikers</a>
        <div id="myModal-dislikes-<?php echo $data->id;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">dislikers</h4>
      </div>
      <div class="modal-body">
         <?php $this->fan_name("dislikes","disliker",$data->id);?>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
        
              
     <?php
    ?>
               </div>

       <?php
        endwhile;
    ?>
    </div>
    <?php
        
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


    public function fan_name($table,$join,$post_id){
        
         $fan_id = $table. '.' .$join;
        $this->fans_name = $this->pdo->query("SELECT $fan_id,users.username from $table LEFT JOIN users ON $fan_id = users.id where post_id = $post_id");
        
       ?>
       <ul>
       <?php
        while($data = $this->fans_name->fetchObject()){
         ?><li><?php echo $data->username?></li>
        <?php
        }
    ?>
    </ul>
    <?php
    
        
    }

}

    $liker = new Liker();
if(isset($_GET['action'],$_GET['post'])){
    
    
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
