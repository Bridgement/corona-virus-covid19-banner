<?php
/**
 * Plugin Name: corona-virus-covid19-banner
 * Plugin URI: https://www.bridgement.com
 * Description: Display South African COVID-19 banner
 * Version: 0.2.1
 * Author: Bridgement
 * License: GPL2
 *
 * @package corona-virus-covid19-banner
 * @version 0.2.1
 * @author Bridgement <support@bridgement.com>
 */

add_action( 'wp_enqueue_scripts', 'covid_banner' );
function covid_banner() {
        // Enqueue the style
		wp_register_style('covid-banner-style',  plugin_dir_url( __FILE__ ) .'corona-virus-covid19-banner.css', '', VERSION);
        wp_enqueue_style('covid-banner-style');

        $script_params = array(
			// // script specific parameters
			// 'covid_banner_text' => get_option('covid_banner_text'),
			// 'pro_version_enabled' => get_option('pro_version_enabled'),
			'in_array' => in_array(get_the_ID(), explode(",", get_option('disabled_pages_array'))),
			// // debug specific parameters
			'debug_mode' => get_option('debug_mode'),
            'id' => get_the_ID(),
            'img_src' => plugin_dir_url( __FILE__ ) .'img/coat.png',
			// 'disabled_pages_array' => explode(",", get_option('disabled_pages_array')),
			'covid_banner_color' => get_option('covid_banner_color'),
			'covid_banner_text_color' => get_option('covid_banner_text_color'),
			'covid_banner_link_color' => get_option('covid_banner_link_color'),
			// 'covid_banner_text' => get_option('covid_banner_text'),
			// 'covid_banner_custom_css' => get_option('covid_banner_custom_css'),
			// 'site_custom_css' => get_option('site_custom_css'),
			// 'site_custom_js' => get_option('site_custom_js')
		);


		wp_register_style('font-script', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap', '', VERSION);
		wp_enqueue_style ( 'font-script');


        // Enqueue the script
        wp_register_script('covid-banner-script', plugin_dir_url( __FILE__ ) . 'corona-virus-covid19-banner.js', array( 'jquery' ), VERSION);
        wp_localize_script('covid-banner-script', 'scriptParams', $script_params);
        wp_enqueue_script('covid-banner-script');
}

add_action( 'wp_head', 'covid_banner_custom_color');
function covid_banner_custom_color()
{
	if (get_option('covid_banner_color') != ""){
		echo '<style type="text/css" media="screen">.covid-banner{background:' . get_option('covid_banner_color') . '}</style>';
	} else {
		echo '<style type="text/css" media="screen">.covid-banner{background: #024985;}</style>';
	}

	if (get_option('covid_banner_text_color') != ""){
		echo '<style type="text/css" media="screen">.covid-banner .covid-text{color:' . get_option('covid_banner_text_color') . '}</style>';
	} else {
		echo '<style type="text/css" media="screen">.covid-banner .covid-text{color: #606060;}</style>';
	}

	if (get_option('covid_banner_header_color') != ""){
		echo '<style type="text/css" media="screen">.covid-banner .covid-header{color:' . get_option('covid_banner_text_color') . '}</style>';
	} else {
		echo '<style type="text/css" media="screen">.covid-banner .covid-header{color: #606060;}</style>';
	}

	if (get_option('covid_banner_link_color') != ""){
		echo '<style type="text/css" media="screen">.covid-banner .covid-body a{color:' . get_option('covid_banner_link_color') . "}</style>";
		echo '<style type="text/css" media="screen">.covid-banner .covid-body a:visited{color:' . get_option('covid_banner_link_color') . "}</style>";
	} else {
		echo '<style type="text/css" media="screen">.covid-banner .covid-body a{color: #065fd4;}</style>';
		echo '<style type="text/css" media="screen">.covid-banner .covid-body a:visited{color: #065fd4;}</style>';
	}
}
add_action('admin_menu', 'covid_banner_menu');
function covid_banner_menu() {
	add_menu_page('Corona Virus Covid19 Banner Settings', 'Covid Banner', 'administrator', 'covid-banner-settings', 'covid_banner_settings_page', 'dashicons-admin-generic');
}

add_action( 'admin_init', 'covid_banner_settings' );
function covid_banner_settings() {
	register_setting( 'covid-banner-settings-group', 'covid_banner_color' );
    register_setting( 'covid-banner-settings-group', 'covid_banner_text_color' );
    register_setting( 'covid-banner-settings-group', 'covid_banner_header_color' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_link_color' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_text' );
	register_setting( 'covid-banner-settings-group', 'disabled_pages_array' );
}

function covid_banner_settings_page() {
	?>
	<div class="wrap">
		<div style="display: flex;justify-content: space-between;">
			<h2>Corona Virus Covid19 Banner Settings</h2>
		</div>

		<p>Use Hex color values for the color fields.</p>

		<!-- Settings Form -->
		<form method="post" action="options.php">
			<?php settings_fields( 'covid-banner-settings-group' ); ?>
			<?php do_settings_sections( 'covid-banner-settings-group' ); ?>
			<table class="form-table">
				<!-- Background Color -->
				<tr valign="top">
					<th scope="row">Covid Banner Background Color<br><span style="font-weight:400;">(Leaving this blank sets the color to the default value)</span></th>
					<td style="vertical-align:top;">
						<input type="text" id="covid_banner_color" name="covid_banner_color" placeholder="Hex value"
										value="<?php echo esc_attr( get_option('covid_banner_color') ); ?>" />
						<input style="height: 30px;width: 100px;" type="color" id="covid_banner_color_show"
										value="<?php echo ((get_option('covid_banner_color') == '') ? '#024985' : esc_attr( get_option('covid_banner_color') )); ?>">
					</td>
				</tr>
				<!-- Text Color -->
				<tr valign="top">
					<th scope="row">Covid Banner Text Color<br><span style="font-weight:400;">(Leaving this blank sets the color to the default value)</span></th>
					<td style="vertical-align:top;">
						<input type="text" id="covid_banner_text_color" name="covid_banner_text_color" placeholder="Hex value"
										value="<?php echo esc_attr( get_option('covid_banner_text_color') ); ?>" />
						<input style="height: 30px;width: 100px;" type="color" id="covid_banner_text_color_show"
										value="<?php echo ((get_option('covid_banner_text_color') == '') ? '#606060' : esc_attr( get_option('covid_banner_text_color') )); ?>">
					</td>
                </tr>
                <tr valign="top">
					<th scope="row">Covid Banner Header Color<br><span style="font-weight:400;">(Leaving this blank sets the color to the default value)</span></th>
					<td style="vertical-align:top;">
						<input type="text" id="covid_banner_header_color" name="covid_banner_header_color" placeholder="Hex value"
										value="<?php echo esc_attr( get_option('covid_banner_header_color') ); ?>" />
						<input style="height: 30px;width: 100px;" type="color" id="covid_banner_header_color_show"
										value="<?php echo ((get_option('covid_banner_header_color') == '') ? '#030303' : esc_attr( get_option('covid_banner_header_color') )); ?>">
					</td>
				</tr>
				<!-- Link Color-->
				<tr valign="top">
					<th scope="row">Covid Banner Link Color<br><span style="font-weight:400;">(Leaving this blank sets the color to the default value)</span></th>
					<td style="vertical-align:top;">
						<input type="text" id="covid_banner_link_color" name="covid_banner_link_color" placeholder="Hex value"
										value="<?php echo esc_attr( get_option('covid_banner_link_color') ); ?>" />
						<input style="height: 30px;width: 100px;" type="color" id="covid_banner_link_color_show"
										value="<?php echo ((get_option('covid_banner_link_color') == '') ? '#065fd4' : esc_attr( get_option('covid_banner_link_color') )); ?>">
					</td>
				</tr>
			</table>

			<!-- Save Changes Button -->
			<?php submit_button(); ?>
		</form>
	</div>

	<!-- Script to apply styles to Preview Banner -->
	<script type="text/javascript">
		var style_background_color = document.createElement('style');
		var style_link_color = document.createElement('style');
		var style_text_color = document.createElement('style');

		// Banner Text

		// Background Color
		style_background_color.type = 'text/css';
		style_background_color.id = 'preview_banner_background_color'
		style_background_color.appendChild(document.createTextNode('.covid-banner{background:' + (document.getElementById('covid_banner_color').value || '#024985') + '}'));
		document.getElementsByTagName('head')[0].appendChild(style_background_color);

		document.getElementById('covid_banner_color').onchange=function(e){
			document.getElementById('covid_banner_color_show').value = e.target.value || '#024985';
			var child = document.getElementById('preview_banner_background_color');
			if (child){child.innerText = "";child.id='';}

			var style_dynamic = document.createElement('style');
			style_dynamic.type = 'text/css';
			style_dynamic.id = 'preview_banner_background_color';
			style_dynamic.appendChild(
				document.createTextNode(
					'.covid-banner{background:' + (document.getElementById('covid_banner_color').value || '#024985') + '}'
				)
			);
			document.getElementsByTagName('head')[0].appendChild(style_dynamic);
		};
		document.getElementById('covid_banner_color_show').onchange=function(e){
			document.getElementById('covid_banner_color').value = e.target.value;
			document.getElementById('covid_banner_color').dispatchEvent(new Event('change'));
		};

		// Text Color
		style_text_color.type = 'text/css';
		style_text_color.id = 'preview_banner_text_color'
		style_text_color.appendChild(document.createTextNode('.covid-banner .covid-banner-text{color:' + (document.getElementById('covid_banner_text_color').value || '#ffffff') + '}'));
		document.getElementsByTagName('head')[0].appendChild(style_text_color);

		document.getElementById('covid_banner_text_color').onchange=function(e){
			document.getElementById('covid_banner_text_color_show').value = e.target.value || '#ffffff';
			var child = document.getElementById('preview_banner_text_color');
			if (child){child.innerText = "";child.id='';}

			var style_dynamic = document.createElement('style');
			style_dynamic.type = 'text/css';
			style_dynamic.id = 'preview_banner_text_color';
			style_dynamic.appendChild(
				document.createTextNode(
					'.covid-banner .covid-banner-text{color:' + (document.getElementById('covid_banner_text_color').value || '#ffffff') + '}'
				)
			);
			document.getElementsByTagName('head')[0].appendChild(style_dynamic);
		};
		document.getElementById('covid_banner_text_color_show').onchange=function(e){
			document.getElementById('covid_banner_text_color').value = e.target.value;
			document.getElementById('covid_banner_text_color').dispatchEvent(new Event('change'));
		};

		// Link Color
		style_link_color.type = 'text/css';
		style_link_color.id = 'preview_banner_link_color'
		style_link_color.appendChild(document.createTextNode('.covid-banner .covid-banner-text a{color:' + (document.getElementById('covid_banner_link_color').value || '#f16521') + '}'));
		document.getElementsByTagName('head')[0].appendChild(style_link_color);

		document.getElementById('covid_banner_link_color').onchange=function(e){
			document.getElementById('covid_banner_link_color_show').value = e.target.value || '#065fd4';
			var child = document.getElementById('preview_banner_link_color');
			if (child){child.innerText = "";child.id='';}

			var style_dynamic = document.createElement('style');
			style_dynamic.type = 'text/css';
			style_dynamic.id = 'preview_banner_link_color';
			style_dynamic.appendChild(
				document.createTextNode(
					'.covid-banner .covid-banner-text a{color:' + (document.getElementById('covid_banner_link_color').value || '#065fd4') + '}'
				)
			);
			document.getElementsByTagName('head')[0].appendChild(style_dynamic);
		};
		document.getElementById('covid_banner_link_color_show').onchange=function(e){
			document.getElementById('covid_banner_link_color').value = e.target.value;
			document.getElementById('covid_banner_link_color').dispatchEvent(new Event('change'));
		};

		// Disabled Pages
		document.getElementById('covid_banner_pro_disabled_pages').onclick=function(e){
			let disabledPagesArray = [];
			Array.from(document.getElementById('covid_banner_pro_disabled_pages').getElementsByTagName('input')).forEach(function(e) {
				if (e.checked) {
					disabledPagesArray.push(e.value);
				}
			});
			document.getElementById('disabled_pages_array').value = disabledPagesArray;
		};

		// remove banner text newlines on submit
		document.getElementById('submit').onclick=function(e){
			document.getElementById('covid_banner_text').value = document.getElementById('covid_banner_text').value.replace(/\n/g, "");
		};
	</script>
	<?php
}
?>