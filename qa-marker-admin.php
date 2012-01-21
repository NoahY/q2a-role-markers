<?php
	class qa_marker_admin {
		
		function allow_template($template)
		{
			return ($template!='admin');
		}

		function option_default($option) {

			switch($option) {
				case 'marker_plugin_who_text':
					return '&diams;';
				case 'marker_plugin_css_2':
					return '
.qa-q-item-avatar,.qa-q-view-avatar,.qa-a-item-avatar,.qa-c-item-avatar {
	position:relative;
}
.qa-who-marker {
	cursor: pointer;
	font-size: 200%;
	margin-right: 2px;
	vertical-align: sub;
	line-height: 50%;
}
.qa-who-marker-expert {
	color: #4D90FE;
}				
.qa-who-marker-editor {
	color: #CB9114;
}				
.qa-who-marker-moderator {
	color: #CDCDCD;
}				
.qa-who-marker-admin {
	color: #EEDD0F;
}				
.qa-avatar-marker {
	right:0;
	bottom:0;
	position:absolute;
}';
				default:
					return null;
			}
			
		}

		function admin_form(&$qa_content)
		{

		//	Process form input

			$ok = null;
			if (qa_clicked('marker_save_button')) {
				qa_opt('marker_plugin_css_2',qa_post_text('marker_plugin_css_2'));
				qa_opt('marker_plugin_who_text',qa_post_text('marker_plugin_who_text'));


				qa_opt('marker_plugin_a_qv',(bool)qa_post_text('marker_plugin_a_qv'));
				qa_opt('marker_plugin_a_qi',(bool)qa_post_text('marker_plugin_a_qi'));
				qa_opt('marker_plugin_a_a',(bool)qa_post_text('marker_plugin_a_a'));
				qa_opt('marker_plugin_a_c',(bool)qa_post_text('marker_plugin_a_c'));

				qa_opt('marker_plugin_w_users',(bool)qa_post_text('marker_plugin_w_users'));
				qa_opt('marker_plugin_w_qv',(bool)qa_post_text('marker_plugin_w_qv'));
				qa_opt('marker_plugin_w_qi',(bool)qa_post_text('marker_plugin_w_qi'));
				qa_opt('marker_plugin_w_a',(bool)qa_post_text('marker_plugin_w_a'));
				qa_opt('marker_plugin_w_c',(bool)qa_post_text('marker_plugin_w_c'));
/*
				
				qa_opt('share_plugin_facebook_weight',(int)qa_post_text('share_plugin_facebook_weight'));
				qa_opt('share_plugin_twitter_weight',(int)qa_post_text('share_plugin_twitter_weight'));
				qa_opt('share_plugin_google_weight',(int)qa_post_text('share_plugin_google_weight'));
				qa_opt('share_plugin_linkedin_weight',(int)qa_post_text('share_plugin_linkedin_weight'));
				qa_opt('share_plugin_email_weight',(int)qa_post_text('share_plugin_email_weight'));
				
				qa_opt('share_plugin_widget_only',(bool)qa_post_text('share_plugin_widget_only'));
				qa_opt('share_plugin_widget_title',qa_post_text('share_plugin_widget_title'));
				
				qa_opt('share_plugin_suggest',(int)qa_post_text('share_plugin_suggest'));
				qa_opt('share_plugin_suggest_text',qa_post_text('share_plugin_suggest_text'));
*/				
				$ok = qa_lang('admin/options_saved');
			}
			else if (qa_clicked('marker_reset_button')) {
				foreach($_POST as $i => $v) {
					$def = $this->option_default($i);
					if($def !== null) qa_opt($i,$def);
				}
				$ok = qa_lang('admin/options_reset');
			}			
		//	Create the form for display
			
		
			$fields = array();

			$fields[] = array(
				'label' => 'Marker custom css',
				'tags' => 'NAME="marker_plugin_css_2"',
				'value' => qa_opt('marker_plugin_css_2'),
				'type' => 'textarea',
				'rows' => 20
			);
			$fields[] = array(
				'type' => 'blank',
			);			
			$fields[] = array(
				'label' => 'Show avatar markers in questions on pages',
				'tags' => 'NAME="marker_plugin_a_qv"',
				'value' => qa_opt('marker_plugin_a_qv'),
				'type' => 'checkbox',
			);
			$fields[] = array(
				'label' => 'Show avatar markers in questions in lists',
				'tags' => 'NAME="marker_plugin_a_qi"',
				'value' => qa_opt('marker_plugin_a_qi'),
				'type' => 'checkbox',
			);
			
			$fields[] = array(
				'label' => 'Show avatar markers in answers',
				'tags' => 'NAME="marker_plugin_a_a"',
				'value' => qa_opt('marker_plugin_a_a'),
				'type' => 'checkbox',
			);
			
			$fields[] = array(
				'label' => 'Show avatar markers in comments',
				'tags' => 'NAME="marker_plugin_a_c"',
				'value' => qa_opt('marker_plugin_a_c'),
				'type' => 'checkbox',
			);
			$fields[] = array(
				'type' => 'blank',
			);			
			$fields[] = array(
				'label' => 'Marker text to show before names',
				'tags' => 'NAME="marker_plugin_who_text"',
				'value' => qa_opt('marker_plugin_who_text'),
			);
			$fields[] = array(
				'label' => 'Show markers before names in questions on pages',
				'tags' => 'NAME="marker_plugin_w_qv"',
				'value' => qa_opt('marker_plugin_w_qv'),
				'type' => 'checkbox',
			);
			$fields[] = array(
				'label' => 'Show markers before names in questions in lists',
				'tags' => 'NAME="marker_plugin_w_qi"',
				'value' => qa_opt('marker_plugin_w_qi'),
				'type' => 'checkbox',
			);
			
			$fields[] = array(
				'label' => 'Show markers before names in answers',
				'tags' => 'NAME="marker_plugin_w_a"',
				'value' => qa_opt('marker_plugin_w_a'),
				'type' => 'checkbox',
			);
			
			$fields[] = array(
				'label' => 'Show markers before names in comments',
				'tags' => 'NAME="marker_plugin_w_c"',
				'value' => qa_opt('marker_plugin_w_c'),
				'type' => 'checkbox',
			);
			$fields[] = array(
				'label' => 'Show markers before names in users list',
				'tags' => 'NAME="marker_plugin_w_users"',
				'value' => qa_opt('marker_plugin_w_users'),
				'type' => 'checkbox',
			);
			
/*
			$fields[] = array(
				'label' => 'Show Twitter button',
				'tags' => 'NAME="share_plugin_twitter"',
				'value' => qa_opt('share_plugin_twitter'),
				'type' => 'checkbox',
			);

			$fields[] = array(
				'label' => 'Show Google+ button',
				'tags' => 'NAME="share_plugin_google"',
				'value' => qa_opt('share_plugin_google'),
				'type' => 'checkbox',
			);
						
			$fields[] = array(
				'label' => 'Show LinkedIn button',
				'tags' => 'NAME="share_plugin_linkedin"',
				'value' => qa_opt('share_plugin_linkedin'),
				'type' => 'checkbox',
			);
			
						
			$fields[] = array(
				'label' => 'Show email button',
				'tags' => 'NAME="share_plugin_email"',
				'value' => qa_opt('share_plugin_email'),
				'type' => 'checkbox',
			);
			
			$fields[] = array(
				'type' => 'blank',
			);
			
			$fields[] = array(
				'label' => 'Facebook button weight:',
				'tags' => 'NAME="share_plugin_facebook_weight" title="smaller values come before larger values in the DOM"',
				'value' => qa_opt('share_plugin_facebook_weight'),
				'type' => 'number',
			);
			
			$fields[] = array(
				'label' => 'Twitter button weight:',
				'tags' => 'NAME="share_plugin_twitter_weight" title="smaller values come before larger values in the DOM"',
				'value' => qa_opt('share_plugin_twitter_weight'),
				'type' => 'number',
			);

			$fields[] = array(
				'label' => 'Google+ button weight:',
				'tags' => 'NAME="share_plugin_google_weight" title="smaller values come before larger values in the DOM"',
				'value' => qa_opt('share_plugin_google_weight'),
				'type' => 'number',
			);
						
			$fields[] = array(
				'label' => 'LinkedIn button weight:',
				'tags' => 'NAME="share_plugin_linkedin_weight" title="smaller values come before larger values in the DOM"',
				'value' => qa_opt('share_plugin_linkedin_weight'),
				'type' => 'number',
			);
						
			$fields[] = array(
				'label' => 'Email button weight:',
				'tags' => 'NAME="share_plugin_email_weight" title="smaller values come before larger values in the DOM"',
				'value' => qa_opt('share_plugin_email_weight'),
				'type' => 'number',
			);

			$fields[] = array(
				'type' => 'blank',
			);			
			

									
			$fields[] = array(
				'label' => 'Widget only',
				'tags' => 'NAME="share_plugin_widget_only"',
				'value' => qa_opt('share_plugin_widget_only'),
				'type' => 'checkbox',
				'note' => 'disables inline buttons - widget must be enabled via admin/layout',
			);
			$fields[] = array(
				'label' => 'Widget Title',
				'tags' => 'NAME="share_plugin_widget_title"',
				'value' => qa_opt('share_plugin_widget_title'),
			);

			$fields[] = array(
				'type' => 'blank',
			);			
			
			$fields[] = array(
				'label' => 'Show notification text while there are still no answers to a question',
				'tags' => 'NAME="share_plugin_suggest" onclick="if(this.checked) jQuery(\'#share_options_container\').fadeIn(); else jQuery(\'#share_options_container\').fadeOut();"',
				'value' => qa_opt('share_plugin_suggest'),
				'type' => 'checkbox',
				'note' => '<table id="share_options_container" style="display:'.(qa_opt('share_plugin_suggest')?'block':'none').'"><tr><td>',
			);		
							
			$fields[] = array(
				'tags' => 'NAME="share_plugin_suggest_text"',
				'value' => qa_opt('share_plugin_suggest_text'),
				'type' => 'text',
				'note' => '<i style="font-size:10px;">(use <b>#</b> to specify button location)</i></td></tr></table>',
			);						

			$fields[] = array(
				'type' => 'blank',
			);			
*/						
			return array(
				'ok' => ($ok && !isset($error)) ? $ok : null,
				
				'fields' => $fields,
				
				'buttons' => array(
					array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'NAME="marker_save_button"',
					),
					array(
					'label' => qa_lang_html('admin/reset_options_button'),
					'tags' => 'NAME="marker_reset_button"',
					),
				),
			);
		}
	}
