(function($) {


	// Append VIMEO to DIV
	function VIMEO_AppendVideo( yt_ids ) {
	    
	    $( 'div#vimeo_' + yt_ids )
	        .append( '<div style="padding:56.25% 0 0 0;position:relative;background-color:red;">' +
	        			'<iframe src="https://player.vimeo.com/video/' + yt_ids + '?autoplay=1&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>' +
	                 '</div><script src="https://player.vimeo.com/api/player.js"></script>' );
	    
	}


	// Append YOUTUBE to DIV
	function YOUTUBE_AppendVideo( yt_ids ) {

	    $( 'div#' + yt_ids )
	        .append( '<div class="video-youtube"><div class="module-wrap">' +
	                    '<iframe width="420" height="315" id="video_iframe" src="https://www.youtube.com/embed/' + yt_ids + '?autoplay=1" frameborder="0" allowfullscreen></iframe>' +
	                 '</div></div>' );

	}


	/*********************************************************
	 * VIMEO
	 ********************************************************/
	$( 'div.module-video-vimeo' ).each( function (){

		var ModuleID = this.id,
			VideoID = ModuleID.split( "_" ),
			yt_id = VideoID[ 1 ];

		/* ------------------------
		 * | PLAY BUTTON
		 * --------------------- */
		$( '#vimeo_play_' + yt_id ).on( 'click', function() {

		    // hide play button and thumbnail div
		    HideThisDiv( '#vimeo_image_' + yt_id );
		    
		    // append video
		    VIMEO_AppendVideo( yt_id );

		});

		/* ------------------------
		 * | THUMBNAIL
		 * --------------------- */
		$( '#vimeo_thumb_' + yt_id ).on( 'click', function() {
		    
		    // hide play button and thumbnail div
		    HideThisDiv( '#vimeo_image_' + yt_id );

		    // append video
		    VIMEO_AppendVideo( yt_id );

		});

	}); // end of VIMEO select


	/*********************************************************
	 * YOUTUBE
	 ********************************************************/
	$( 'div.module-video' ).each( function() {
    
	    var yt_id = this.id;

	    /* ------------------------
	     * | PLAY BUTTON
	     * --------------------- */
	    $( '#video_play_' + yt_id ).on( 'click', function() {

	        // hide play button and thumbnail div
	        HideThisDiv( '#video_image_' + yt_id );
	        
	        // append video
	        YOUTUBE_AppendVideo( yt_id );

	    });
	    
	    /* ------------------------
	     * | THUMBNAIL
	     * --------------------- */
	    $( '#thumbnail_' + yt_id ).on( 'click', function() {
	        
	        // hide play button and thumbnail div
	        HideThisDiv( '#video_image_' + yt_id );

	        // append video
	        YOUTUBE_AppendVideo( yt_id );
	    
	    });
	    
	}); // end of YOUTUBE select


	// Hide Element
	function HideThisDiv( ThisElement ) {

	    $( ThisElement ).hide();

	}

})( jQuery );