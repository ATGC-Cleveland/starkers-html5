<?php
/**
 * The loop that displays a page.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.2
 */
?>

<?php get_header(); ?>

	<h1>JSON Schema Testing</h1>
	
	<?php
	
		$json = file_get_contents( get_template_directory() . '/schemas/client.json' );
		
		$schema = json_decode($json);
		
		//var_dump($schema);
		
		process_schema( $schema );
		
		
		/**
		 * Traverse JSON schema to find any $ref pointers
		 *
		 * * This function currently implements a recursive function
		 * * I feel like it should use the SPL iterative functions
		 * * but I'm having trouble implementing them and all my reading
		 * * says that it would actually be slower.
		 *
		 * @uses json_expand_refs
		 */
		
		function json_locate_refs( $schema_obj , $header = "" ) {
			
			// locate ref pointers and call json_expand_refs t0 replace JSON Schema Object Node with JSON Schema
			
			if ( isset( $schema_obj->schema ) ) {
			
				// we are at the root level of properties
				
				foreach ( $schema_obj->schema->properties as $key => $value ) {
					
					if ( isset( $value->properties ) ) {
						// echo $key . ' has additional properties.<br />';
						json_locate_refs( $value , $key );
					}
					
					if ( isset( $value->{'$ref'} ) ) {
						echo 'I found a JSON ref pointer in ' . $key . '<br />';
					}
					
				}
				
			} else {
			
				foreach ( $schema_obj->properties as $key => $value ) {
				
					//var_dump($key);
					//var_dump($value);
					
					if ( isset( $value->properties ) ) {
						// echo $key . ' has additional properties.<br />';
						json_locate_refs( $value );
					}
					
					if ( $key == '$ref' ) {
						echo 'I found a JSON ref pointer in ' . $header . '<br />';
					}
					
				}
				
			}
			
		}
		
		
		/**
		 * replace JSON Schema ref pointer by:
		 *
		 *     1) calling json_parse_ref find replacement JSON Schema Object
		 *     2) calling json_get_schema to pull JSON string into a variable
		 *     3) replacing ref pointer with JSON string
		 *
		 * @uses json_parse_ref
		 * @uses json_get_schema
		 */
		
		function json_expand_refs() {
			
			
			
		}
		
		function json_parse_ref() {}
		
		function json_get_schema() {}
		
		function process_schema( $schema_obj ) {
		
			// check to make sure the json data has a schema object to work with
			// convert this to use Exceptions later
			
			if ( isset( $schema_obj->schema ) ) {
			
				$processed_json = json_locate_refs( $schema_obj );
			
			} else {
			
				echo 'It appears the JSON Schema you are attempting to use does not contain a schema object.<br />';
				
			}
			
		}
		
		/*
		foreach ( $data->properties as $key => $value ) {
			$list = get_object_vars($value);
			
			if ( array_key_exists( '$ref' , $list ) ) {
				// echo 'There is a reference pointer constraint in ' . $key . ' property.<br />';
				
				//var_dump($list[ '$ref' ]);*/
				
				/**
				 *    found a ref pointer...now need to find the file
				 *    The file location should be a string value
				 *    Will always be contained in the 'schemas' folder of the theme directory.
				 *    Needs to handle uri's that are in subfolders.
				 *    Needs to only search for external file if pointer doesn't start with #.
				 *    RULE: ref pointer objects will be found under 'definitions' object when ref pointer starts
				 *          with # and is located in the same document.
				 *    RULE: All external schema URI's will be relative to the 'schema' directory.
				 *    RULE: External schemas with multiple definitions will be references by a pointer structured as
				 *          schema.json#definition
				 *    TODO: Need code to handle these three different situations.
				 */
				
				/*$pointer = file_get_contents( get_template_directory() . '/schemas/' . $list['$ref'] );
				
				//var_dump($pointer);
				
				$pointer = json_decode($pointer);
				
				//var_dump($pointer);
				
				$data->properties->$key = $pointer;
				
			} else {
				echo 'There is no reference pointer constraint in ' . $key . ' property.<br />';
			}
		}*/
		
		
		//var_dump($data);
			
	?>

<?php get_footer(); ?>