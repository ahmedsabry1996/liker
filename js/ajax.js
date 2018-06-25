$(function(){

$("a.btn").click(function(){
   
    let post = $(this).attr("post");
    let action = $(this).attr("action");
    
    let numOfFans =$(this).children("code").text();
       
            setTimeout(reload,1000);
        function reload(){
           $('#posts').load('#posts', function() {
        console.log('done');
      });
        }
    console.log(numOfFans,action);
    let url = `http://localhost/oop_apps/Liker/code/Liker.php?action=${action}&post=${post}`;

    $.ajax({
        url:url,
        type:"Get",
        success:function(data){
        console.log(data);

        },
        fail:function(err){
            console.log(err)
        }
        
        
    })
    
});
});