$(function(){

$("a.btn").click(function(){
   
    let post = $(this).attr("post");
    let action = $(this).attr("action");
    
    const url = `http://localhost/oop_apps/Liker/code/Liker.php?action=${action}&post=${post}`;

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