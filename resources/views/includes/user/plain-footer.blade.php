
		<script src = "{{ asset('js/bootstrap.min.js') }}"></script>
		<script src = "{{ asset('js/nicescroll.min.js') }}"></script>
		<script src = "{{ asset('js/moment.min.js') }}"></script>
		<script src = "{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
		<script src = "{{ asset('js/owl.carousel.min.js') }}"></script>
		<script src = "{{ asset('js/matchHeight-min.js') }}"></script>
		<script src = "{{ asset('js/ion.sound.min.js') }}"></script>
		
		<script src = "{{ asset('js/app.js') }}"></script>

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