		<div class="container-fluid border-top">
			<div class="row">
				<div class="container">
					

					<div class="row padding-tb-50 text-center">
						<div class="col-lg-12">
							<p>&copy; {{ date('Y') }} {{ env('APP_NAME') }} all rights reserved</p><br />
							<p>We accept:</p>
							<p>
								<img src="{{ asset('images/malipo.png') }}" alt="" class="img-responsive margin-horizontal" style = "max-width: 300px" >
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<span id="site-ul" class = "hidden">{{ url('/') }}</span>
		<span id="site-name" class = "hidden">{{ url(route('getUpdateLastSeen')) }}</span>
		<span id="message-name" class = "hidden">{{ url(route('getUserMessages')) }}</span>
		<span id="notification-name" class = "hidden">{{ url(route('getUserNotifications')) }}</span>

		<script src = "{{ asset('js/bootstrap.min.js') }}"></script>
		<script src = "{{ asset('js/nicescroll.min.js') }}"></script>
		<script src = "{{ asset('js/moment.min.js') }}"></script>
		<script src = "{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
		<script src = "{{ asset('js/owl.carousel.min.js') }}"></script>
		<script src = "{{ asset('js/matchHeight-min.js') }}"></script>
		<script src = "{{ asset('js/ion.sound.min.js') }}"></script>
		<script src = "{{ asset('js/snackbar.min.js') }}"></script>
		
		<script src = "{{ asset('js/app.js') }}"></script>
		<script src = "{{ asset('js/dashboard.js') }}"></script>

		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
			var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			(function(){
				var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
				s1.async=true;
				s1.src='https://embed.tawk.to/5839a7ae4160416f6d94b9a2/default';
				s1.charset='UTF-8';
				s1.setAttribute('crossorigin','*');
				s0.parentNode.insertBefore(s1,s0);
			})();

			$('.tawk-button').on('click',function(e){
	            Tawk_API.toggle();
	            e.preventDefault();
	        });
		</script>
		<!--End of Tawk.to Script-->
	</body>
</html>