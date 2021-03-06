<?php
/**
 * The loop that displays a page.
 *
 * @package WordPress
 * @subpackage Purple Sun
 * @since Starkers HTML5 3.2
 */
?>

<?php //get_header(); ?>

	<h1>Form Factory Demo</h1>
	
	<h2>Form Factory Plugin Status</h2>
	
	<?php if ( atgc_purple__dep_plugins_loaded( 'Form Factory' ) ) : ?>
	
		<p>Congratulations, Form Factory is successfully loaded!</p>
	
	<!-- <h2>Testing JSON Extended class functions</h2> -->
	
	<?php
	
		//$json_extended = new TW_JsonExtended( 'client2' );
		
		//$json_extended->iterateSPL();
		
	?>
	
	<h2>TW_JsonForma Class Demo</h2>
	
	<?php
	
		$form = new TW_JsonForma( 'client2' );

		$form->render();
		
		//var_dump($form->json);
		var_dump($form->fields);
		
	?>
	
	
	<?php else : ?>
	
		<p>Bummer, Form Factory is not loaded.</p>
	
	<?php endif; ?>

<?php get_footer(); ?>