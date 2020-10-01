<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * OUTPUT: YOUTUBE AND VIMEO VIDEOS
 *
 */
function setup_video_output_fn( $args ) {

	$id = $args[ 'video_id' ];
	$box_counter = $args[ 'counter' ];
	$t_size = $args[ 'vimeo_thumb_size' ];

	// validate thumbnail
	if( !empty( $args[ 'thumbs' ] ) ) {

		$thumbsup = $args[ 'thumbs' ];

	} else {
		
		// get youtube thumbnail
		if( $args[ 'type' ] == 'youtube' ) {

			$thumbsup = 'https://img.youtube.com/vi/'.$id.'/0.jpg';

		}

		// get vimeo thumbnail
		if( $args[ 'type' ] == 'vimeo' ) {

		    $data = file_get_contents( "https://vimeo.com/api/v2/video/".$id.".json" );
		    $data = json_decode($data);
		    
		    //$thumbsup = $data[0]->$args[ 'vimeo_thumb_size' ];
		    $thumbsup = $data[0]->$t_size;

		}

	}

	// display
	echo '<div class="module video video-block" id="videoblock__'.$args[ 'type' ].'___'.$id.'___'.$box_counter.'">
				<div class="video-image" id="video_image___'.$id.'___'.$box_counter.'" style="background-image: url('.$thumbsup.');background-size:cover;background-position:center;">
					<div class="video-play">PLAY</div>
				</div>
		</div>';
}


/**
 * Pull YOUTUBE & VIMEO Videos
 *
 */
function setup_embed_videos( $args ) {

	// set thumbnail
	if( $args[ 'thumb' ] ) {

		if( $args[ 'thumb_size' ] ) {
			
			// use specified size
			$use_this_thumb = wp_get_attachment_image_src( $args[ 'thumb' ], $args[ 'thumb_size' ] );

 		} else {

 			// default to full sized thumbnail
 			$use_this_thumb = wp_get_attachment_image_src( $args[ 'thumb' ], 'full' );	

		}

	}

	// YOUTUBE
	if( $args[ 'type' ] == 'youtube' ) {

	    $vid = explode( "/", $args[ 'vid' ] );
	    $video_id = count( $vid ) - 1;

	    // validate URL used
	    // we want to catch the video id even if writer uses the like similar to this: https://www.youtube.com/watch?v=zDujFhvgUzI
		$exp_vid = explode( "?v=", $vid[ $video_id ] );
	    if( count( $exp_vid ) > 1 ) {
	       // not using the embed URL
	       $youtubeid = $exp_vid[ count( $exp_vid ) - 1 ];
	    } else {
	       // using the embed URL
	       $youtubeid = $vid[ $video_id ];
	    }

	    $atts = array(
	    	'type'					=> $args[ 'type' ],
	    	'video_id'				=> $youtubeid,
	    	'counter'				=> $args[ 'counter' ],
	    	'thumbs'				=> $use_this_thumb[0],
	    );
	    
	    return setup_video_output_fn( $atts );

	}

	// VIMEO
	if( $args[ 'type' ] == 'vimeo' ) {

		// filter the Vimeo ID
		$exp_vimeo_id = explode( '/', $args[ 'vid' ] );
		$id = $exp_vimeo_id[ count( $exp_vimeo_id ) - 1 ];

		$atts = array(
			'type'					=> $args[ 'type' ],
	    	'video_id'				=> $id,
	    	'counter'				=> $args[ 'counter' ],
	    	'thumbs'				=> $use_this_thumb[0],
	    	'vimeo_thumb_size'		=> $args[ 'vimeo_thumb_size' ],	
	    );

	    return setup_video_output_fn( $atts );

	}

}


/*
function disable_acf_load_field( $field ) {

	if( is_admin() && get_post_type() == 'video' ) {
		//var_dump($field);
		$field['label'] = 'Video Connect <strong>(DISABLED)</strong>';
		$field['disabled'] = true;

		return $field;

	}

}
add_filter('acf/load_field/name=video_connect', 'disable_acf_load_field');
*/


/**
 * DISABLE VIDEO CONNECT IF VIEW IS VIDEO CUSTOM POST TYPE
 *
 */
add_filter('acf/get_fields', 'setup_disable_acf_video_field_fn', 20, 2);
function setup_disable_acf_video_field_fn( $fields, $parent ) {
	
	// validate post type
	if( get_post_type() == 'video' ) {

		// filter & remove VIDEO CONNECT
		foreach ($fields as $key => $value) {
			
			//echo $value[ 'name' ]; echo '<br />';
			if( $value[ 'name' ] != 'video_connect' ) {
				$field[] = $value;
			}

		}

		unset( $fields );
	
		$fields = $field;

	}

	return $fields;

}


/**
 * ENQUEUE SCRIPTS
 * 
 */
add_action( 'wp_footer', 'setup_vimeo_video_fn', 5 );
function setup_vimeo_video_fn() {
    
    // last arg is true - will be placed before </body>
    wp_register_script( 'setup_vimeo_video_scripts', plugins_url( 'js/asset.js', __FILE__ ), NULL, '1.0', TRUE );

    // enqueue styles
    wp_enqueue_style( 'setup_video_block_style', plugins_url( 'assets/css/setup-video-block-style.css', __FILE__ ) );
     
    // Localize the script with new data
    /*$translation_array = array(
        'spk_master_one_ajax' => plugin_dir_url( __FILE__ ).'../ajax/spk_master_plug_v1_ajax.php',
    );
    wp_localize_script( 'spk_master_plugins_v1_js', 'spk_master_one', $translation_array );
    */
    // Enqueued script with localized data.
    wp_enqueue_script( 'setup_vimeo_video_scripts' );

}
