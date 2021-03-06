/**
 * @tableofcontents
 *
 * 1. maps
 *
 * @since 2.0
 *
 * @package Redaxscript
 * @author Henry Ruhs
 */

/* @section 1. maps */

r.modules.maps =
{
	startup: true,
	selector: 'div.js_map',
	options:
	{
		classString:
		{
			mapMeta: 'js_map_meta map_meta',
			mapLogo: 'js_map_logo map_logo',
			mapTerms: 'js_map_terms map_terms'
		},
		general:
		{
			zoom: 2,
			center: new google.maps.LatLng(20, 0),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: false,
			panControl: true,
			scaleControl: false,
			streetViewControl: false,
			overviewMapControl: false,
			zoomControl: true
		},
		styles:
		[
			{
				featureType: 'all',
				stylers:
				[
					{
						saturation: -100
					}
				]
			},
			{
				featureType: 'poi',
				stylers:
				[
					{
						visibility: 'off'
					}
				]
			},
			{
				featureType: 'transit',
				stylers:
				[
					{
						visibility: 'off'
					}
				]
			},
			{
				featureType: 'road.highway',
				elementType: 'labels',
				stylers:
				[
					{
						visibility: 'off'
					}
				]
			},
			{
				featureType: 'water',
				stylers:
				[
					{
						color: '#0090db'
					}
				]
			}
		],
		marker: true,
		replaceBranding: true,
		mapLogo: '<a href="http://maps.google.com" target="_blank">Google Maps</a>',
		mapTerms: '<a href="http://www.google.com/intl/en-US_US/help/terms_maps.html" target="_blank">Terms of use</a>'
	}
};