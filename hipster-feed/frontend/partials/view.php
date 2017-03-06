<?php

$output .= '<div class="hipster-feed-slider owl-carousel">';

    foreach ($instas as $insta) {
        $type    = $insta->type;
        $link    = $insta->link;
        $image   = $insta->images->standard_resolution->url;
        $caption = $insta->caption->text;

        if ($type === 'image') {
            $output .= '<div class="item"><a href="' . $link . '" target="_blank"><img src="' . $image . '" alt="' . $caption . '"></a></div>';
        }
    }

$output .= '</div>';
