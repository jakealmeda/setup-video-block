<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


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

		echo '<div><strong>Video (Alt) Title:</strong> '.$video_title.'</div>';

	}


	/**
	 * CUSTOM FIELD | THUMBNAIL
	 *
	 */
	$video_thumbnail = get_field( "video_thumbnail" );
	if( !empty( $video_thumbnail ) ) {

		echo '<div><strong>Video Thumbnail:</strong> ';
			echo wp_get_attachment_image( $video_thumbnail, 'thumbnail' );
		echo '</div>';

	}


	/**
	 * CUSTOM FIELD | TOGGLE
	 *
	 */
	$video_toggle = get_field( "video_toggle" );
	if( is_array( $video_toggle ) ) {

		foreach( $video_toggle as $toggle ) {

			$this_video = get_field( "video_".$toggle );
			if( !empty( $this_video ) ) {

				// Show the field (comment the line below if not needed)
				echo '<h2>'.strtoupper( $toggle ).'</h2>';

				/*
					// THUMBNAIL SIZES
					thumbnail_small
					thumbnail_medium
					thumbnail_large

					// DURATION
					duration
				*/

				// VIMEO
				// --------------------------------- *
				if( $toggle == 'vimeo' ) {
					
					// validate vimeo video id
					if( !empty( $this_video ) ) {
						echo '<strong>VIMEO Thumbnail</strong>';
						echo setup_pull_vimeo_video( $this_video, 'thumbnail_large' );
					}

				}
				
				// YOUTUBE
				// --------------------------------- *
				if( $toggle == 'youtube' ) {

					/*
					#########################################################################################
					# ADD CHECKER IF SETUP-YOUTUBE IS ACTIVATED, ADD CODES TO HANDLE DISPLAY IF MISSING
					#########################################################################################
					*/

					echo do_shortcode( '[su_youtube_advanced url="'.$this_video.'"][/su_youtube_advanced]' );

				}

				// VIDEO CPT (CONNECT)
				// --------------------------------- *
				if( $toggle == 'connect' ) {

					$cpt_id = $this_video; // this is an array
					
					if( is_array( $cpt_id ) ) {

						foreach( $cpt_id as $id ) {
							
							// VIDEO TITLE (custom field)
							$cf_video_title = get_post_meta( $id, "video_title", TRUE );
							if( !empty( $cf_video_title ) ) {

								// SHOW ALT TITLE
								echo '<h3>'.$cf_video_title.'</h3>';

							} else {

								// SHOW WP NATIVE TITLE
								echo '<h3>'.get_the_title( $id ).'</h3>';

							}

							// VIDEO TOGGLE (custom field)
							$v_toggle = get_post_meta( $id, "video_toggle", TRUE );
							if( is_array( $v_toggle ) ) {

								foreach( $v_toggle as $tog ) {
									
									$v_vid = get_post_meta( $id, "video_".$tog, TRUE );

									// VIMEO
									if( $tog == 'vimeo' ) {
										
										// validate vimeo video id
										if( !empty( $v_vid ) ) {

											echo '<strong>VIMEO Thumbnail</strong>';
											echo setup_pull_vimeo_video( $v_vid );

										}
									}
									
									// YOUTUBE
									if( $tog == 'youtube' ) {
										//echo '<h1>'.$tog.'</h1>';
										echo do_shortcode( '[su_youtube_advanced url="'.$v_vid.'"][/su_youtube_advanced]' );

									}

								}

							}

						} // foreach( $cpt_id as $id ) {

					} // if( is_array( $cpt_id ) ) {

				}

			} // if( !empty( $this_video ) ) {

		} // foreach( $video_toggle as $toggle ) {

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

		echo '<div><strong>Video Summary:</strong> '.$video_summary.'</div>';

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