$(document).ready(function()
{
	// ************************************************
	// Visibility of the search input if less than 1200px
	// ************************************************

	$('.search-overlay').hide();

	$('.close-mobile-search').on('click', function()
	{
		$('.search-overlay').fadeOut();
	});

	$('.mobile-search').on('click', function()
	{
		$('.search-overlay').show();
		$('.searchbar-input').addClass('open');
	});

	$('.close-searchbar').on('click', function()
	{
		$('.searchbar-input').removeClass('open');
	});

	// ************************************************
	// Display sticky header
	// ************************************************

	$(window).scroll(function()
	{
		// Make the header sticky if we are x pixels down from the top of the page
		if ($(this).scrollTop() > 200)
		{
			$('header').addClass('sticky');
		}
		else
		{
			$('header').removeClass('sticky');
		}
	});

	// ************************************************
	// Footer redesign on-the-fly
	// ************************************************

	if ($(window).width() < 767)
	{
		// On page load only...
		$('.footer-title h5').append('<span class="according-menu"></span>');

		$('.footer-title').on('click', function ()
		{
			$('.footer-title').removeClass('active');
			$('.footer-content').slideUp('normal');

			if ($(this).next().is(':hidden') == true)
			{
				$(this).addClass('active');
				$(this).next().slideDown('normal');
			}
		});

		$('.footer-content').hide();
	}
	else
	{
		$('.footer-content').show();
	}

	// ************************************************
	// Categories listing from responsive
	// ************************************************

	$('.toggle-nav').on('click', function()
	{
		// Show categories in the right sidebar
		$('.sm-horizontal').css('right', '0px');
	});

	$('.mobile-back').on('click', function()
	{
		// Hide categories in the right sidebar
		$('.sm-horizontal').css('right', '-410px');
	});

	// ************************************************
	// Smartmenus to show the categories with resolution
	// less than 1200px in the right of the window
	// ************************************************

	$(function()
	{
		$('#main-menu').smartmenus({
			subMenusSubOffsetX: 1,
			subMenusSubOffsetY: -8
		});
	});

	// ************************************************
	// Cart effect on the cart 'svg' in 'Add to cart' button
	// ************************************************

	$('#cartEffect').on('click', function(e)
	{
		// Change button text
		$('#cartEffect').html('<i class="fa fa-shopping-cart"></i> Ajouté au panier !');

		// Reset text after x seconds
		setTimeout(function()
		{
			$('#cartEffect').html('<i class="fa fa-shopping-cart"></i> Ajouter au panier');
		}, 5000);
	});

	// ************************************************
	// Categories listing - change design on-the-fly
	// ************************************************

	// List layout view
	$('.list-layout-view').on('click', function(e)
	{
		// Hide all grid stuff
		$('.collection-grid-view').children().css('opacity', '0');
		$('.product-wrapper-grid').css('opacity', '0.2');
		$('.shop-cart-ajax-loader').css('display', 'block');
		$('.product-wrapper-grid').addClass('list-view');
		$('.product-wrapper-grid').children().children().removeClass();
		$('.product-wrapper-grid').children().children().addClass('col-lg-12');

		setTimeout(function()
		{
			$('.product-wrapper-grid').css('opacity', '1');
			$('.shop-cart-ajax-loader').css('display', 'none');
		}, 500);
	});

	// Grid layout view - general
	$('.grid-layout-view').on('click', function(e)
	{
		$('.collection-grid-view').children().css('opacity', '1');
		$('.product-wrapper-grid').removeClass('list-view');
		$('.product-wrapper-grid').children().children().removeClass();
		$('.product-wrapper-grid').children().children().addClass('col-lg-3');
	});

	// Grid layout view - 2 products per line
	$('.product-2-layout-view').on('click', function(e)
	{
		if (!$('.product-wrapper-grid').hasClass('list-view'))
		{
			$('.product-wrapper-grid').children().children().removeClass();
			$('.product-wrapper-grid').children().children().addClass('col-lg-6');
		}
	});

	// Grid layout view - 3 products per line
	$('.product-3-layout-view').on('click', function(e)
	{
		if (!$('.product-wrapper-grid').hasClass("list-view"))
		{
			$('.product-wrapper-grid').children().children().removeClass();
			$('.product-wrapper-grid').children().children().addClass('col-lg-4');
		}
	});

	// Grid layout view - 4 products per line
	$('.product-4-layout-view').on('click', function(e)
	{
		if (!$('.product-wrapper-grid').hasClass("list-view"))
		{
			$('.product-wrapper-grid').children().children().removeClass();
			$('.product-wrapper-grid').children().children().addClass('col-lg-3');
		}
	});

	// Grid layout view - 6 products per line
	$('.product-6-layout-view').on('click', function(e)
	{
		if (!$('.product-wrapper-grid').hasClass('list-view'))
		{
			$('.product-wrapper-grid').children().children().removeClass();
			$('.product-wrapper-grid').children().children().addClass('col-lg-2');
		}
	});

	// ************************************************
	// Update quantity on -/+ click
	// ************************************************

	var qtyDecs = document.querySelectorAll('.qty-minus');
	var qtyIncs = document.querySelectorAll('.qty-plus');

	qtyDecs.forEach((qtyDec) => {
		qtyDec.addEventListener('click', function(e)
		{
			if (e.target.nextElementSibling.value == 1)
			{
				// If 1 was displayed, don't go to 0
				e.target.nextElementSiblingValue = 1;
			}
			else if (e.target.nextElementSibling.value > 0)
			{
				// For each '-' click, decrement quantity value
				e.target.nextElementSibling.value--;
			}
		});
	});

	qtyIncs.forEach((qtyDec) => {
		qtyDec.addEventListener('click', function(e)
		{
			// For each '+' click, increment quantity value
			e.target.previousElementSibling.value++;
		});
	});

	// ************************************************
	// Dashboard menu on resolution < 991px
	// ************************************************

	$('.account-sidebar').on('click', function(e)
	{
		$('.dashboard-left').css('left', '0');
	});

	$('.filter-back').on('click', function(e)
	{
		$('.dashboard-left').css('left', '-365px');
	});

	// ************************************************
	// Reload category page with new choice in URL (per page and sort by options)
	// ************************************************

	$('#perpage').on('change', function()
	{
		let regex = /(\?|&)pp=[0-9]+/;
		let location = window.location.href;

		if (regex.test(location))
		{
			window.location = location.replace(regex, '') + '&pp=' + $(this).val();
		}
		else
		{
			window.location = window.location.href + '&pp=' + $(this).val();
		}
	});

	$('#sortby').on('change', function() {
		let regex = /(\?|&)sortby=[a-zA-Z]+/;
		let location = window.location.href;

		if (regex.test(location))
		{
			window.location = location.replace(regex, '') + '&sortby=' + $(this).val();
		}
		else
		{
			window.location = window.location.href + '&sortby=' + $(this).val();
		}
	});

	// ************************************************
	// Slick bands on homepage for best sellers and new products
	// ************************************************

	$('.default').css('display', 'block');

	$('.media-slide-5').slick({
		autoplay: true,
		autoplaySpeed: 1000,
		dots: false,
		infinite: true,
		speed: 1000,
		slidesToShow: 5,
		centerPadding: '15px',
		responsive: [
			{
			breakpoint: 1470,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4,
					infinite: true
				}
			},
			{
			breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: true
				}
			},
			{
			breakpoint: 820,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					infinite: true
				}
			},
			{
			breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true
				}
			}
		]
	});

	// ************************************************
	// Back to top
	// ************************************************

	$(window).on('scroll', function()
	{
		if ($(this).scrollTop() > 600)
		{
			$('.tap-top').addClass('top-cls');
		}
		else
		{
			$('.tap-top').removeClass('top-cls');
		}
	});

	$('<div class="tap-top" style="display: block;"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 285 285" style="enable-background:new 0 0 285 285;" xml:space="preserve"><g><path d="M88.4,87.996c2.525-2.146,2.832-5.933,0.687-8.458C82.801,72.144,79.34,62.719,79.34,53c0-22.607,18.393-41,41-41c22.607,0,41,18.393,41,41c0,9.729-3.467,19.161-9.761,26.557c-2.148,2.523-1.843,6.311,0.681,8.458c1.129,0.961,2.511,1.431,3.886,1.431c1.698,0,3.386-0.717,4.572-2.111C168.858,77.77,173.34,65.576,173.34,53c0-29.225-23.775-53-53-53c-29.225,0-53,23.775-53,53c0,12.563,4.476,24.748,12.602,34.31C82.089,89.835,85.873,90.141,88.4,87.996z"/><path d="M120.186,41.201c13.228,0,23.812,8.105,27.313,19.879c0.761-2.562,1.176-5.271,1.176-8.08c0-15.649-12.685-28.335-28.335-28.335c-15.648,0-28.334,12.686-28.334,28.335c0,2.623,0.364,5.16,1.031,7.571C96.691,49.076,107.152,41.201,120.186,41.201z"/><path d="M234.21,169.856c-3.769-22.452-19.597-26.04-27.034-26.462c-2.342-0.133-4.516-1.32-5.801-3.282c-5.388-8.225-12.609-10.4-18.742-10.4c-4.405,0-8.249,1.122-10.449,1.932c-0.275,0.102-0.559,0.15-0.837,0.15c-0.87,0-1.701-0.47-2.163-1.262c-5.472-9.387-13.252-11.809-19.822-11.809c-3.824,0-7.237,0.82-9.548,1.564c-0.241,0.077-0.764,0.114-1.001,0.114c-1.256,0-2.637-1.03-2.637-2.376V69.753c0-11.035-8.224-16.552-16.5-16.552c-8.276,0-16.5,5.517-16.5,16.552v84.912c0,4.989-3.811,8.074-7.918,8.074c-2.495,0-4.899-1.138-6.552-3.678l-7.937-12.281c-3.508-5.788-8.576-8.188-13.625-8.189c-11.412-0.001-22.574,12.258-14.644,25.344l62.491,119.692c0.408,0.782,1.225,1.373,2.108,1.373h87.757c1.253,0,2.289-1.075,2.365-2.325l2.196-35.816c0.025-0.413,0.162-0.84,0.39-1.186C231.591,212.679,237.828,191.414,234.21,169.856z"/></g></svg></div>').appendTo($('body'));
		(function() {
		})();

	$('.tap-top').on('click', function()
	{
		$('html, body').animate({
			scrollTop: 0
		}, 600);

		return false;
	});

	// ************************************************
	// Page loader
	// ************************************************

	$('.loader-wrapper').fadeOut('slow', function()
	{
		// Once the document is fully loaded, remove the loader
		$(this).remove();
	});

	// ************************************************
	// GDPR system
	// ************************************************

	const apiUrl = 'https://yrg.ovh/mvc/controller/geoip.php';
	const cookieName = 'EcommerceCookiePolicyInformed';
	const cookieExpireDays = 365;

	// Creates cookie
	function setCookie(cname, cvalue, exdays)
	{
		let d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		var expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
	}

	// Gets the requested cookie content
	function getCookie(cname)
	{
		var name = cname + "=";
		var ca = document.cookie.split(';');

		for (var i = 0; i < ca.length; i++)
		{
			var c = ca[i];

			while (c.charAt(0) == ' ')
			{
				c = c.substring(1);
			}

			if (c.indexOf(name) != -1)
			{
				return c.substring(name.length, c.length);
			}
		}

		return "";
	}

	// Displays the cookie notice
	function showCookieNotice()
	{
		window.setTimeout(function()
		{
			$('.cookie-bar').addClass('show')
		}, 5000);

		$('.cookie-bar .btn, .cookie-bar .btn-close').on('click', function()
		{
			$('.cookie-bar').removeClass('show')
		});
	}

	function needCookieNotice(callback)
	{
		function success(result)
		{
			// check result and if we're in the EU, then call callback
			// from https://www.gov.uk/vat-eu-country-codes-vat-numbers-and-vat-in-other-languages
			var EUCountryCodes = ['AT','BE','BG','HR','CY','CZ','DK','EE','FI','FR','DE','EL','HU','IE','IT','LV','LT','LU','MT','NL','PL','PT','RO','SK','SI','ES','SE','ZZ'];

			if (result)
			{
				var isoCode = (result + '').toUpperCase();

				if (EUCountryCodes.indexOf(isoCode) != -1)
				{
					// cookie notice is needed, call callback
					callback();
				}
			}
			else
			{
				console.log("Result from API: '" + result + "'. Let's show the notice!");
				callback();
			}
		}

		function error(e)
		{
			// there was an error, since we don't know if we're in the EU
			// the err on the safe side and show the message
			if (console && console.log && typeof(console.log) == 'function')
			{
				console.log('GeoLoc error: ' + e);
			}
			callback();
		}

		function getIsoCode(url)
		{
			// Do an AJAX query to GeoIP2 to get the ISO code
			$.get(
				url,
				function(data, statusText, xhr)
				{
					var status = xhr.status;

					if (status == 200)
					{
						let response = xhr.responseJSON;
						success(response.isoCode);
					}
					else
					{
						error('HTTP Status: ' + status);
					}
				},
				'json'
			);
		};

		getIsoCode(apiUrl);
	}

	try
	{
		if (!getCookie(cookieName))
		{
			// No cookie? display the notice
			needCookieNotice(function()
			{
				showCookieNotice();

				$('.cookie-accept').click(function()
				{
					// If accepted, create the cookie
					setCookie(cookieName, '1', cookieExpireDays);
				});
			});
		}
	}
	catch(e){}

	// ************************************************
	// Predictive search
	// ************************************************

	// Execute the requested code each time the pressed key in the search input is up'd
	$('.autosuggest').keyup(function()
	{
		// Do the search only if there is any character - do nothing if all was removed
		if ($(this).val().length >= 1)
		{
			// Get the search query
			var search_term = $(this).val();

			// Do the AJAX query
			$.get(
				'index.php?do=search',
				{
					query: search_term,
					category: 0,
					type: 'json'
				},
				function(data)
				{
					// On positive results, create the list of search results
					let new_ul = [];

					data.forEach(obj => {
						new_ul.push(`<li class="list-group-item"><a href="index.php?do=viewproduct&id=${obj.id}">${obj.nom}</a></li>`);
					})

					$('.list-group').html(new_ul.join(''));
					$('.list-group').removeClass('hide');
				},
				'json'
			);
		}
		else
		{
			// Nothing in the search query, hide the search results list
			$('.list-group').html('');
			$('.list-group').addClass('hide');
		}
	});

	$(document).click(function()
	{
		// If there is any click on the page out of the search results, hide results
		if (!$('.autosuggest').is(':hover'))
		{
			$('.list-group').html('');
			$('.list-group').addClass('hide');
		}
	})
});

// ************************************************
// Functions to manage cart and account options visible or not
// ************************************************

function openCart()
{
	document.getElementById('cart_side').classList.add('open-side');
}

function closeCart()
{
	document.getElementById('cart_side').classList.remove('open-side');
}

function openAccount()
{
	document.getElementById('myAccount').classList.add('open-side');
}

function closeAccount()
{
	document.getElementById('myAccount').classList.remove('open-side');
}

// ************************************************
// Shopping Cart API
// ************************************************

var shoppingCart = (function()
{
	// Private methods and properties
	cart = [];

	// Constructor
	function Item(name, price, count, photo, id)
	{
		this.name = name;
		this.price = price;
		this.count = parseInt(count);
		this.photo = photo;
		this.id = id;
	}

	// Save cart
	function saveCart()
	{
		sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
	}

	// Load cart
	function loadCart()
	{
		cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
	}

	if (sessionStorage.getItem('shoppingCart') != null)
	{
		loadCart();
	}

	// =============================
	// Public methods and properties
	// =============================
	var obj = {};

	// Add new item to cart
	obj.addNewItemToCart = function(name, price, count, photo, id)
	{
		for (var item in cart)
		{
			if (cart[item].name === name)
			{
				cart[item].count = parseInt(cart[item].count) + parseInt(count);
				saveCart();
				return;
			}
		}

		var item = new Item(name, price, count, photo, id);
		cart.push(item);
		saveCart();
	}

	// Add to cart
	obj.addItemToCart = function(name)
	{
		for (var item in cart)
		{
			if (cart[item].name === name)
			{
				cart[item].count++;
				saveCart();
				return;
			}
		}
	}

	// Set count from item
	obj.setCountForItem = function(name, count)
	{
		for (var i in cart)
		{
			if (cart[i].name === name)
			{
				cart[i].count = parseInt(cart[i].count) + parseInt(count);
				break;
			}
		}
	}

	// Remove item from cart
	obj.removeItemFromCart = function(name)
	{
		for (var item in cart)
		{
			if (cart[item].name === name)
			{
				cart[item].count --;

				if (cart[item].count === 0)
				{
					cart.splice(item, 1);
				}
				break;
			}
		}

		saveCart();
	}

	// Clear completely the cart - used when user has clicked on checkout and the order has been save in the db as not paid
	obj.clearCart = function()
	{
		cart = [];
		saveCart();
	}

	// Total count of items in cart
	obj.totalCount = function()
	{
		var totalCount = 0;

		for (var item in cart)
		{
			totalCount += cart[item].count;
		}

		return totalCount;
	}

	// Total cart value
	obj.totalCart = function()
	{
		var totalCart = 0;

		for (var item in cart)
		{
			totalCart += cart[item].price * cart[item].count;
		}

		return totalCart.toFixed(2);
	}

	// List cart
	obj.listCart = function()
	{
		var cartCopy = [];

		for (i in cart)
		{
			item = cart[i];
			itemCopy = {};

			for (p in item)
			{
				itemCopy[p] = item[p];
			}

			itemCopy.total = (item.price * item.count).toFixed(2);
			cartCopy.push(itemCopy);
		}

		return cartCopy;
	}

	return obj;
})();

// *****************************************
// Triggers / Events
// *****************************************

// Add item
$('.add-to-cart').click(function(e)
{
	e.preventDefault();

	// Get product informations
	var name = $(this).data('name');
	var price = $(this).data('price');
	var count = $('.qty-adj').val();
	var photo = $(this).data('photo');
	var id = $(this).data('id');

	// Add product into cart
	shoppingCart.addNewItemToCart(name, price, count, photo, id);

	// Update cart
	displayCart();
});

function displayCart()
{
	var cartArray = shoppingCart.listCart();
	var output1 = output2 = output3 = output4 = "";

	for (var i in cartArray)
	{
		// Cart in top
		output1 += "<li>"
		+ "<div class='media'>"
		+ "<a href='index.php?do=viewproduct&amp;id=" + cartArray[i].id + "'><img src='" + cartArray[i].photo + "' class='me-3' alt='" + cartArray[i].name + "' /></a>"
		+ "<div class='media-body'>"
		+ "<a href='index.php?do=viewproduct&amp;id=" + cartArray[i].id + "'><h4>" + cartArray[i].name + "</h4></a>"
		+ "<h6>" + cartArray[i].price + " &euro;</h6>"
		+ "<div class='addit-box'>"
		+ "<div class='qty-box'>"
		+ "<div class='input-group'>"
		+ "<button class='qty-minus' data-name='" + cartArray[i].name + "'></button>"
		+ "<input type='number' name='quantity' class='qty-adj form-control' value='" + cartArray[i].count + "' />"
		+ "<button class='qty-plus' data-name='" + cartArray[i].name + "'></button>"
		+ "</div>"
		+ "</div>"
		+ "</div>"
		+ "</div>"
		+ "</li>";

		// Cart page
		output2 += "<tr>"
		+ "<td>"
		+ "<a href='index.php?do=viewproduct&amp;id=" + cartArray[i].id + "'>"
		+ "<img src='" + cartArray[i].photo + "' alt='" + cartArray[i].name + "' class='' />"
		+ "</a>"
		+ "</td>"
		+ "<td><a href='index.php?do=viewproduct&amp;id=" + cartArray[i].id + "'>" + cartArray[i].name + "</a>"
		+ "<div class='mobile-cart-content'>"
		+ "<div class='col-xs-3'>"
		+ "<div class='qty-box'>"
		+ "<div class='input-group'>"
		+ "<button class='qty-minus' data-name='" + cartArray[i].name + "'></button>"
		+ "<input type='number' class='qty-adj form-control' value='" + cartArray[i].count + "' data-name='" + cartArray[i].name + "' />"
		+ "<button class='qty-plus' data-name='" + cartArray[i].name + "'></button>"
		+ "</div>"
		+ "</div>"
		+ "</div>"
		+ "<div class='col-xs-3'>"
		+ "<h2 class='td-color'>" + cartArray[i].price + " &euro;</h2>"
		+ "</div>"
		+ "</div>"
		+ "<div class='mobile-cart-content'>"
		+ "<div class='col-xs-3'>"
		+ "<h2 class='total-color'>Total :</h2>"
		+ "</div>"
		+ "<div class='col-xs-3'>"
		+ "<h2 class='td-color'>" + (cartArray[i].price * cartArray[i].count).toFixed(2) + " &euro;</h2>"
		+ "</div>"
		+ "</div>"
		+ "</td>"
		+ "<td>"
		+ "<h2>" + cartArray[i].price + " &euro;</h2>"
		+ "</td>"
		+ "<td>"
		+ "<div class='qty-box'>"
		+ "<div class='input-group'>"
		+ "<button class='qty-minus' data-name='" + cartArray[i].name + "'></button>"
		+ "<input type='number' class='qty-adj form-control' value='" + cartArray[i].count + "' data-name='" + cartArray[i].name + "' />"
		+ "<button class='qty-plus' data-name='" + cartArray[i].name + "'></button>"
		+ "</div>"
		+ "</div>"
		+ "</td>"
		+ "<td>"
		+ "<h2 class='td-color'>" + (cartArray[i].price * cartArray[i].count).toFixed(2) + " &euro;</h2>"
		+ "<input type='hidden' name='id' value='" + cartArray[i].id + "' />"
		+ "</td>"
		+ "</tr>";

		// Checkout page
		output3 += "<li>" + cartArray[i].name + " x " + cartArray[i].count + "<span>" + (cartArray[i].price * cartArray[i].count).toFixed(2) + " &euro;</span></li>"

		// Payment page, to have informations to enter into order details
		output4 += "<input type='hidden' name='item[" + i + "][id]' value='" + cartArray[i].id + "' />"
		+ "<input type='hidden' name='item[" + i + "][price]' value='" + cartArray[i].price + "' />"
		+ "<input type='hidden' name='item[" + i + "][quantity]' value='" + cartArray[i].count + "' />";
	}

	// Cart in top sidebar
	$('.cart_product').html(output1);

	// Full cart page
	$('.cart_list').html(output2);

	// List of products in checkout
	$('.qty').html(output3);

	// Value of each item and their quantities from sessionStorage to HTML/PHP form
	$('.hiddeninput').html(output4);

	// Total price everywhere
	$('.total-cart').html(shoppingCart.totalCart() + ' &euro;');

	// Add total price value in hidden field for the payment process
	$('.novisibleprice').val(shoppingCart.totalCart());

	// Number of items in the cart
	$('.total-count').html(shoppingCart.totalCount());

	// Define an other way to interact if there is 0 items in the cart
	if (shoppingCart.totalCount() === 0)
	{
		// Cart in top sidebar
		$('.cart_product').html('<li class="emptycart text-center">Vous n\'avez aucun produit dans votre panier.</li>');

		// Full cart page
		$('.cart_list').html('<tr><td colspan="5">Vous n\'avez aucun produit dans votre panier.</td></tr>');

		// Button to place order
		$('.submitcheckoutbutton').attr('disabled', true);

		// List of products in checkout
		$('.qty').html('<li>Vous n\'avez pas d\'articles dans votre panier, vous ne pouvez pas procéder au paiement.</li>');

		// Deliver list in checkout
		$('#deliver').attr('disabled', true);

		// Deliver mode in checkout
		$('#delivermode').attr('disabled', true);
	}
}

// Cart popup

// -1 item count
$('.cart_product').on('click', '.qty-minus', function(e)
{
	var name = $(this).data('name');
	shoppingCart.removeItemFromCart(name);
	displayCart();
});

// +1 item count
$('.cart_product').on('click', '.qty-plus', function(e)
{
	var name = $(this).data('name');
	shoppingCart.addItemToCart(name);
	displayCart();
});

// Item count input
$('.cart_product').on('change', '.qty-adj', function(e)
{
	var name = $(this).data('name');
	var count = Number($(this).val());
	shoppingCart.setCountForItem(name, count);
	displayCart();
});

// Cart page

// -1 item count
$('.cart_list').on('click', '.qty-minus', function(e)
{
	var name = $(this).data('name');
	shoppingCart.removeItemFromCart(name);
	displayCart();
});

// +1 item count
$('.cart_list').on('click', '.qty-plus', function(e)
{
	var name = $(this).data('name');
	shoppingCart.addItemToCart(name);
	displayCart();
});

// Item count input
$('.cart_list').on('change', '.qty-adj', function(e)
{
	var name = $(this).data('name');
	var count = Number($(this).val());
	shoppingCart.setCountForItem(name, count);
	displayCart();
});

displayCart();
