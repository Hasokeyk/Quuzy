jQuery(function($){
    
    var url = location.pathname;
    var username = url.replace('-user','').replace(/\//g,'');
    var userData;
    
    if(localStorage.getItem(username)){
        userData = localStorage.getItem(username);
        renderUserPage(userData);
    }else{
        try{
            getInstaUser(username).then(data => {
                if(typeof data == 'object'){
                    userData = JSON.stringify(data);
                    localStorage.setItem(username,userData);
                    renderUserPage(userData);
                }else{
                    $('.container-404 .text').html('Sorry. User Not Found.');
                    return false;
                }
            });
        }catch(err){
            console.log(3,err)
        }
        
    }
    
    function renderUserPage(json){
        
        var data = {
            'action': 'user_render',
            'data': json
        };
        
        jQuery.post('/wp-content/themes/quuzy/templates/quuzy-user-render-page.php', data, function(response) {
            document.body.classList.add('single-quuzy_users');
            document.body.innerHTML = response;
    
            jQuery.post('/wp-content/themes/quuzy/inc/userSave.php', data, function(response) {
                console.log(response)
            });
            
        });
    
    }
    
    async function getInstaUser(username){
        var API = 'https://www.instagram.com/'+username+'/?__a=1';
        return fetch(API).then(data => {
            if(data.status == 200){
                return data.json().then(function (post) {
                    return post;
                })
            }else{
                return false;
            }
        }).catch(err => {
            console.log(err);
        })
        /*
        return await $.getJSON(API,function(data){
            return data;
        }).fail(err => {
            return false;
        });
        */
    }
    
    var count = 1;
    
    setTimeout(function(){
        $('.container-404 .text .counter').text(count);
        count++;
        console.log(count)
    },1000)
})