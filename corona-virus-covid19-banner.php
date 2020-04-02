<?php
/**
 * Plugin Name: corona-virus-covid19-banner
 * Plugin URI: https://www.bridgement.com
 * Description: Display South African COVID-19 banner
 * Version: 0.2.2
 * Author: Bridgement
 * License: GPL2
 *
 * @package corona-virus-covid19-banner
 * @version 0.2.2
 * @author Bridgement <support@bridgement.com>
 */

add_action( 'wp_enqueue_scripts', 'covid_banner' );
function covid_banner() {

		wp_register_style('covid-banner-style',  plugin_dir_url( __FILE__ ) .'corona-virus-covid19-banner.css', '', VERSION);
        wp_enqueue_style('covid-banner-style');

        $script_params = array(
			'in_array' => in_array(get_the_ID(), explode(",", get_option('disabled_pages_array'))),
			'debug_mode' => get_option('debug_mode'),
            'id' => get_the_ID(),
            'img_src' => plugin_dir_url( __FILE__ ) .'img/coat.png',
			'covid_banner_color' => get_option('covid_banner_color'),
			'covid_banner_text_color' => get_option('covid_banner_text_color'),
			'covid_banner_link_color' => get_option('covid_banner_link_color'),
		);


		wp_register_style('font-script', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap', '', VERSION);
		wp_enqueue_style ( 'font-script');


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

		<form method="post" action="options.php">
			<?php settings_fields( 'covid-banner-settings-group' ); ?>
			<?php do_settings_sections( 'covid-banner-settings-group' ); ?>
			<table class="form-table">

				<tr valign="top">
					<th scope="row">Covid Banner Background Color<br><span style="font-weight:400;">(Leaving this blank sets the color to the default value)</span></th>
					<td style="vertical-align:top;">
						<input type="text" id="covid_banner_color" name="covid_banner_color" placeholder="Hex value"
										value="<?php echo esc_attr( get_option('covid_banner_color') ); ?>" />
						<input style="height: 30px;width: 100px;" type="color" id="covid_banner_color_show"
										value="<?php echo ((get_option('covid_banner_color') == '') ? '#024985' : esc_attr( get_option('covid_banner_color') )); ?>">
					</td>
				</tr>

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


			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
?>