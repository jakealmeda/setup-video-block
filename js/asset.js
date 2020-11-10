(function($) {

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
		 * | THUMBNAIL
		 * --------------------- */
		$( '#video_image___' + VideoID + '___' + box_counter ).on( 'click', function() {
		    
		    // hide play button and thumbnail div
		    $( this ).hide();

		    // append YOUTUBE video
		    if( ThisType == 'youtube' ) {

		    	// cancatenate here - doing so in the append command below creates an error on the console
		    	var YT_url = 'https://www.youtube.com/embed/' + VideoID + '?autoplay=1';
		    	
				$( '#videoblock__' + ThisType + '___' + VideoID + '___' + box_counter )
			        .append( '<div class="video-iframe" style="position:relative;padding-bottom: 56.25%;height:0;background-color:#333;">' +
			                    '<iframe width="420" height="315" id="video_iframe" src="' + YT_url + '" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allowfullscreen></iframe>' +
			                 '</div>' );

		    }

		    // append VIMEO video
		    if( ThisType == 'vimeo' ) {

		    	// cancatenate here - doing so in the append command below creates an error on the console
		    	var VM_url = 'https://player.vimeo.com/video/' + VideoID + '?autoplay=1&portrait=0';

		    	$( 'div#videoblock__' + ThisType + '___' + VideoID + '___' + box_counter )
			        .append( '<div class="video-iframe" style="position:relative;padding-bottom: 56.25%;height:0;background-color:#333;">' +
			        			'<iframe src="' + VM_url + '" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>' +
			                 '</div><script src="https://player.vimeo.com/api/player.js"><\/script>' );
			        
		    }
		    
		});

	});

})( jQuery );