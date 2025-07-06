<?php
$hero_titles = get_sub_field('hero_titles');
$subtitle = get_sub_field('subtitle');
$background_image = get_sub_field('background_image');
?>

<section class="hero" style="background-image: url('<?php echo esc_url($background_image['url']); ?>');">
    <div class="container">
        <div class="title">
            <?php
            foreach ($hero_titles as $key => $value):
// prd($value);
                echo '<span>' . esc_html($value['title']) . '</span>';
                if ($key < count($hero_titles) - 1) {
                    echo '<span class="dot"> • </span>';
                }
            endforeach;
            ?>
        </div>
        <div class="description"><?php echo esc_html($subtitle); ?></div>
    </div>
</section>