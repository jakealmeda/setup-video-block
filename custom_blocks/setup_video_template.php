<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * SET GLOBAL COUNTER
 * THIS WILL BE USED TO MARK EACH VIDEO BLOCK USED
 *
 */
global $box_counter;
$box_counter++;


/**
 * SET GLOBAL HEIRARCHY
 * Control the display of videos if only youtube, then vimeo or show all
 *
 */
$video_default_var = get_field( "video_default" );


/**
 * CLASS SELECTORS
 * 
 */
$classes[] = 'module';
if( array_key_exists( 'className', $block ) ) {
    $classes = array_merge( $classes, explode( ' ', $block[ 'className' ] ) );
}


/**
 * MODULE OPENING
 * 
 */
echo '<div class="'.join( ' ', $classes ).'">';


	//$wp_title = get_the_title();


	/**
	 * CUSTOM FIELD | TITLE (ALT TITLE)
	 *
	 */
	$video_title = get_field( "video_title" );
	if( !empty( $video_title ) ) {

		?><div><?php
			echo $video_title;
		?></div><?php

	}


	/**
	 * CUSTOM FIELD | THUMBNAIL
	 *
	 */
	$video_thumbnail = get_field( "video_thumbnail" );
	if( !empty( $video_thumbnail ) ) {
		$video_thumbnail = $video_thumbnail;
	} else {
		$video_thumbnail = NULL;
	}
	$video_thumbnail_size = 'large';


	/**
	 * CUSTOM FIELD | TOGGLE
	 *
	 */
	$video_toggle = get_field( "video_toggle" );
	if( is_array( $video_toggle ) ) {

		// Empty the variable
		$video_default_youtube = "";

		foreach( $video_toggle as $toggle ) {
			
			// GET THE SELECTED FIELD
			$this_video = get_field( "video_".$toggle );


			// Display video
			$args = array(
				'type'					=> $toggle,
				'vid'					=> $this_video,
				'counter'				=> $box_counter,
				'thumb'					=> $video_thumbnail,
				'thumb_size'			=> $video_thumbnail_size,
			);
				
			// YOUTUBE
			// --------------------------------- *
			if( $toggle == 'youtube' ) {

				// VARIABLE FOR VIDEO DEFAULT
				$video_default_youtube = $this_video;

				// validate vimeo video id
				if( !empty( $this_video ) ) {
					
					// display video
					echo setup_embed_videos( $args );

				}

			}

			// VIMEO
			// --------------------------------- *
			if( $toggle == 'vimeo' ) {

				/*
					if enable - don't display if youtube is available
					if enable and youtube not available, show vimeo
					if disable, show all
				*/
				if( $video_default_var == 'enable' && empty( $video_default_youtube ) || $video_default_var == 'disable' ) {

					// validate vimeo video id
					if( !empty( $this_video ) ) {
						
						// add additional variable
						$args[ 'vimeo_thumb_size' ] = 'thumbnail_large';
						
						// display video
						echo setup_embed_videos( $args );

					}

				}

			}

			// VIDEO CPT (CONNECT)
			// --------------------------------- *
			if( $toggle == 'connect' ) {

				$cpt_id = $this_video; // this is an array
				
				if( is_array( $cpt_id ) ) {

					foreach( $cpt_id as $id ) {

						// VIDEO TOGGLE (custom field)
						$v_toggle = get_post_meta( $id, "video_toggle", TRUE );

						if( is_array( $v_toggle ) ) {

							foreach( $v_toggle as $tog ) {
								
								$v_vid = get_post_meta( $id, "video_".$tog, TRUE );
								
								// YOUTUBE
								if( $tog == 'youtube' ) {
									
									if( !empty( $v_vid ) ) {

										// display video
										echo setup_embed_videos( $args );

									}

								}

								// VIMEO
								if( $tog == 'vimeo' ) {
									
									// validate vimeo video id
									if( !empty( $v_vid ) ) {

										// add additional variable
										$args[ 'vimeo_thumb_size' ] = 'thumbnail_large';
										
										// display
										echo setup_embed_videos( $args );

									}

								}

							} // foreach( $v_toggle as $tog ) {

						}

					} // foreach( $cpt_id as $id ) {

				} // if( is_array( $cpt_id ) ) {

			}

			if( $toggle == 'rumble' ) {

				// output rumble video right away. no thumbnail first for it.
				?><div class="video-iframe" style="position:relative;padding-bottom: 56.25%;height:0;background-color:#333;"><?php
					echo '<iframe class="rumble" width="640" height="360" src="'.$this_video.'" frameborder="0" allowfullscreen></iframe>';
				?></div><?php

			}

		} // end of foreach( $video_toggle as $toggle ) {

	}


	/**
	 * CUSTOM FIELD | RELATED POSTS (Relationships)
	 *
	 */
	$rel_post = get_field( "video_related_post" );
	if( $rel_post ) {

		echo '<div><strong>Related Posts:</strong></div>';
		if( is_array( $rel_post ) ) {

			foreach( $rel_post as $id ) {

				// display articles
				echo '<div><a href="'.get_the_permalink( $id ).'">'.get_the_title( $id ).'</a></div>';

			}

		}

	}


	/**
	 * CUSTOM FIELD | VIDEO SUMMARY
	 *
	 */
	$video_summary = get_field( "video_summary" );
	if( !empty( $video_summary ) ) {

		?><div><?php
			echo $video_summary;
		?></div><?php

	}


	/**
	 * INNERBLOCK
	 *
	 */
	echo '<div class="innerblock"><InnerBlocks /></div>';


/**
 * MODULE CLOSING
 * 
 */
echo '</div>';