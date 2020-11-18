var isFetching = false;
var emptyCounter=0;
var retryLimit = 2;
//listen for scrolling bar
//document is website height
//window is our desktop screen
if(("#posts-wrapper").length>0){
    $(window).scroll(function(e){
        let scrollTop = $(window).scrollTop();
        let windowHeight = $(window).height();
        let documentHeight = $(document).height();
        let heightDiff = documentHeight-windowHeight;
        
        heightDiff = heightDiff - 100;
       if(scrollTop >= heightDiff){
           if(emptyCounter<retryLimit){
                console.log("at the bottom");
                let last_id = $(".post-card").last().data("id");
                fetchPosts(last_id);
           }
        }
    });

}

//php compare with waiters called asynchronous
function fetchPosts(last_id){
    if(isFetching){
        console.log("previus request is nt donw yet");
        return;
    }
    isFetching = true;
    $("#loader").css("display","block");
    console.log(" fetchposts called");
    var jqxhr = $.get("posts_api.php?last_id=" + last_id);//kitchen
        jqxhr.done(function(response){//get data
            //call renderPosts to display posts on UI
            if(response && response.length>0){
                renderPosts(response);
            }else{
                emptyCounter++;
            }
            // console.log(response);
            // console.log("request done");
        });
        jqxhr.fail(function(){
            console.log("Something went wrong.");
        });
        jqxhr.always(function(){
            isFetching = false;
            $("#loader").css("display","none");
        });
    }



    function renderPosts(posts){
        console.log("render called");
        var postWrapper = document.querySelector("#posts-wrapper");
        for(var i = 0;i < posts.length;i++){

            var template = document.querySelector('#card_tpl');
            //Clone the new row and insert it into the table
            var clone = template.content.cloneNode(true);//to clone the card and add new content and add again and again
            //console.log(clone.querySelector(".card"));
            clone.querySelector(".card").setAttribute("data-id",posts[i].id);
            clone.querySelector(".card-title a").textContent = posts[i].name;
            clone.querySelector(".card-title a").setAttribute("href","profile.php?profile_id="+posts[i].user_id);
           console.log(posts[i].user_id);
            if(loggedInID==posts[i].user_id){
                console.log("same");
            clone.querySelector(".actions").innerHTML = '<a onclick="return confirm(\'Are you sure to delete?\');"  class="delete-icon" href="delete.php?id='+posts[i].id+'"><i class="fas fa-times-circle"></i></a>';
           }
            clone.querySelector(".post-desc").textContent = posts[i].description;
            clone.querySelector(".card-photo").setAttribute("src","uploads/"+posts[i].photo);
            postWrapper.appendChild(clone);

            
        }
    }