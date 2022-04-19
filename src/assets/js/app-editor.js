wp.domReady( function() {
  
	wp.blocks.unregisterBlockStyle(
		'core/button',
		[ 'default', 'outline', 'squared', 'fill' ]
	);

	wp.blocks.registerBlockStyle(
		'core/button',
		[
			{
				name: 'default',
				label: 'Default',
				isDefault: true
			},
			{
				name: 'outline',
				label: 'Outline',
			},
			{
				name: 'dark',
				label: 'Dark',
			}
		]
	);

	wp.blocks.registerBlockStyle(
		'core/group',
		[
			{
				name: 'default',
				label: 'Default',
				isDefault: true,
			},
			{
				name: 'dotted-bg',
				label: 'Dotted Background'
			},
			{
				name: 'woodgrain-bg',
				label: 'Woodgrain Background'
			},
		]
	);

	wp.blocks.registerBlockStyle(
		'core/cover',
		[
			{
				name: 'default',
				label: 'Default',
				isDefault: true,
			},
			{
				name: 'hero',
				label: 'Home Hero Section'
			},
			{
				name: 'hero-inside',
				label: 'Inside Page Hero Section'
			},
			{
				name: 'hero-dark',
				label: 'Dark Hero Section'
			},
			{
				name: 'content',
				label: 'Content Section'
			},
			{
				name: 'testimonial',
				label: 'Testimonial'
			},
			{
				name: 'members',
				label: 'Members Of Section'
			},
			{
				name: 'contact-intro',
				label: 'Contact Intro Section'
			}
		]
	);

	wp.blocks.registerBlockStyle(
		'core/list',
		[
			{
				name: 'default',
				label: 'Default',
				isDefault: true,
			},
			{
				name: 'styled',
				label: 'Styled List'
			},
			{
				name: 'styled-full',
				label: 'Styled List Full Lines'
			}
		]
	);

	wp.blocks.registerBlockStyle(
		'core/media-text',
		[
			{
				name: 'default',
				label: 'Default',
				isDefault: true,
			},
			{
				name: 'hero',
				label: 'Page Hero'
			}
		]
	);
  
} );
  
wp.hooks.addFilter(
  'blocks.registerBlockType',
  'epiqk/alter-core-blocks',
  function( settings ) {
    
    if ( settings.name === 'core/button' ) {
      // console.dir( settings );
    }
    
    return settings;
    
  }
);