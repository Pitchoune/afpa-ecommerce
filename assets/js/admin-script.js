// ************************************************
// Sidebar menu
// ************************************************

// When there is a click on a link in the sidebar
$('.sidebar-menu').on('click', 'li a', function(e)
{
	// If there is a submenu opened
	if ($(this).next().is('.sidebar-submenu') && $(this).next().is(':visible'))
	{
		// Hide the menu in 0.3s
		$(this).next().slideUp(300, function()
		{
			$(this).next().removeClass('menu-open');
		});

		// Remove the active part of the link
		$(this).next().parent("li").removeClass("active");
	}
	// If there is a submenu closed
	else if (($(this).next().is('.sidebar-submenu')) && (!$(this).next().is(':visible')))
	{
		$(this).parents('ul').first().find('ul:visible').slideUp(300).removeClass('menu-open');

		// Show the menu in 0.3s
		$(this).next().slideDown(300, function()
		{
			$(this).next().addClass('menu-open');
			$(this).parents('ul').first().find('li.active').removeClass('active');
			$(this).parent('li').addClass('active');
		});
	}

	// If there is a submenu, don't go to the defined url of the opening menu link
	if ($(this).next().is('.sidebar-submenu'))
	{
		e.preventDefault();
	}
});

// Hide or show sidebar on switch click
$('#sidebar-toggle').click(function()
{
	$('.page-sidebar').toggleClass('open');
});

// responsive part
$(document).ready(function()
{
	"use strict";

	// If the window size is less than 991 pixels
	if ($(window).width() + 17 <= 991)
	{
		// Reduce the sidebar width
		$('#sidebar-toggle').addClass('open');
		$('.page-sidebar').addClass('open');
	}
	else
	{
		// Enlarge the sidebar width
		$('#sidebar-toggle').removeClass('open');
		$('.page-sidebar').removeClass('open');
	}
});

// Check if the window has been resized
$(window).resize(function()
{
	// If the window size is less than 991 pixels
	if ($(window).width() + 17 <= 991)
	{
		// Reduce the sidebar width
		$('#sidebar-toggle').addClass('open');
		$('.page-sidebar').addClass('open');
	}
	else
	{
		// Enlarge the sidebar width
		$('#sidebar-toggle').removeClass('open');
		$('.page-sidebar').removeClass('open');
	}
});

// Close all sidebar menus
$('.sidebar-menu').find('a').removeClass('active');
$('.sidebar-menu').find('li').removeClass('active');

// Filter all sidebar links
$('.sidebar-menu > li a').filter(function()
{
	// Check if the <a> link exists
	if ($(this).attr('href'))
	{
		// Checks if the url link matches the current url
		if (window.location.href.indexOf($(this).attr('href')) != -1)
		{
			// Keep the parent <li> opened with the current link more visible
			$(this).parents('li').addClass('active');
			$(this).addClass('active');
		}
	}
});

// ************************************************
// Full page on click
// ************************************************

function toggleFullScreen()
{
	if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen))
	{
		if (document.documentElement.requestFullScreen)
		{
			document.documentElement.requestFullScreen();
		}
		else if (document.documentElement.mozRequestFullScreen)
		{
			document.documentElement.mozRequestFullScreen();
		}
		else if (document.documentElement.webkitRequestFullScreen)
		{
			document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
		}
	}
	else
	{
		if (document.cancelFullScreen)
		{
			document.cancelFullScreen();
		}
		else if (document.mozCancelFullScreen)
		{
			document.mozCancelFullScreen();
		}
		else if (document.webkitCancelFullScreen)
		{
			document.webkitCancelFullScreen();
		}
	}
}
