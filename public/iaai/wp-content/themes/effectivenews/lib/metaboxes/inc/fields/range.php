<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) 
{
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

if ( ! class_exists( 'RWMB_Range_Field' ) )
{
	class RWMB_Range_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_print_styles()
		{
		
			//$url = EFF_URI . '/lib/metaboxes/js';
			//wp_enqueue_script( 'jq-tools', "{$url}/jquery.tools.min.js");
		}

		/**
		 * Get div HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			$id	     = " id='{$field['id']}'";
			$name	 = "name='{$field['field_name']}'";
			if (isset($field['min'])) {
			$min	 = "min='{$field['min']}'";
			}

			if (isset($field['max'])) {
			$max	 = "max='{$field['max']}'";
			}

			if (isset($field['step'])) {
			$step	 = "step='{$field['step']}'";
			}

			if (isset($field['suffix'])) {
			$suffix = '<span class="suffix">'. $field['suffix'] .'</span>';
			}

			$val     = " value='{$meta}'";
			$for     = " for='{$field['id']}'";
			$format	 = " rel='{$field['format']}'";
			$html   .= "
				<div class='clearfix'>
					<input type='range' class='rwmb-range'{$format}{$id}{$name}{$val}{$min}{$max}{$step}> $suffix
				</div>";

			return $html;
		}
	}
}