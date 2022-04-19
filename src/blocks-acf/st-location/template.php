<?php

/**
 * Epiqk Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$link = get_field('link');
$type = get_field('style_type');

?>
<div class="location<?php if('contact' == $type) { echo ' location--contact'; } ?>">
    <?php 
    if($link): 
        $link_url = $link['url'];
        $link_target = $link['target'] ? $link['target'] : '_self';
    endif; ?>

    <a <?php if($link) { echo 'href="' . $link_url . '" target="' . $link_target . '"'; } ?>>
        <div class="location__image">
            <?php echo wp_get_attachment_image(get_field('image'), 'large'); ?>
        </div>
        <div class="location__content">
            <?php echo get_field('content'); ?>
            <div class="wp-block-buttons">
                <div class="wp-block-button is-style-dark intersected">
                    <span class="wp-block-button__link">SEE MORE</span>
                </div>
            </div>
        </div>
    </a>
</div>