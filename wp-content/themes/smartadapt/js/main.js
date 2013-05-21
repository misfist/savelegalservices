jQuery(document).ready(function ($) {


    $('.toggle-topbar').click(function () {
        var container_expand = $(this).attr('href');
        var link = $(this);

        if ($('.show-container').attr('id') == container_expand.substring(1)) {
            $(container_expand).removeClass('show-container');
            $('.top-bar').height(45);

        } else if (!$('div').hasClass('show-container')) {
            $(container_expand).addClass('show-container');
            $('.top-bar').height(110);

        } else {
            $('.show-container').removeClass('show-container');
            $(container_expand).addClass('show-container');


            $('.top-bar').height(110);

        }

        if (link.hasClass('active-toggle')) {
            link.removeClass('active-toggle');
        } else {
            link.addClass('active-toggle');
        }

        return false;
    });

	if('embed'){

		$( "embed" ).each(function( index ) {
			var height = $(this).attr('height');
			var width = $(this).attr('width');

			$(this).width(width);
			$(this).height(height);
		});

	}
    $(window).load(function () {
        $('#page').height($('#wrapper').height());
    });
});








