<?php

	if ( ! function_exists( 'upload_user_file' ) ) :
	function upload_user_file( $file = array(), $title = false ) {
		require_once ABSPATH.'wp-admin/includes/admin.php';
		$file_return = wp_handle_upload($file, array('test_form' => false));
		if(isset($file_return['error']) || isset($file_return['upload_error_handler'])){
			return false;
		}else{
			
			$user = wp_get_current_user();
			
			require( EP_AWARD_NOMINATIONS_PATH . "/classes/ep-award-nominations-model.php");
			$newModel = new epAwardNominationsModel;
			$newModel->insert_attachment( $file_return['url'], $user->ID );
			
			$filename = $file_return['file'];
			$attachment = array(
					    'post_mime_type' => $file_return['type'],
					    'post_content' => '',
					    'post_type' => 'attachment',
					    'post_status' => 'inherit',
					    'guid' => $file_return['url']
					    );
			if($title){
				$attachment['post_title'] = $title;
			}
			$attachment_id = wp_insert_attachment( $attachment, $filename );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			
			$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
			wp_update_attachment_metadata( $attachment_id, $attachment_data );
			if( 0 < intval( $attachment_id ) ) {
				return $attachment_id;
			}
		}
		return false;
	}
	endif;



	if ( ! function_exists( 'reArrayFiles' ) ) :
	function reArrayFiles(&$file_post) {
		$file_ary = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);
		for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_ary[$i][$key] = $file_post[$key][$i];
			}
		}
		return $file_ary;
	}
	endif;


	if ( ! function_exists( 'upload_images_callback' ) ) :
	function upload_images_callback() {
		$data = array();
		$attachment_ids = array();
		if( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'image_upload' ) ){
			$files = reArrayFiles($_FILES['files']);
			if ( empty($_FILES['files']) ) {
				$data['status'] = false;
				$data['message'] = __('Please select a video to upload!','twentysixteen');
			} elseif ( $files[0]['size'] > 268435456 ) { // Maximum image size is 250M
				$data['size'] = $files[0]['size'];
				$data['status'] = false;
				$data['message'] = __('video is too large. It must be less than 250M!','twentysixteen');
			} else {
				$i = 0;
				$data['message'] = '';
				foreach( $files as $file ){
					if( is_array($file) ){
						$attachment_id = upload_user_file( $file, false );
						
						if ( is_numeric($attachment_id) ) {
							$img_thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
							$data['status'] = true;
							$data['message'] .=
							'<li id="attachment-'.$attachment_id.'">
							<img src="'.$img_thumb[0].'" alt="" />
							</li>';
							$attachment_ids[] = $attachment_id;
						}
					}
					$i++;
				}
				if( ! $attachment_ids ){
					$data['status'] = false;
					$data['message'] = __('An error has occured. Your video was not added.','twentysixteen');
				}
			}
		} else {
			$data['status'] = false;
			$data['message'] = __('Nonce verify failed','twentysixteen');
		}
		echo json_encode($data);
		die();
	}
	endif;

?>
