<?php
	class qa_html_theme_layer extends qa_html_theme_base
	{
		function head_custom()
		{
			qa_html_theme_base::head_custom();
			
			$this->output('
<style>
'.qa_opt('marker_plugin_css').'				
</style>');
		}

		function post_avatar($post, $class, $prefix=null)
		{
			if(isset($post['avatar']) && (($class == 'qa-q-view' && qa_opt('marker_plugin_a_qv')) || ($class == 'qa-q-item' && qa_opt('marker_plugin_a_qi')) || ($class == 'qa-a-item' && qa_opt('marker_plugin_a_a')) || ($class == 'qa-c-item' && qa_opt('marker_plugin_a_c')))) {
				$uid = $post['raw']['userid'];
				$image = $this->get_role_marker($uid,1);
				$post['avatar'] = $image.@$post['avatar'];
			}
			qa_html_theme_base::post_avatar($post, $class, $prefix);
		}
		function post_meta($post, $class, $prefix=null, $separator='<BR/>')
		{
			if(isset($post['who']) && (($class == 'qa-q-view' && qa_opt('marker_plugin_w_qv')) || ($class == 'qa-q-item' && qa_opt('marker_plugin_w_qi')) || ($class == 'qa-a-item' && qa_opt('marker_plugin_w_a')) || ($class == 'qa-c-item' && qa_opt('marker_plugin_w_c')))) {
				$handle = strip_tags($post['who']['data']);
				$uid = $this->getuserfromhandle($handle);
				$image = $this->get_role_marker($uid,2);
				$post['who']['data'] = $image.$post['who']['data'];
				
			}
			if(isset($post['who_2']) && (($class == 'qa-q-view' && qa_opt('marker_plugin_w_qv')) || ($class == 'qa-q-item' && qa_opt('marker_plugin_w_qi')) || ($class == 'qa-a-item' && qa_opt('marker_plugin_w_a')) || ($class == 'qa-c-item' && qa_opt('marker_plugin_w_c')))) {
				$handle = strip_tags($post['who_2']['data']);
				$uid = $this->getuserfromhandle($handle);
				$image = $this->get_role_marker($uid,2);
				$post['who_2']['data'] = $image.$post['who_2']['data'];
			}

			qa_html_theme_base::post_meta($post, $class, $prefix, $separator);
		}
		function ranking_label($item, $class)
		{
			if(qa_opt('marker_plugin_w_users') && $class == 'qa-top-users') {
				$handle = strip_tags($item['label']);
				$uid = $this->getuserfromhandle($handle);
				$image = $this->get_role_marker($uid,2);
				$item['label'] = $image.$item['label'];
			}
			qa_html_theme_base::ranking_label($item, $class);
		}
				
	// worker
		
		function get_role_marker($uid,$switch) {
			if (QA_FINAL_EXTERNAL_USERS) {
				$user = get_userdata( $uid );
				if (isset($user->wp_capabilities['administrator']) || isset($user->caps['administrator']) || isset($user->allcaps['administrator']) || (is_array($user->roles) && in_array('administrator',$user->roles))) {
					$level=qa_lang('users/level_admin');
					$img = 'gold';
				}
				elseif (isset($user->wp_capabilities['editor']) || isset($user->caps['editor']) || (is_array($user->roles) && in_array('editor',$user->roles))) {
					$level=qa_lang('users/level_editor');
					$img = 'silver';
				}
				elseif (isset($user->wp_capabilities['contributor']) || isset($user->caps['contributor']) || (is_array($user->roles) && in_array('contributor',$user->roles))) {
					$level=qa_lang('users/level_expert');
					$img = 'bronze';
				}
				else
					return;
			} 
			else {
				$levelno = qa_db_read_one_value(
					qa_db_query_sub(
						'SELECT level FROM ^users WHERE userid=#',
						$uid
					),
					true
				);
				$level = qa_user_level_string($levelno);
				if ($level == qa_lang('users/level_admin') || $level == qa_lang('users/level_super'))
					$img = 'gold';
				elseif ($level == qa_lang('users/level_editor'))
					$img = 'silver';
				elseif ($level == qa_lang('users/level_expert'))
					$img = 'bronze';
				else
					return; 
			}

			if($switch == 1)
				return '<div class="qa-avatar-marker"><img title="'.qa_html($level).'" width="20" src="'.QA_HTML_THEME_LAYER_URLTOROOT.$img.'.png"/></div>';
			else 
				return '<span class="qa-who-marker qa-who-marker-'.$img.'" title="'.qa_html($level).'">'.qa_opt('marker_plugin_who_text').'</span>';
		}
		function getuserfromhandle($handle) {
			require_once QA_INCLUDE_DIR.'qa-app-users.php';
			
			if (QA_FINAL_EXTERNAL_USERS) {
				$publictouserid=qa_get_userids_from_public(array($handle));
				$userid=@$publictouserid[$handle];
				
			} 
			else {
				$userid = qa_db_read_one_value(
					qa_db_query_sub(
						'SELECT userid FROM ^users WHERE handle = $',
						$handle
					),
					true
				);
			}
			if (!isset($userid)) return;
			return $userid;
		}
	}