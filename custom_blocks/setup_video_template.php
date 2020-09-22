<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


//$wp_title = get_the_title();


$video_title = get_post_meta( get_the_ID(), "video_title", TRUE );
echo '<div><strong>Video (Alt) Title:</strong> '.$video_title.'</div>';


$video_thumbnail = get_field( "video_thumbnail" );
echo '<div><strong>Video Thumbnail</strong> ';
echo wp_get_attachment_image( $video_thumbnail, 'thumbnail' );
echo '</div>';

$video_toggle = get_field( "video_toggle" );
foreach( $video_toggle as $toggle ) {

	$this_video = get_field( "video_".$toggle );
	if( !empty( $this_video ) ) {

		//echo '<iframe src="https://player.vimeo.com/video/'.$this_video.'" width="640" height="480" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
		echo '<div style="padding:75% 0 0 0;position:relative;">
				<iframe src="https://player.vimeo.com/video/'.$this_video.'?autoplay=1&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
			</div>
			<script src="https://player.vimeo.com/api/player.js"></script>';

	}

}

/*
<iframe src="https://player.vimeo.com/video/206621700" width="640" height="480" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
<p><a href="https://vimeo.com/206621700">Diablo 1: Part 4</a> from <a href="https://vimeo.com/user12259049">yeshaya</a> on <a href="https://vimeo.com">Vimeo</a>.</p>

https://vimeo.com/206621700
*/