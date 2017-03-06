<div class="hipster-feed-slider owl-carousel">

    <?php foreach ($instas as $insta) : ?>

        <?php
        $type    = $insta->type;
        $link    = $insta->link;
        $image   = $insta->images->standard_resolution->url;
        $caption = $insta->caption->text;
        ?>

        <?php if ($type === 'image') : ?>
            <div class="item"><a href="<?= $link ?>" target="_blank"><img src="<?= $image ?>" alt="<?= $caption ?>"></a></div>
        <?php endif; ?>

    <?php endforeach; ?>

</div>
