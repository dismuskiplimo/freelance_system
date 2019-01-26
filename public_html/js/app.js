$(function(){
	function isNumber(n){
		return !isNaN(+n) && isFinite(n);
	}

	function calculatePrice(){
		var pages = $('#pages').val();
		
		var price = $('#create-order-assignment-type').find(':selected').data('price');
		
		price = parseInt(price);

		pages = parseInt(pages);
		
		var amount = pages * price;

		$('#money-span').html('$' + amount);
	}

	function calculateMiniPrice(){
		var percent = parseInt($('#commission-percent').val());
		
		var amount  = $('#money-input-1').val();

		var payable = amount - ((percent / 100) * amount);

		$('#money-span-1').html(payable.toFixed(2));
	}


	if($('#money-span').length > 0){
		calculatePrice();
	}

	if($('#money-span-1').length > 0){
		calculateMiniPrice();
	}

	$('#create-order-title, #create-order-assignment-type, #create-order-discipline, #pages').on('change', function(e){
		calculatePrice();
	})

	$('#money-input-1').on('change focus keyup', function(){
		calculateMiniPrice();
	});

	$('html').niceScroll({
		zindex:999999,
	});
	
	if($('.message-box').length){
		$('.message-box').niceScroll();
		$('.message-box').getNiceScroll(0).doScrollTop($('.chat-box').height());
	}

	if($('.comments-wrapper').length){
		$('.comments-wrapper').niceScroll();
		$('.comments-wrapper').getNiceScroll(0).doScrollTop($('.comments').height());
	}

	if($('#pages').length){
		var pages = $('#pages').val();
		words = parseInt(pages) * 250;
		$('#words').html(words.toLocaleString());
	}


	$(document).on('change keyup focus','#pages', function(){
		var that = $(this);
		var pages = that.val();

		if(isNumber(pages) && pages > 0){
			words = parseInt(pages) * 250;
			$('#words').html(words.toLocaleString());
		}else{
			$('#words').html('0');
		}
	});

	$('#remove-page').on('click', function(){
		var pages = $('#pages');
		if(pages.val() == "" || parseInt(pages.val()) <= 1){
			pages.val(1);
		}else{
			pages.val( parseInt(pages.val()) - 1);
		}

		calculatePrice();

		pages.focus();

	});

	$('#add-page').on('click', function(){
		var pages = $('#pages');
		if(pages.val() == "" || parseInt(pages.val()) < 1){
			pages.val(1);
		}else{
			pages.val( parseInt(pages.val()) + 1);
		}

		calculatePrice();

		pages.focus();
	});

	$('.auth-submit').on('submit', function(e){
		e.preventDefault();

		var that = $(this);
		var shakeDiv = that.find('.shake-div');
		var button = that.find('button[type="submit"]');
		button.attr("disabled","disabled");

		that.find('.form-group').removeClass('has-error');

		$('.loading').css("display", "inline-block");

		
		//shakeDiv.removeClass('animated shake');
		
		$('.errors').html("");
		
		$.ajax({
			method: 'POST',
			url: that.attr('action'),
			dataType: 'json',
			data: that.serialize(),
			success: function(data){
				if(data.status != 200){
					$(".errors").html("<span class = \"text-danger\"><strong>" + data.message + "</strong></span>");
					shakeDiv.addClass('animated shake');
				}else{
					$(".errors").html("<span class = \"text-success\"><strong>" + data.message + "</strong></span>");
					window.location.replace(data.url);
				}
			},
			error: function(xhr,status,error){
				

				if(xhr.status == 422){
					shakeDiv.addClass('animated shake');
					var errors = $.parseJSON(xhr.responseText);
					var errorString = "<span class = \"text-danger\">";

					
					$.each(errors, function(key, value){
					 	if(Object.keys(errors).length > 1){
					 		errorString += "- " + value + "<br />";
					 	}else{
					 		errorString += "- " + value;
					 	}

					 	
					 	that.find('input, textarea, select').each(function(keyChild, valueChild){

					 		if($(this).attr('name') == key){
					 			$(this).parents('.form-group').addClass('has-error');
					 		}
					 	});
					 	
					 });

					errorString += "</span>";

					that.find('.errors').html(errorString);

					document.title = "Error"
				}
			},
			complete : function(){
				$('.loading').css("display", "none");
				button.removeAttr("disabled");
			}
		});

		setTimeout(function(){
			shakeDiv.removeClass('animated shake');
		},3000);
		

	});

	$('#deadline').datetimepicker({
		minDate: new Date(),
		format: 'YYYY-MM-DD HH:mm:ss',
		minDate: moment().add(1, 'days'),
	});

	$('.deadline').datetimepicker({
		minDate: new Date(),
		format: 'YYYY-MM-DD HH:mm:ss',
		minDate: moment().add(1, 'days'),
	});

	$('.dob').datetimepicker({
		
		format: 'YYYY-MM-DD',
		maxDate: moment().subtract(18, 'years'),
		minDate: '1930-01-01',
		
	});

	$('#best-writers').owlCarousel({
		items:4,
		pagination:false,
		margin:20,
		
		autoplay:true,
	});

	$('#user-reviews').owlCarousel({
		items:3,
		pagination:false,
		margin:20,
		loop:true,
		autoplay:true,
	});

	$('#login-link').on('click',function(){
		$('a[href="#login-tab"]').tab('show');
	});

	$('#signup-link').on('click',function(){
		$('a[href="#signup-tab"]').tab('show');
	});

	$('.next-form-step-trigger').on('click',function(){
		$('a[href="#order-payment"]').tab('show');
	});

	$('.previous-form-step-trigger').on('click',function(){
		$('a[href="#main-form-content"]').tab('show');
	});

	

	$('.contact-div').matchHeight();

	$('.click-buddy').on('click', function(){
		$(this).siblings('input[type=file]').click();
	});

	$('.auto-submit').on('change',function(){
		$('#image-form').submit();
	});
});