<?php

/*****************************************
* Public content
/****************************************/

?>

<?php include 'app.php'; ?>

<?php if ( isset( $options['token'] ) ) : ?>

<div class="owl-wrapper">
	<div class="owl-carousel">

		<?php foreach ($image_data as $a => $img) : ?>

			<div><a href="<?php echo $a; ?>"><img src="<?php echo $img; ?>" alt="instagram photo"></a></div>

		<?php endforeach; ?>

	</div>
</div>

<?php endif; ?>
