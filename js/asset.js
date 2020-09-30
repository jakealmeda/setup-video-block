(function($) {


	// Append VIMEO to DIV
	function VIMEO_AppendVideo( yt_ids, box_counter ) {
	    
	    $( 'div#vimeo___' + yt_ids + '___' + box_counter )
	        .append( '<div class="video-iframe">' +
	        			'<iframe src="https://player.vimeo.com/video/' + yt_ids + '?autoplay=1&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>' +
	                 '</div><script src="https://player.vimeo.com/api/player.js"></script>' );
	    
	}


	// Append YOUTUBE to DIV
	function YOUTUBE_AppendVideo( yt_ids, box_counter ) {

	    $( 'div#' + yt_ids + '___' + box_counter )
	        .append( '<div class="video-iframe">' +
	                    '<iframe width="420" height="315" id="video_iframe" src="https://www.youtube.com/embed/' + yt_ids + '?autoplay=1" frameborder="0" allowfullscreen></iframe>' +
	                 '</div>' );

	}


	/*********************************************************
	 * VIMEO
	 ********************************************************/
	$( 'div.module-video-vimeo' ).each( function (){

		var ModuleID = this.id,
			VideoID = ModuleID.split( "___" ),
			yt_id = VideoID[ 1 ],
			box_counter = VideoID[ 2 ];
		
		/* ------------------------
		 * | PLAY BUTTON
		 * --------------------- */
		$( '#vimeo_play___' + yt_id + '___' + box_counter ).on( 'click', function() {

		    // hide play button and thumbnail div
		    HideThisDiv( '#vimeo_image___' + yt_id + '___' + box_counter );
		    
		    // append video
		    VIMEO_AppendVideo( yt_id, box_counter );

		});

		/* ------------------------
		 * | THUMBNAIL
		 * --------------------- */
		$( '#vimeo_thumb___' + yt_id + '___' + box_counter ).on( 'click', function() {
		    
		    // hide play button and thumbnail div
		    HideThisDiv( '#vimeo_image___' + yt_id + '___' + box_counter );

		    // append video
		    VIMEO_AppendVideo( yt_id, box_counter );

		});

	}); // end of VIMEO select


	/*********************************************************
	 * YOUTUBE
	 ********************************************************/
	$( 'div.module-video' ).each( function() {
    
	    var ModuleID = this.id,
	    	VideoID = ModuleID.split( "___" ),
	    	yt_id = VideoID[ 0 ],
	    	box_counter = VideoID[ 1 ];

	    /* ------------------------
	     * | PLAY BUTTON
	     * --------------------- */
	    $( '#video_play___' + yt_id + '___' + box_counter ).on( 'click', function() {

	        // hide play button and thumbnail div
	        HideThisDiv( '#video_image___' + yt_id + '___' + box_counter );
	        
	        // append video
	        YOUTUBE_AppendVideo( yt_id, box_counter );

	    });
	    
	    /* ------------------------
	     * | THUMBNAIL
	     * --------------------- */
	    $( '#thumbnail___' + yt_id + '___' + box_counter ).on( 'click', function() {
	        
	        // hide play button and thumbnail div
	        HideThisDiv( '#video_image___' + yt_id + '___' + box_counter );
	        
	        // append video
	        YOUTUBE_AppendVideo( yt_id, box_counter );
	    
	    });
	    
	}); // end of YOUTUBE select


	// Hide Element
	function HideThisDiv( ThisElement ) {

	    $( ThisElement ).hide();

	}

})( jQuery );