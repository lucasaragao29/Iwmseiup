jQuery(function($) {'use strict',

	//#main-slider
	$(function(){
		$('#main-slider.carousel').carousel({
			interval: 3000,
			autoplay: true,
			loop: true,
			bullets : false

					
		});
	});


	// accordian
	$('.accordion-toggle').on('click', function(){
		$(this).closest('.panel-group').children().each(function(){
		$(this).find('>.panel-heading').removeClass('active');
		 });

	 	$(this).closest('.panel-heading').toggleClass('active');
	});

	//Initiat WOW JS
	new WOW().init();

	// portfolio filter
	$(window).load(function(){'use strict';
		var $portfolio_selectors = $('.portfolio-filter >li>a');
		var $portfolio = $('.portfolio-items');
		$portfolio.isotope({
			itemSelector : '.portfolio-item',
			layoutMode : 'fitRows'
		});
		
		$portfolio_selectors.on('click', function(){
			$portfolio_selectors.removeClass('active');
			$(this).addClass('active');
			var selector = $(this).attr('data-filter');
			$portfolio.isotope({ filter: selector });
			return false;
		});
	});

	// Contact form
	$('.contact-form').submit(function () {'use strict',
    $this = $(this);
    $.post("sendemail.php", $(".contact-form").serialize(),function(result){
        if(result.type == 'success'){
            $this.prev().text(result.message).fadeIn().delay(3000).fadeOut();
			$("#main-contact-form").trigger("reset");
        }
    });
    return false;
});

// Contact form2
	$('.contact-form2').submit(function () {'use strict',
    $this = $(this);
    $.post("sendemail2.php", $(".contact-form2").serialize(),function(result){
        if(result.type == 'success'){
            $this.prev().text(result.message).fadeIn().delay(3000).fadeOut();
			$("#main-contact-form2").trigger("reset");
        }
    });
    return false;
});

// Contact form3
	$('.contact-form3').submit(function () {'use strict', 
    $this = $(this);
	
	$.ajax({
		url: "sendemail.php", // Url to which the request is send
		type: "POST",             // Type of request to be send, called as method
		data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		contentType: false,       // The content type used when sending data to the server.
		cache: false,             // To unable request pages to be cached
		processData:false,        // To send DOMDocument or non processed data file it is set to false
		success: function(data)   // A function to be called if request succeeds
		{
		$('#loading').hide();
		$("#message").html(data);
		}
	});
			
			
    $.post("sendemail.php", $(".contact-form3").serialize(),function(result){
        if(result.type == 'success'){
             
			$this.prev().text(result.message).fadeIn().delay(3000).fadeOut();
			$("#main-contact-form3").trigger("reset");
        }
    });
    return false;
});





	
	//goto top
	$('.gototop').click(function(event) {
		event.preventDefault();
		$('html, body').animate({
			scrollTop: $("body").offset().top
		}, 500);
	});	

	//Pretty Photo
	$("a[rel^='prettyPhoto']").prettyPhoto({
		social_tools: false
	});	
});