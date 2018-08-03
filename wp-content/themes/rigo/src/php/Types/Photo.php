<?php
namespace Rigo\Types;
    
use WPAS\Types\BasePostType;

class Photo extends BasePostType{
    
    function initialize(){
        add_action('acf/init', array($this, 'add_photo_fields'));
    }
    
    function add_photo_fields() {
        
       acf_add_local_field_group(array(
        	'key' => 'group_1',
        	'title' => 'My Group',
        	'fields' => array (
        		array (
        			'key' => 'location',
        			'label' => 'Location',
        			'name' => 'location',
        			'type' => 'text',
        		),
        		array (
        			'key' => 'date_taken',
        			'label' => 'Date taken',
        			'name' => 'date_taken',
        			'type' => 'date_picker',
        		),
        		array (
        			'key' => 'caption',
        			'label' => 'Caption',
        			'name' => 'caption',
        			'type' => 'text',
        		),
        		array (
        			'key' => 'image',
        			'label' => 'Image',
        			'name' => 'image',
        			'type' => 'image',
        		),
        		array (
        			'key' => 'tags',
        			'label' => 'Tags',
        			'name' => 'tags',
        			'type' => 'taxonomy',
        		),
        	),
        	'location' => array (
        		array (
        			array (
        				'param' => 'post_type',
        				'operator' => '==',
        				'value' => 'photo',
        			),
        		),
        	),
        ));
            
    }

}

?>