<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * OUTPUT: VIMEO Video
 *
 */
function setup_vimeo_output( $id, $size, $box_counter ) {

	return '<div class="module-video-vimeo" id="vimeo___'.$id.'___'.$box_counter.'">
				<div class="video-image" id="vimeo_image___'.$id.'___'.$box_counter.'"><div class="module-wrap">
					<div class="video-play" id="vimeo_play___'.$id.'___'.$box_counter.'"></div>
					<img src="'.setup_get_vimeo_thumb( $id, $size ).'" class="thumbnail" id="vimeo_thumb___'.$id.'___'.$box_counter.'" border="0" />
				</div></div>
			</div>';

}


/**
 * OUTPUT: YOUTUBE Video
 *
 */
function setup_youtube_output( $id, $box_counter ) {

	return '<div class="module-video" id="'.$id.'___'.$box_counter.'">
                <div class="video-image" id="video_image___'.$id.'___'.$box_counter.'"><div class="module-wrap">
                    <div class="video-play" id="video_play___'.$id.'___'.$box_counter.'"></div>
                    <img src="https://img.youtube.com/vi/'.$id.'/0.jpg" class="thumbnail" id="thumbnail___'.$id.'___'.$box_counter.'" />
                </div></div>
            </div>';

}


/**
 * Pull YOUTUBE & VIMEO Videos
 *
 */
function setup_embed_videos( $args ) {

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

	    return setup_youtube_output( $youtubeid, $args[ 'counter' ] );

	}

	// VIMEO
	if( $args[ 'type' ] == 'vimeo' ) {

		// filter the Vimeo ID
		$exp_vimeo_id = explode( '/', $args[ 'vid' ] );
		$id = $exp_vimeo_id[ count( $exp_vimeo_id ) - 1 ];
		/*

			CHECK IF ACTUAL THUMBNAIL IS AVAILABLE (IN VIMEO SERVERS)
			IF TRUE
				USE VIDEO THUMBNAIL (ACF CUSTOM FIELD)
			ELSEIF
				USE VIMEO/YOUTUBE THUMBNAIL
			ELSEIF
				USE GLOBAL THUMBNAIL
			ELSEIF
				SHOW VIDEO 
			ELSE
				DISPLAY ERROR MESSAGE THAT VIDEO IS NOT AVAILABLE

		*/

		return setup_vimeo_output( $id, $args[ 'thumb_size' ], $args[ 'counter' ] );

	}

}


/**
 * Gets a vimeo thumbnail url
 * @param mixed $id A vimeo id (ie. 1185346)
 * @return thumbnail's url
*/
function setup_get_vimeo_thumb( $id, $size ) {

    $data = file_get_contents("https://vimeo.com/api/v2/video/".$id.".json");
    $data = json_decode($data);
    return $data[0]->$size;

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
function setup_vimeo_video_fn() {
    
    // last arg is true - will be placed before </body>
    wp_register_script( 'setup_vimeo_video_scripts', plugins_url( 'js/asset.js', __FILE__ ), NULL, '1.0', TRUE );
     
    // Localize the script with new data
    /*$translation_array = array(
        'spk_master_one_ajax' => plugin_dir_url( __FILE__ ).'../ajax/spk_master_plug_v1_ajax.php',
    );
    wp_localize_script( 'spk_master_plugins_v1_js', 'spk_master_one', $translation_array );
    */
    // Enqueued script with localized data.
    wp_enqueue_script( 'setup_vimeo_video_scripts' );

}


/**
 * EXECUTE
 *
 */
//if ( !is_admin() ) {

    // ENQUEUE SCRIPTS
    //add_action( 'wp_enqueue_scripts', 'setup_vimeo_video_fn' ); 
    add_action( 'wp_footer', 'setup_vimeo_video_fn', 5 );
    //add_action( 'admin_enqueue_scripts', 'setup_vimeo_video_fn' );

//}