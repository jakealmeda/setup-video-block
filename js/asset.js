(function($) {

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
		    AppendVideo( yt_id );

		});

		/* ------------------------
		 * | THUMBNAIL
		 * --------------------- */
		$( '#vimeo_thumb_' + yt_id ).on( 'click', function() {
		    
		    // hide play button and thumbnail div
		    HideThisDiv( '#vimeo_image_' + yt_id );

		    // append video
		    AppendVideo( yt_id );

		});

	});

	// Hide Element
	function HideThisDiv( ThisElement ) {

	    $( ThisElement ).hide();

	}

	// Append Video to DIV
	function AppendVideo( yt_ids ) {
	    
	    $( 'div#vimeo_' + yt_ids )
	        .append( '<div style="padding:56.25% 0 0 0;position:relative;">' +
	        			'<iframe src="https://player.vimeo.com/video/' + yt_ids + '?autoplay=1&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>' +
	                 '</div><script src="https://player.vimeo.com/api/player.js"></script>' );
	    
	}

})( jQuery );