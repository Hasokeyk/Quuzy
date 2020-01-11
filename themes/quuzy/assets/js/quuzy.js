jQuery(function($){

    var username = $('body').data('username');
    var pageType = $('body').data('page-type');

    //404 SAYFASI ÜYE KONTROL
    if(pageType == '404' && username != '' && username != 'quuzy'){

        $('.big-text').html('(<span class="counter">1</span>) Please Wait... Loading Profile..');

        var i = 1;
        setInterval(function () {
            $('.big-text .counter').text(i++);
        },1000)

        try {
            $.getJSON('https://www.instagram.com/'+username+'/?__a=1',function(user){
                $.post('/ajax/user',{user:JSON.stringify(user),type:'link',action:'userSave'},function(userInfo){
                    var json = JSON.parse(userInfo);
                    if(json.status == 'success'){
                        location.reload();
                    }
                })
            })
        } catch (error) {
            console.log('user not found');
        }
    }
    //404 SAYFASI ÜYE KONTROL

    //PROFİLE DETAY
    if(pageType == 'profile-detail' && username != '' && username != 'quuzy'){
        try {
            $.getJSON('https://www.instagram.com/'+username+'/?__a=1',function(user){
                
                
                //<div class="post" style="position: absolute; left: 0px; top: 0px;">
                //    <img src="https://instagram.fist4-1.fna.fbcdn.net/vp/f40cf01784f9b925b2b9894dd3330863/5E64A948/t51.2885-15/e35/71288560_1252681604910784_7379414989271924314_n.jpg?_nc_ht=instagram.fist4-1.fna.fbcdn.net&amp;_nc_cat=104" alt="Geleceğim için aldığım en güzel doğum günü hediyesi 😍😍😍😍">
                //</div>

                $('.profile-circle img').attr('src',user.graphql.user.profile_pic_url_hd);

                $.post('/ajax/user',{user:JSON.stringify(user),type:'link',action:'userPostSave'},function(userInfo){
                    var json = JSON.parse(userInfo);
                    if(json.status == 'success'){
                        //location.reload();
                    }
                })
            })
        } catch (error) {
            console.log('user not found');
        }

    }
    //PROFİLE DETAY

    //ANA SAYFA
    if($('body').filter('[data-page-type="home"]')){

        $('.last-user-profiles .users a').each(function (i,e) {

            var img = $(e);
            const regex = /instagram\/(.*)/gm;
            var href = $(e).attr('href');
            var username = regex.exec(href);

            $.getJSON('https://www.instagram.com/'+username[1]+'/?__a=1',function(user){
                $('.last-user-profiles .users a:eq('+i+') img').attr('src',user.graphql.user.profile_pic_url_hd);

                //$.post('/ajax/user',{user:JSON.stringify(user),type:'link',action:'userPostSave'},function(userInfo){
                //    var json = JSON.parse(userInfo);
                //    if(json.status == 'success'){
                //        //location.reload();
                //    }
                //})
            })

        });

    }
    //ANA SAYFA

    //HOME PAGE VIDEO PLAY
    $(document).on('click','.post.video.play',function () {

        var shortcode = $(this).data('shortcode');
        var postImg = $(this);
        $(this).removeClass('play');
        $('video').each(function() {
            $(this).get(0).pause();
        });

        $.getJSON('https://www.instagram.com/p/'+shortcode+'/?__a=1',function(post){

            var videoUrl = post.graphql.shortcode_media.video_url;
            $(' .post-img',postImg).html('<video autoplay type="video/mp4" src="'+videoUrl+'" controls="true"></video>');

        })

    })
    //HOME PAGE VIDEO PLAY
});