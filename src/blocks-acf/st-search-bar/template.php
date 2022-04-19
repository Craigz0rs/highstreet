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

$cities = get_terms( array(
    'post_type' => 'properties',
    'orderby'   => 'name',
    'order'     => 'ASC',
    'taxonomy'  => 'locations',
    'hide_empty'=> false
) );

?>
<div class="search-bar">
    <form id="search-bar" action="<?php echo get_post_type_archive_link('properties'); ?>" role="search" method="get">
        <div class="search-bar__field-wrap">
            <select id="city" name="city">
                <option value="">Select a City</option>
                <?php foreach($cities as $cat) : ?>
                    <option value="<?php echo $cat->term_id; ?>"<?php if($_GET['city'] && $_GET['city'] == $cat->term_id) { echo ' selected'; } ?>><?php echo $cat->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="search-bar__field-wrap date-wrap">
            <label for="arrival">Arrival</label>
            <input type="date" value="" name="arrival" id="arrival">
        </div>
        <div class="search-bar__field-wrap date-wrap">
            <label for="departure">Departure</label>
            <input type="date" value="" name="departure" id="departure">
        </div>
        <div class="search-bar__field-wrap number-wrap">
            <label for="beds">Guests</label>
            <button id="bed-sub" class="search-bar__subtract">-</button>
            <input type="number" id="beds" name="beds" min="1" value="1">
            <button id="bed-plus" class="search-bar__plus">+</button>
        </div>
        <div class="search-bar__field-wrap">
            <input type="text" id="propid" name="propid" placeholder="PROPERTY ID">
        </div>
        <div class="search-bar__field-wrap">
            <input type="hidden" name="post_type" value="properties" />
            <input type="submit" id="property" name="property" value="SEARCH">
        </div>
    </form>
</div>