$(function(){	
	$('.responsive').slick({
		dots: false,
		infinite: false,
		speed: 300,
		slidesToShow: 5,
		slidesToScroll: 1,
		// prev arrow
		prevArrow: '<button type="button" data-role="none" class="slick-prev"><i class="fa fa-arrow-circle-left"></i></button>',
	 
	// next arrow
	nextArrow: '<button type="button" data-role="none" class="slick-next"><i class="fa fa-arrow-circle-right"></i></button>',
	  responsive: [
		{
		  breakpoint: 1024,
		  settings: {
			slidesToShow: 4,
			slidesToScroll: 3,
			infinite: true,
	  dots: false,
		  }
		},
		{
		  breakpoint: 600,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 2
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		  }
		}
		// You can unslick at a given breakpoint now by adding:
		// settings: "unslick"
		// instead of a settings object
	  ]
	});
});