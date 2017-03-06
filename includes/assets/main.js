jQuery(function () {
	// Enable JCF (Javascript Custom Fields)
	init_jcf();

	// Enable mobile nav menu
	init_mobile_button('.mobile-menu-button', '#mobile-nav', '.mobile-menu', 'mobile_nav_open');

	// Enables ajax pagination on archive and search results pages
	init_ajax_pagination();
});

function init_jcf() {
	if ( typeof jcf == 'undefined' ) return;

	// Style custom fields
	jcf.replace(':button:not(.mobile-menu-button)', 'Button');
	jcf.replace(':submit:not(.adminbar-button)', 'Button');
	jcf.replace('a.button', 'Button'); // a.button too!
	jcf.replace('select', 'Select');
	jcf.replace(':file', 'File');
	jcf.replace(':radio', 'Radio');
	jcf.replace(':checkbox', 'Checkbox');

	// Add class to file inputs when dragging over with text
	jQuery('html')

	// Dragging file over a file input
		.on( 'dragover dragenter', 'input.jcf-real-element:file', function(e) {
			jQuery(this).closest('.jcf-file').addClass('file-dragged-over');
		})

		// Dragging file end
		.on( 'dragleave dragend drop', 'input.jcf-real-element:file', function(e) {
			jQuery(this).closest('.jcf-file').removeClass('file-dragged-over');
		})

		// Hover over a label that refers to an input to give remote hover class
		.on( 'mouseover mouseout focus blur', 'label', function(e) {
			var $target;
			console.log(this);

			// Get the field the label is referring to
			$target = jQuery(this).data('hover-target');
			if ( !$target || $target.length < 1 ) $target = jQuery('#' + jQuery(this).attr('for') );
			if ( !$target || $target.length < 1 ) $target = jQuery(this).find(':input');
			if ( !$target || $target.length < 1 ) return;

			console.log($target[0]);

			// Fake parent of the field. For example a checkbox would have "span.jcf-checkbox"
			var $jcfParent = $target.data('jcfInstance') ? jQuery( $target.data('jcfInstance').fakeElement ) : false;
			console.log($jcfParent);
			if ( !$jcfParent || $jcfParent.length < 1 ) return;

			if ( e.type == 'mouseover' ) $jcfParent.addClass('label-hover');
			else if ( e.type == 'mouseout' ) $jcfParent.removeClass('label-hover');
			else if ( e.type == 'focus' ) $jcfParent.addClass('label-focus');
			else if ( e.type == 'blur' ) $jcfParent.removeClass('label-focus');
		});
}

function init_mobile_button( button_selector, navigation_selector, inner_nav_selector, body_class ) {
	if ( typeof button_selector == 'undefined' || typeof navigation_selector == 'undefined' || !button_selector || !navigation_selector ) return;

	var $nav = jQuery(navigation_selector);
	var $button = jQuery(button_selector);

	if ( $button.length < 1 || $nav.length < 1 ) {
		return;
	}

	var $html = jQuery('html');
	var $body = jQuery('body');
	var $inner = $nav.find(inner_nav_selector);

	// button click toggles nav
	$button.click(function () {
		// Close any open submenus
		$nav.find('li.sub-menu-open').removeClass('sub-menu-open');

		if ( $body.hasClass(body_class) ) {
			// reset scroll position of .site-container while it's fixed in place
			jQuery('html, body').scrollTop(0);
		} else {
			var pageH = $html.outerHeight(true);
			var scrollH = $html[0].scrollHeight;

			if ( scrollH > pageH ) {
				// if the page had a scrollbar before menu opened, keep it whether or not menu requires it
				//console.log('The scrollable area ('+ scrollH +') exceeds the page height ('+ pageH +'), scrollbar ENABLED');
				$body.addClass('require_scrollbar');
			} else {
				//console.log('The scrollable area ('+ scrollH +') does NOT exceed the page height ('+ pageH +'), scrollbar DISABLED');
				$body.removeClass('require_scrollbar');
			}
		}

		// Toggle the mobile nav menu
		$body.toggleClass(body_class);

		return false;
	});

	// clicking outside of the menu closes it
	$nav.click(function ( e ) {
		if ( e.target != $inner[0] && !$inner.find(e.target).length ) {
			$button.trigger("click");
			return false;
		}
	});

	// Clicking a menu item should open up the submenu navigation, if it has one. If it is open, close it.
	$nav.on('click', 'a', function () {
		var $link = jQuery(this);
		var $item = $link.parent('li.menu-item');
		var $submenu = $item.children('ul.sub-menu:first');

		if ( $submenu.length > 0 ) {
			// Collapse sibling menus if they are open, as well as their children.
			$item.siblings('li.menu-item.sub-menu-open').each(function () {
				jQuery(this).removeClass('sub-menu-open');
				jQuery(this).find('li.menu-item.sub-menu-open').removeClass('sub-menu-open');
			});

			// Collapse or expand the clicked menu as needed.
			$item.toggleClass('sub-menu-open');

			return false;
		}
	});
}

function init_ajax_pagination() {

	if ( !jQuery(".loop-pagination").length ) return;

	var $main = jQuery("#main");

	// save current page as state
	history.replaceState({
		pageTitle: document.title,
		pageContent: $main.html()
	}, '', window.location.pathname + window.location.search);

	// update results on click of pagination links
	jQuery(document).on("click", ".loop-pagination a", function ( e ) {

		e.preventDefault();
		$main.addClass('ajax-loading');
		var urlToLoad = jQuery(this).attr("href");

		jQuery.ajax({
			type: 'POST',
			dataType: 'json',
			url: urlToLoad,
			data: { ajax: 1 }
		})
			.done(function ( json ) {
				$main
					.html(json.content)
					.removeClass('ajax-loading');
				document.title = json.title;
				if ( $main.offset().top < jQuery(window).scrollTop() ) {
					// top of $main is hidden above top of window; scroll up
					jQuery('html, body').animate({ scrollTop: $main.offset().top }, 200);
				}
				history.pushState({
					pageTitle: json.title,
					pageContent: json.content
				}, '', urlToLoad);
			})
			.fail(function () {
				window.location.href = urlToLoad;
			});
	});

	// update results on history change
	window.onpopstate = function ( e ) {
		$main.html(e.state.pageContent);
		document.title = e.state.pageTitle;
	};

}
