<?php defined( 'ABSPATH' ) || die( 'Direct file access is prohibited.' ); ?>


<?php get_header(); 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$cities = get_terms( array(
    'post_type' => 'properties',
    'orderby'   => 'name',
    'order'     => 'ASC',
    'taxonomy'  => 'locations',
    'hide_empty'=> false
) );

$map_locations = [];

$city_id = '';
$current_city = esc_html(get_field('google_location', $city_id));

?>

<main id="site-main" class="site-main">
    <div class="wp-block-group is-style-dotted-bg">
        <div class="wp-block-group__inner-container">
            <div class="search-bar">
                <form id="search-bar" method="GET" action="<?php echo get_post_type_archive_link('properties'); ?>">
                    <div class="search-bar__field-wrap">
                        <select id="city" name="city">
                            <option value="">Select a City</option>
                            <?php foreach($cities as $cat) : ?>
                                <option value="<?php echo $cat->term_id; ?>"<?php if($_GET['city'] && $_GET['city'] == $cat->term_id) { echo ' selected'; $city_id = $cat->term_id; } ?>><?php echo $cat->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="search-bar__field-wrap number-wrap">
                        <label for="beds">Beds</label>
                        <button id="bed-sub" class="search-bar__subtract">-</button>
                        <input type="number" id="beds" name="beds" min="0" value="<?php if($_GET['beds'] && $_GET['beds'] >= 0 ) { echo $_GET['beds']; } else { echo 1; } ?>">
                        <button id="bed-plus" class="search-bar__plus">+</button>
                    </div>
                    <div class="search-bar__field-wrap number-wrap">
                        <label for="baths">Baths</label>
                        <button id="bath-sub" class="search-bar__subtract">-</button>
                        <input type="number" id="baths" name="baths" min="1" value="<?php if($_GET['baths'] && $_GET['baths'] >= 0 ) { echo $_GET['baths']; } else { echo 1; } ?>">
                        <button id="bath-plus" class="search-bar__plus">+</button>
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
        </div>
    </div>
    <div class="wp-block-group" id="property-list">
        <div class="wp-block-group__inner-container property__wrap">
            <?php if ( have_posts() ): ?>
                <div class="property__results-count-wrap">
                    <?php $num = $wp_query->post_count; ?>
                    <p class="property__results-count">Showing <?php echo $num; if(1 == $num) { echo ' property.'; } else { echo ' properties.'; } ?></p>
                </div>
                <div class="property__results">
                    <ul class="property__list">
                        <?php
                            while ( have_posts() ) :
                                the_post(); 

                                $map_locations[] = [
                                    'location' => esc_html(get_field('google_location', $post)),
                                    'id' => get_the_id()
                                ];
                        ?>
                            <li class="property__listing content">
                                <article class="property__teaser">
                                    <div class="property__teaser__heading">
                                        <h2>
                                            <?php echo the_title(); ?>
                                        </h2>
                                        <p><?php echo esc_html(get_field('location', $post)); ?></p>
                                    </div>
                                    <div class="property__teaser__top">
                                        <div class="property__teaser__image-wrap">
                                            <?php echo get_the_post_thumbnail( $post, 'large' ); ?>
                                        </div>
                                        <div class="property__teaser__feature-wrap">
                                            <?php echo get_field('features', $post); ?>
                                            <div class="property__teaser__rate<?php if(get_field('on_sale', $post)) { echo ' sale'; } ?>">
                                                <?php echo get_field('rate', $post); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="property__teaser__content-wrap">
                                        <?php echo get_field('description', $post); ?>
                                        <?php
                                            $link = get_field('link', $post);
                                            if($link): 
                                                $link_url = $link['url'];
                                                $link_target = $link['target'] ? $link['target'] : '_self';
                                                $link_title = $link['title'];
                                        ?>
                                            <div class="wp-block-buttons">
                                                <div class="wp-block-button intersected is-style-outline">
                                                    <a class="wp-block-button__link" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                </article>
                            </li>
                        <?php endwhile; ?>

                        
                    </ul>
                    <div class="next-page-link-wrapper wp-block-button" data-page-current="<?php echo $paged; ?>" data-per-page="<?php echo get_option('posts_per_page'); ?>"><?php print get_next_posts_link(); ?></div>
                </div>
                <div class="property__map">
                    <script>
                        function initMap() {
                            //vancouver city hall address
                            var lat = 49.2608173;
                            var lng = -123.1162113;

                            var map = new google.maps.Map(document.getElementById('locations-map'), {
                                zoom: 11,
                                center: {lat: lat, lng: lng},
                                mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',],
                                mapTypeControl: false,
                                streetViewControl: false,
                                rotateControl: false,
                                
                            });

                            <?php
                                // if( $city_id ) {
                                //     echo 'var js_city = "' . $current_city . '";';
                                // } else {
                                //     echo 'var js_city = "Vancouver City Hall Vancouver BC";';
                                // }
                            ?>

                            // var cityrequest = {
                            //     query: js_city
                            // };

                            // var cityservice = new google.maps.places.PlacesService(map);
                            // cityservice.textSearch(cityrequest, citycallback);

                            // function citycallback(results, status) {
                            //     if (status == google.maps.places.PlacesServiceStatus.OK) {
                            //         var marker = new google.maps.Marker({
                            //             map: map,
                            //             position: results[0].geometry.location,
                            //         });
                            //         marker.setVisible(false);
                            //         map.setCenter(marker.getPosition());
                            //     }
                            // }

                            var bounds = new google.maps.LatLngBounds();

                            <?php 
                                $js_locations = json_encode($map_locations);
                                echo 'var js_locations = ' . $js_locations . ';';
                            ?>

                            js_locations.forEach(function(e) {
                                var request = {
                                    location: map.getCenter(),
                                    radius: '500',
                                    query: e.location
                                };
    
                                var service = new google.maps.places.PlacesService(map);
                                service.textSearch(request, callback);
                                
                            });   
                            
                            var icon = {
                                url: '/wp-content/themes/epiqk/assets/images/marker.svg',
                                scaledSize: new google.maps.Size( 27, 37 ),
                                anchor: new google.maps.Point( 13.5, 18.5 )
                            }
     
                            function callback(results, status) {
                                if (status == google.maps.places.PlacesServiceStatus.OK) {
                                    var marker = new google.maps.Marker({
                                        map: map,
                                        place: {
                                            placeId: results[0].place_id,
                                            location: results[0].geometry.location
                                        },
                                        position: results[0].geometry.location,
                                        icon: icon
                                    });
                                    bounds.extend(marker.position);
                                    map.fitBounds(bounds);     
                                    
                                    if (map.getZoom() > 11) {
                                        map.setZoom(12);
                                    }
                                }
                            }

                            (function() {
                                setTimeout(function() {
                                    map.setCenter(bounds.getCenter());

                                    if (map.getZoom() > 11) {
                                        map.setZoom(12);
                                    }
                                    console.log('centered');
                                }, 1000)
                            })();
                        }

                    </script>
                    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-Z-kQ4DztX0Bq1czudA_HmJmQPTmlgJ8&callback=initMap&libraries=places" type="text/javascript"></script>
                    <div id="locations-map" class="property__map__container"></div>
                </div>
            <?php else: ?>
                <p>Sorry, there are no properties matching your search. Please try again.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php print apply_filters( 'the_content', get_post( 284 )->post_content ); ?>
</main>

<?php get_footer(); ?>
