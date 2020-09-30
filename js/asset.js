(function($) {


	// Append VIMEO to DIV
	function VIMEO_AppendVideo( ThisType, VideoID, box_counter ) {
	    
	    $( 'div#videoblock__' + ThisType + '___' + VideoID + '___' + box_counter )
	        .append( '<div class="video-iframe" style="position:relative;padding-bottom: 56.25%;height:0;">' +
	        			'<iframe src="https://player.vimeo.com/video/' + VideoID + '?autoplay=1&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>' +
	                 '</div><script src="https://player.vimeo.com/api/player.js"></script>' );
	    
	}
	

	// Append YOUTUBE to DIV
	function YOUTUBE_AppendVideo( ThisType, VideoID, box_counter ) {
		
	    $( 'div#videoblock__' + ThisType + '___' + VideoID + '___' + box_counter )
	        .append( '<div class="video-iframe" style="position:relative;padding-bottom: 56.25%;height:0;">' +
	                    '<iframe width="420" height="315" id="video_iframe" src="https://www.youtube.com/embed/' + VideoID + '?autoplay=1" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allowfullscreen></iframe>' +
	                 '</div>' );

	}


	/*********************************************************
	 * LISTEN TO ANY VIDEO PLAY CLICKS
	 ********************************************************/
	$( "[id^=videoblock__]" ).each( function () {

		var ModuleID = this.id,
			ContainerID = ModuleID.split( "___" ),
			GetType = ContainerID[ 0 ],					// contains YouTube or Vimeo
			VideoID = ContainerID[ 1 ],
			box_counter = ContainerID[ 2 ],
			SplitType = GetType.split( "__" ),
			ThisType = SplitType[ 1 ];					// contains either Youtube or Vimeo
		
		/* ------------------------
		 * | PLAY BUTTON
		 * --------------------- */
		$( '#video_play___' + VideoID + '___' + box_counter ).on( 'click', function() {
			
		    // hide play button and thumbnail div
		    HideThisDiv( VideoID, box_counter );
		    
		    // append YOUTUBE video
		    if( ThisType == 'youtube' ) {
		    	YOUTUBE_AppendVideo( ThisType, VideoID, box_counter );
		    }

		    // append VIMEO video
		    if( ThisType == 'vimeo' ) {
		    	VIMEO_AppendVideo( ThisType, VideoID, box_counter );
		    }

		});

		/* ------------------------
		 * | THUMBNAIL
		 * --------------------- */
		$( '#video_image___' + VideoID + '___' + box_counter ).on( 'click', function() {
		    
		    // hide play button and thumbnail div
		    HideThisDiv( VideoID, box_counter );

		    // append YOUTUBE video
		    if( ThisType == 'youtube' ) {
		    	YOUTUBE_AppendVideo( ThisType, VideoID, box_counter );
		    }

		    // append VIMEO video
		    if( ThisType == 'vimeo' ) {
		    	VIMEO_AppendVideo( ThisType, VideoID, box_counter );
		    }

		});

	}); // end of VIMEO select


	/*********************************************************
	 * YOUTUBE
	 ********************************************************/
	/*$( 'div.module-video' ).each( function() {
    
	    var ModuleID = this.id,
	    	VideoID = ModuleID.split( "___" ),
	    	yt_id = VideoID[ 0 ],
	    	box_counter = VideoID[ 1 ];

	    / * ------------------------
	     * | PLAY BUTTON
	     * --------------------- * /
	    $( '#video_play___' + yt_id + '___' + box_counter ).on( 'click', function() {

	        // hide play button and thumbnail div
	        HideThisDiv( '#video_image___' + yt_id + '___' + box_counter );
	        
	        // append video
	        YOUTUBE_AppendVideo( yt_id, box_counter );

	    });
	    
	    / * ------------------------
	     * | THUMBNAIL
	     * --------------------- * /
	    $( '#thumbnail___' + yt_id + '___' + box_counter ).on( 'click', function() {
	        
	        // hide play button and thumbnail div
	        HideThisDiv( '#video_image___' + yt_id + '___' + box_counter );
	        
	        // append video
	        YOUTUBE_AppendVideo( yt_id, box_counter );
	    
	    });
	    
	}); // end of YOUTUBE select
	*/

	// Hide Element
	function HideThisDiv( VideoID, box_counter ) {

	    $( '#video_image___' + VideoID + '___' + box_counter ).hide();
	    $( '#video_play___' + VideoID + '___' + box_counter ).hide();

	}

})( jQuery );