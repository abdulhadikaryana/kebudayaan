<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - FONT

		1.1 - Get font size
		1.2 - Get font family
		1.3 - CSS

	2 - STYLE

		2.1 - Custom colors
		2.2 - Custom CSS

	3 - WRITE A FILE

*/

function st_write_custom_css(){

	global
		$st_Options;

		$st_Settings = get_option( $st_Options['general']['name'] . 'settings' );

		$st_ = array();

	$css = '';

/*===============================================

	F O N T
	Custom font

===============================================*/

	/*-------------------------------------------
		1.1 - Get font size
	-------------------------------------------*/
	$size = '';

	if ( !empty( $st_Settings['font_size'] ) )
		$size = "  font-size: " . $st_Settings['font_size'] . "px;\n";


	/*-------------------------------------------
		1.2 - Get font family
	-------------------------------------------*/
	$font = '';

	if ( !empty( $st_Settings['font_type'] ) && $st_Settings['font_type'] == 'standard' )
		$font = '  font-family: ' . $st_Settings['font_system'];

	if ( !empty( $st_Settings['font_type'] ) && $st_Settings['font_type'] == 'custom' )
		$font = '  ' . $st_Settings['font_custom_css'];


	/*-------------------------------------------
		1.3 - CSS
	-------------------------------------------*/

	if ( $font || $size )
		$css .= "body, div, td {\n" . $size . $font . " \n}\n\n\n";



/*===============================================

	S T Y L E
	Colors & Custom styles

===============================================*/

	/*-------------------------------------------
		2.1 - Custom colors
	-------------------------------------------*/

	// Get colors from Theme Panel
	$primary = !empty( $st_Settings['color-primary'] ) ? $st_Settings['color-primary'] : '';
	$secondary = !empty($st_Settings['color-secondary']) ? $st_Settings['color-secondary'] : '';

	// Groups of colors
	$st_['colors'] = array(
		'primary' => array(
			'primary' 			=> 'original',
			'primary-alt-a'		=> 'alt',
			'primary-alt-b' 	=> 'alt',
			'primary-alt-c' 	=> 'alt',
			'primary-alt-d' 	=> 'alt',
		),
		'secondary' => array(
			'secondary' 		=> 'original',
			'secondary-alt-a'	=> 'alt',
			'secondary-alt-b'	=> 'alt',
			'secondary-alt-c'	=> 'alt',
			'secondary-alt-d'	=> 'alt',
		),
	);

	foreach ( $st_['colors'] as $group ) {

		foreach ( $group as $unit => $type ) {

			// If original colors
			if ( $type == 'original' ) {

				if ( !empty( $st_Settings['color-' . $unit] ) && $st_Settings['color-' . $unit] != $st_Options['panel']['style']['general']['colors'][$unit]['hex'] ) {

					// Select original color
					$st_['color'] = strpos( $unit, 'primary' ) !== false ? $primary : $secondary;

					// Get classes
					$classes = $st_Options['panel']['style']['general']['colors'][$unit];

					// Unset hex
					unset( $classes['hex'] );

					// Unset free
					$st_['free'] = !empty( $classes['free'] ) ? $classes['free'] : '';
					unset( $classes['free'] );

					// Rename incorrect attributes
					$st_['incorrect'] = array(
						'colors'		=> 'color',
						'backgrounds'	=> 'background-color',
						'border-top'	=> 'border-top-color',
						'border-right'	=> 'border-right-color',
						'border-bottom'	=> 'border-bottom-color',
						'border-left'	=> 'border-left-color',
					);

					foreach ( $st_['incorrect'] as $st_['key'] => $st_['value'] ) {

						if ( isset( $classes[$st_['key']] ) ) {

							$classes[$st_['value']] = $classes[$st_['key']];

							unset( $classes[$st_['key']] );

						}

					}

					// Classic
					foreach ( $classes as $key => $class ) {

						$st_['temp'] = '';
						$st_['title'] = "/*-------------------------------------------\n    " . ucwords( str_replace( '-', ' ', $unit . ": " . $key ) ) . "\n-------------------------------------------*/\n\n";

						if ( is_array( $class ) )
							foreach ( $class as $value )
								$st_['temp'] .= $value . ",\n";

						$css .= !empty( $st_['temp'] ) ? rtrim( $st_['title'] . $st_['temp'], ",\n" ) . " {\n  " . $key . ": #" . $st_['color'] . ";\n}\n\n\n" : '';

					}

					// Free
					if ( !empty( $st_['free'] ) ) {

						$st_['temp'] = '';
						$st_['title'] = "/*-------------------------------------------\n    " . ucwords( $unit . ": Free" ) . "\n-------------------------------------------*/\n\n";

						foreach ( $st_['free'] as $key )
							$st_['temp'] .= str_replace( '@@', '#' . $st_['color'], $key ) . "\n";

						$css .= !empty( $st_['temp'] ) ? $st_['title'] . $st_['temp'] . "\n\n" : '';

					}

				}

			}

			// It alternative colors
			if ( $type == 'alt' ) {

				$st_['unit'] = explode( '-', $unit );

				if ( !empty( $st_Settings['color-' . $st_['unit'][0]] ) && $st_Settings['color-' . $st_['unit'][0]] != $st_Options['panel']['style']['general']['colors'][$st_['unit'][0]]['hex'] ) {

					if ( !empty( $st_Options['panel']['style']['general']['colors'][$unit] ) ) {

						// Select original color
						$st_['color'] = strpos( $unit, 'primary' ) !== false ? $primary : $secondary;
	
						// Get alternative color
						$st_['color_alt'] = st_adjustBrightness( $st_['color'], $st_Options['panel']['style']['general']['colors'][$unit]['steps'] );
	
						// Get classes
						$classes = $st_Options['panel']['style']['general']['colors'][$unit];
	
						// Unset steps
						unset( $classes['steps'] );
	
						// Unset free
						$st_['free'] = !empty( $classes['free'] ) ? $classes['free'] : '';
						unset( $classes['free'] );
	
						// Rename incorrect attributes
						$st_['incorrect'] = array(
							'colors'		=> 'color',
							'backgrounds'	=> 'background-color',
							'border-top'	=> 'border-top-color',
							'border-right'	=> 'border-right-color',
							'border-bottom'	=> 'border-bottom-color',
							'border-left'	=> 'border-left-color',
						);
	
						foreach ( $st_['incorrect'] as $st_['key'] => $st_['value'] ) {
	
							if ( isset( $classes[$st_['key']] ) ) {
	
								$classes[$st_['value']] = $classes[$st_['key']];
	
								unset( $classes[$st_['key']] );
	
							}
	
						}
			
						// Classic
						foreach ( $classes as $key => $class ) {
	
							$st_['temp'] = '';
							$st_['title'] = "/*-------------------------------------------\n    " . ucwords( str_replace( '-', ' ', $unit . ": " . $key ) ) . "\n-------------------------------------------*/\n\n";
	
							foreach ( $class as $value )
								$st_['temp'] .= $value . ",\n";
	
							$css .= !empty( $st_['temp'] ) ? rtrim( $st_['title'] . $st_['temp'], ",\n" ) . " {\n  " . $key . ": #" . $st_['color_alt'] . ";\n}\n\n\n" : '';
	
						}
	
						// Free
						if ( !empty( $st_['free'] ) ) {
	
							$st_['temp'] = '';
							$st_['title'] = "/*-------------------------------------------\n    " . ucwords( str_replace( '-', ' ', $unit . ": Free" ) ) . "\n-------------------------------------------*/\n\n";
	
							foreach ( $st_['free'] as $key )
								$st_['temp'] .= str_replace( '@@', '#' . $st_['color_alt'], $key ) . "\n";
	
							$css .= !empty( $st_['temp'] ) ? $st_['title'] . $st_['temp'] . "\n\n" : '';
	
						}
	
					}

				}

			}

		}

	}


	/*-------------------------------------------
		2.2 - Custom CSS
	-------------------------------------------*/

	if ( !empty( $st_Settings['custom_css'] ) )
		$css .= "/*-------------------------------------------\n    Custom styles\n-------------------------------------------*/\n\n" . $st_Settings['custom_css'];



/*===============================================

	W R I T E   A   F I L E
	Create CSS file

===============================================*/

	$path = st_get_custom_css('path');

	$file = fopen( $path, 'w+' ) or die( __( 'Cannot open CSS file', 'stkit' ) );

	fwrite( $file, $css );

	fclose( $file );

}

st_write_custom_css();

?>