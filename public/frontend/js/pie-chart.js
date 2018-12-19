jQuery(function($) {
	'use strict';

	$('.pie-chart').waypoint(function() {
		// Fix for different ver of waypoints plugin.
		var _self = this.element ? this.element : $(this);
		var count_html = $(this).find('.piecharts-number');

		$(_self)
			.find('.chart')
			.circleProgress({
				startAngle: - Math.PI / 4 * 2,
				animation: { duration: 1700 }
			})
			.on('circle-animation-progress', function(event, progress) {

				count_html.html(parseInt((count_html.data( 'max' )) * progress) + '<span>' + count_html.data('units') + '</span>');
			});
	},{
		offset: '100%',
		triggerOnce: true
	});
});
