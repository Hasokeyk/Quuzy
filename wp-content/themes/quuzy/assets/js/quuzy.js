jQuery(function($){
    
    
    //HOME PAGE VIDEO PLAY
    $(document).on('click', '.post.video.play', function(){
        
        var shortcode = $(this).data('shortcode');
        var postImg = $(this);
        $(this).removeClass('play');
        $('video').each(function(){
            $(this).get(0).pause();
        });
        
        $.getJSON('https://www.instagram.com/p/'+shortcode+'?__a=1', function(post){
            
            var videoUrl = post.graphql.shortcode_media.video_url;
            $(' .post-img', postImg).html('<video autoplay type="video/mp4" src="'+videoUrl+'" controls="true"></video>');
            
        })
        
    })
    //HOME PAGE VIDEO PLAY
    
});