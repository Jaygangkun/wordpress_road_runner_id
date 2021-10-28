jQuery(document).ready(function($) {
	
	// Initialize AOS
	AOS.init();
	
	// Mobile Menu
	$('#menu-nav-menu > .dropdown').append("<div class='nav-toggle'><i class='fas fa-chevron-down'></i></div>");
	
	$('#menu-nav-menu .dropdown .nav-toggle').click(function() {
		$(this).siblings('ul.dropdown-menu').slideToggle(300);
		$(this).toggleClass('active');
	});
	
	$('.navbar-toggler').click(function() {
		$('body').toggleClass('nav-open');
	});
	
	// profile page
	$(document).on('click', '.profile-sub-page-link', function() {
		let sub_page_target = $(this).attr('sub-page-target');
		$('.profile-sub-page-link').removeClass('active');
		$(this).addClass('active');
		$('.profile-sub-page').hide();
		$(sub_page_target).show();
	})
}); /* end of as page load scripts */