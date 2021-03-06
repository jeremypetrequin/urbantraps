<?php
	
// vars
global $post;
		
// get options
$options = $this->get_acf_options($post->ID);
	
?>
<table class="acf_input widefat" id="acf_options">
	<tr>
		<td class="label">
			<label for=""><?php _e("Order No.",'acf'); ?></label>
			<p class="description"><?php _e("Field groups are created in order <br />from lowest to highest.",'acf'); ?></p>
		</td>
		<td>
			<?php 
			
			$this->create_field(array(
				'type'	=>	'text',
				'name'	=>	'menu_order',
				'value'	=>	$post->menu_order,
			));
			
			?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<label for=""><?php _e("Position",'acf'); ?></label>
		</td>
		<td>
			<?php 
			
			$this->create_field(array(
				'type'	=>	'radio',
				'name'	=>	'options[position]',
				'value'	=>	$options['position'],
				'choices' => array(
					'normal'	=>	__("Normal",'acf'),
					'side'		=>	__("Side",'acf'),
				)
			));

			?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<label for="post_type"><?php _e("Style",'acf'); ?></label>
		</td>
		<td>
			<?php 
			
			$this->create_field(array(
				'type'	=>	'radio',
				'name'	=>	'options[layout]',
				'value'	=>	$options['layout'],
				'choices' => array(
					'default'	=>	__("Standard Metabox",'acf'),
					'no_box'	=>	__("No Metabox",'acf'),
				)
			));
			
			?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<label for="post_type"><?php _e("Show on page",'acf'); ?></label>
			<p class="description"><?php _e("Deselect items to hide them on the edit page",'acf'); ?></p>
			<p class="description"><?php _e("If multiple ACF groups appear on an edit page, the first ACF group's options will be used. The first ACF group is the one with the lowest order number.",'acf'); ?></p>
		</td>
		<td>
			<?php 
			
			$this->create_field(array(
				'type'	=>	'checkbox',
				'name'	=>	'options[show_on_page]',
				'value'	=>	$options['show_on_page'],
				'choices' => array(
					'the_content'	=>	__("Content Editor",'acf'),
					'custom_fields'	=>	__("Custom Fields",'acf'),
					'discussion'	=>	__("Discussion",'acf'),
					'comments'		=>	__("Comments",'acf'),
					'slug'			=>	__("Slug",'acf'),
					'author'		=>	__("Author",'acf')
				)
			));
			
			?>
		</td>
	</tr>
		
</table>