<?php
// Menus -> adds extra fields for abbreviated text
// - these are added as attributes, data-abbrev and data-orig

// - also want to add aria-expanded="false" to items with children. Not necessarily items with abbrev.
// - solution: add a note in admin screen to remind user to add an abbrev to items with children

// https://gist.github.com/kucrut/3804376

add_action( 'init', array( 'XTeam_Nav_Menu_Item_Custom_Fields', 'setup' ) );
class XTeam_Nav_Menu_Item_Custom_Fields {
	static $options = array(
		'item_tpl' => '
			<p class="additional-menu-field-{name} description description-thin">
				<label for="edit-menu-item-{name}-{id}">
					{label}<br>
					<input
					type="{input_type}"
					id="edit-menu-item-{name}-{id}"
					class="widefat code edit-menu-item-{name}"
					name="menu-item-{name}[{id}]"
					value="{value}">
				</label>
			</p>
		',
	);
	// setup function
	static function setup() {
		if ( !is_admin() )
			return;
		$new_fields = apply_filters( 'xteam_nav_menu_item_additional_fields', array() );
		if ( empty($new_fields) )
			return;
		self::$options['fields'] = self::get_fields_schema( $new_fields );
		add_filter( 'wp_edit_nav_menu_walker', function () {
			return 'XTeam_Walker_Nav_Menu_Edit';
		});
		add_action( 'save_post', array( __CLASS__, '_save_post' ), 10, 2 );
	}
	static function get_fields_schema( $new_fields ) {
		$schema = array();
		foreach( $new_fields as $name => $field) {
			if (empty($field['name'])) {
				$field['name'] = $name;
			}
			$schema[] = $field;
		}
		return $schema;
	}
	static function get_menu_item_postmeta_key($name) {
		return '_menu_item_' . $name;
	}
	// Inject the @hook {action} save_post
	static function get_field( $item, $depth, $args ) {
		$new_fields = '';
		foreach( self::$options['fields'] as $field ) {
			$field['value'] = get_post_meta($item->ID, self::get_menu_item_postmeta_key($field['name']), true);
			$field['id'] = $item->ID;
			$new_fields .= str_replace(
				array_map(function($key){ return '{' . $key . '}'; }, array_keys($field)),
				array_values(array_map('esc_attr', $field)),
				self::$options['item_tpl']
			);
		}
		return $new_fields;
	}
	// Save the newly submitted fields @hook {action} save_post
	static function _save_post($post_id, $post) {
		if ( $post->post_type !== 'nav_menu_item' ) {
			return $post_id; // prevent weird things from happening
		}
		foreach( self::$options['fields'] as $field_schema ) {
			$form_field_name = 'menu-item-' . $field_schema['name'];
			// @todo FALSE should always be used as the default $value, otherwise we wouldn't be able to clear checkboxes
			if (isset($_POST[$form_field_name][$post_id])) {
				$key = self::get_menu_item_postmeta_key($field_schema['name']);
				$value = stripslashes($_POST[$form_field_name][$post_id]);
				update_post_meta($post_id, $key, $value);
			}
		}
	}
}
// @todo This class needs to be in it's own file so we can include id J.I.T.
// requiring the nav-menu.php file on every page load is not so wise
require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
class XTeam_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$item_output = '';
		parent::start_el($item_output, $item, $depth, $args);
		if ( $new_fields = XTeam_Nav_Menu_Item_Custom_Fields::get_field( $item, $depth, $args ) ) {
			$item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $new_fields, $item_output);
		}
		$output .= $item_output;
	}
}

// Add extra fields here, specifying the 
add_filter( 'xteam_nav_menu_item_additional_fields', 'mytheme_menu_item_additional_fields' );
function mytheme_menu_item_additional_fields( $fields ) {
	$fields['abbrev'] = array(
		'name' => 'abbrev',
		'label' => __('Abbreviation', 'xteam'),
		'container_class' => 'abbrev-text',
		'input_type' => 'text',
    );
	
	return $fields;
}


// data-attributes - used for abbreviated menu items
// - use on the front end -> outputs in the anchor tag
add_filter( 'nav_menu_link_attributes', 'my_nav_menu_attribs', 10, 3 );
function my_nav_menu_attribs( $atts, $item, $args ) {  
    $atts['data-abbrev'] = get_post_meta($item->ID, '_menu_item_abbrev', true); // abbreviated title
	$atts['data-orig'] = $item->post_title; // original title
	// add aria-expanded
	// if ( $args->has_children ) {
	$atts['aria-expanded'] = 'false';
	// }
  return $atts;
}

?>