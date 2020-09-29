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

		?><div><strong>Video (Alt) Title:</strong> <?php
			echo $video_title;
		?></div><?php

	}


	/**
	 * CUSTOM FIELD | THUMBNAIL
	 *
	 */
	$video_thumbnail = get_field( "video_thumbnail" );
	if( !empty( $video_thumbnail ) ) {

		?><div><strong>Video Thumbnail:</strong> <?php
			echo wp_get_attachment_image( $video_thumbnail, 'thumbnail' );
		?></div><?php

	}


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

			echo '<h2>'.$toggle.'</h2>';
				
			// YOUTUBE
			// --------------------------------- *
			if( $toggle == 'youtube' ) {

				// VARIABLE FOR VIDEO DEFAULT
				$video_default_youtube = $this_video;

				// validate vimeo video id
				if( !empty( $this_video ) ) {

					// Display video
					$args = array(
						'type'				=> $toggle,
						'vid'				=> $this_video,
						'counter'			=> $box_counter,
					);
					
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
				//echo '<h1>'.$video_default_var.' == enable && '.empty( $video_default_youtube ).'</h1>';
				if( $video_default_var == 'enable' && empty( $video_default_youtube ) || $video_default_var == 'disable' ) {

					// validate vimeo video id
					if( !empty( $this_video ) ) {
						
						$args = array(
							'type'				=> $toggle,
							'vid'				=> $this_video,
							'counter'			=> $box_counter,
							'thumb_size'		=> 'thumbnail_large', // ( sizes: thumbnail_small, thumbnail_medium, thumbnail_large )
						);
						
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
						
						// VIDEO TITLE (custom field)
						/*$cf_video_title = get_post_meta( $id, "video_title", TRUE );
						if( !empty( $cf_video_title ) ) {

							// SHOW ALT TITLE
							echo '<h3>'.$cf_video_title.'</h3>';

						} else {

							// SHOW WP NATIVE TITLE
							echo '<h3>'.get_the_title( $id ).'</h3>';

						}*/

						// VIDEO TOGGLE (custom field)
						$v_toggle = get_post_meta( $id, "video_toggle", TRUE );

						if( is_array( $v_toggle ) ) {

							foreach( $v_toggle as $tog ) {
								
								$v_vid = get_post_meta( $id, "video_".$tog, TRUE );
								
								// YOUTUBE
								if( $tog == 'youtube' ) {
									
									if( !empty( $v_vid ) ) {

										$args = array(
											'type'				=> $tog,
											'vid'				=> $v_vid,
											'counter'			=> $box_counter,
										);
										
										echo setup_embed_videos( $args );

									}


								// VIMEO
								if( $tog == 'vimeo' ) {
									
									// validate vimeo video id
									if( !empty( $v_vid ) ) {

										$args = array(
											'type'				=> $tog,
											'vid'				=> $v_vid,
											'counter'			=> $box_counter,
											'thumb_size'		=> 'thumbnail_large', // ( sizes: thumbnail_small, thumbnail_medium, thumbnail_large )
										);
										
										echo setup_embed_videos( $args );

									}
								}
								}

							} // foreach( $v_toggle as $tog ) {

						}

					} // foreach( $cpt_id as $id ) {

				} // if( is_array( $cpt_id ) ) {

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

		?><div><strong>Video Summary:</strong> <?php
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