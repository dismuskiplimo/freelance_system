$(function(){
	var site_url = $('#site-name').text();
	var base_url = $('#site-ul').text();
	var messages_url = $('#message-name').text();
	var notifications_url = $('#notification-name').text();

	var message_count = $('.message-count');
	var notifications_count = $('.notifications-count');
	var notifications_wrapper = $('.notifications-wrapper');

	// ion.sound({
	//     sounds: [
	        
	//         {
	//             name: "bell_ring",
	//             volume: 1.0
	//         },
	        
	//     ],
	//     volume: 1.0,
	//     path: base_url + "/js/sounds/",
	//     preload: true
	// });

	setInterval(function(){
		$.ajax({
			url: notifications_url,
			datatype: 'JSON',
			method: 'GET',
			success : function(data){
				if(data.count > 0){
					notifications_count.removeClass('hidden');
					notifications_count.text(data.count);
				}else{
					notifications_count.addClass('hidden');
					notifications_count.text('');
				}

				if(data.notifications.length > 0){
					var content = '';

					$.each(data.notifications,function(index, value){
						if(value.read_status == 1){
							var cls = '';
						}else{
							var cls = ' active';	
						}
						
						content += '<a class="content" href="' + value.url + '">';
					
						content += '<div class="notification-item' + cls + '">';
						content += '<h4 class="item-title"><strong>';
						content += value.username + '</strong>' + ' ' + value.message + ', ' + value.created_at + '</h4>';
						content += '</div></a>';
					});

					$('.notifications-wrapper').html('content');
					$('.notifications-wrapper').html(content);

				}else{
					notifications_wrapper.html('No new notifications');
				}
			},
			error: function(xhr,status,error){
				console.log(xhr.responseText);
			}
		});
	},10000);

	setInterval(function(){
		$.ajax({
			url: site_url,
			method: 'GET',
			datatype: 'JSON',
			success : function(data){
				
			},
			error: function(xhr,status,error){
				console.log(xhr.responseText);
			}
		});
	},10000);

	setInterval(function(){
		$.ajax({
			url: messages_url,
			method: 'GET',
			datatype: 'JSON',
			success : function(data){
				if(data.length){
					message_count.removeClass('hidden');
					message_count.text(data.length);
				}else{
					message_count.addClass('hidden');
					message_count.text('');
				}
			},
			error: function(xhr,status,error){
				console.log(xhr.responseText);
			}
		});
	},10000);

	$(document).on('submit','form', function(e){
		var that = $('form');
		var count = 0;		
		
		that.find('.form-group').each(function(){
			$(this).removeClass('has-error');
		});
		
		that.find('.required').each(function(){
			var me = $(this);

			if(me.val() == "" || me.val() == undefined || me.val() == 0){
				me.closest('.form-group').addClass('has-error');
				count++;
			}
		});

		if(count > 0){
			e.preventDefault();

			if($('#create-order-title').length && $('#create-order-assignment-type').length && $('#create-order-discipline').length){
				var title = $('#create-order-title').val();
				var assignment_type = $('#create-order-assignment-type').val();
				var discipline = $('#create-order-discipline').val();

				if(title == "" || assignment_type == "" || discipline == ""){
					$('a[href="#main-form-content"]').tab('show');
				}
			}

		}
	});

	if($('#conversation-url').length){
		var conversationUrl = $('#conversation-url').val();
		
		
		setInterval(function(){
			$.ajax({
				url : conversationUrl,
				method : 'GET',
				success : function(data){
					if(data != 'false'){
						$('.chat-box').html(data);
						
						var chatboxHeight = $('.chat-box').height();

						//ion.sound.play("bell_ring");

						$.snackbar({
							content:'new message received, scroll down to view',
							timeout: 5000,
							style:'toast,'
						});
						
						//$('.message-box').getNiceScroll(0).doScrollTop(chatboxHeight);
					}

					
				},
				error : function(){

				}
			});
		},10000);
	}
});