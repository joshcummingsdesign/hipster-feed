<?php

/*****************************************
* Public content
/****************************************/

?>

<?php include 'app.php'; ?>

<?php if ( !empty( $options['token'] ) ) : ?>

		<?php foreach ($image_data as $link => $img_url) : ?>

			<div><a href="<?php echo $link; ?>"><img src="<?php echo $img_url; ?>" alt="instagram photo"></a></div>

		<?php endforeach; ?>

<?php endif; ?>
