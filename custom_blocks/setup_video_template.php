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

		foreach( $video_toggle as $toggle ) {
			
			// GET THE SELECTED FIELD
			$this_video = get_field( "video_".$toggle );

			echo '<h2>'.$toggle.'</h2>';

			// VIMEO
			// --------------------------------- *
			if( $toggle == 'vimeo' ) {

				// validate vimeo video id
				if( !empty( $this_video ) ) {
					
					$args = array(
						'type'				=> $toggle,
						'vid'				=> $this_video,
						'thumb_size'		=> 'thumbnail_large', // ( sizes: thumbnail_small, thumbnail_medium, thumbnail_large )
					);
					
					echo setup_embed_videos( $args );

				}

			}
				
			// YOUTUBE
			// --------------------------------- *
			if( $toggle == 'youtube' ) {

				// validate vimeo video id
				if( !empty( $this_video ) ) {
					
					$args = array(
						'type'				=> $toggle,
						'vid'				=> $this_video,
					);
					
					echo setup_embed_videos( $args );

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

								// VIMEO
								if( $tog == 'vimeo' ) {
									
									// validate vimeo video id
									if( !empty( $v_vid ) ) {

										$args = array(
											'type'				=> $tog,
											'vid'				=> $v_vid,
											'thumb_size'		=> 'thumbnail_large', // ( sizes: thumbnail_small, thumbnail_medium, thumbnail_large )
										);
										
										echo setup_embed_videos( $args );

									}
								}
								
								// YOUTUBE
								if( $tog == 'youtube' ) {

									if( !empty( $v_vid ) ) {

										$args = array(
											'type'				=> $tog,
											'vid'				=> $v_vid,
										);
										
										echo setup_embed_videos( $args );

									}

								}

							} // foreach( $v_toggle as $tog ) {

						}

					} // foreach( $cpt_id as $id ) {

				} // if( is_array( $cpt_id ) ) {

			}

		} // end of foreach( $video_toggle as $toggle ) {

	}

	/*if( is_array( $video_toggle ) ) {

		foreach( $video_toggle as $toggle ) {

			// GET THE SELECTED FIELD
			$this_video = get_field( "video_".$toggle );

			// VALIDATE VIDEO FIELD
			if( !empty( $this_video ) ) {

				// Show the field (comment the line below if not needed)
				//echo '<h2>'.strtoupper( $toggle ).'</h2>';

				// VIMEO
				// --------------------------------- *
				if( $toggle == 'vimeo' ) {
					
					// validate vimeo video id
					if( !empty( $this_video ) ) {
						
						$args = array(
							'type'				=> $toggle,
							'vid'				=> $this_video,
							'thumb_size'		=> 'thumbnail_large', // ( sizes: thumbnail_small, thumbnail_medium, thumbnail_large )
						);
						
						echo setup_embed_videos( $args );

					}

				}
				
				// YOUTUBE
				// --------------------------------- *
				if( $toggle == 'youtube' ) {

					// validate vimeo video id
					if( !empty( $this_video ) ) {

						$args = array(
							'type'				=> $toggle,
							'vid'				=> $this_video,
						}

						echo setup_embed_videos( $args );

					}

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

	} */


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