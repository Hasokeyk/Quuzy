jQuery(function($){

    var url = location.pathname;
    var username = url.replace('-user','').replace(/\//g,'');
    var userData;
    
    if(localStorage.getItem(username)){
        userData = localStorage.getItem(username);
        renderUserPage(userData);
    }else{
        getInstaUser(username).then(data => {
            if(typeof data == 'object'){
                userData = JSON.stringify(data);
                localStorage.setItem(username,userData);
                renderUserPage(userData);
            }else{
                return false;
            }
        });
    }
    
    function renderUserPage(json){
    
        console.log(json);
        
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
        return await $.getJSON(API,function(data){
            return data;
        }).fail(err => {
            return false;
        });
    }
})