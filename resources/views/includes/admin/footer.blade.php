 </div>
 </div>
<footer class="footer">
            <div class="container-fluid">
                
                <div class="copyright pull-right">
                    &copy; {{ date('Y') }} {{ env('APP_NAME') }} Inc
                </div>
            </div>
        </footer>

    </div>
</div>

    <span id="site-name" class = "hidden" style = "display:none">{{ url(route('getUpdateLastSeen')) }}</span>
    <span id="message-name" class = "hidden" style = "display:none">{{ url(route('getUserMessages')) }}</span>
    <span id="notification-name" class = "hidden" style = "display:none">{{ url(route('getUserNotifications')) }}</span>


    <!--   Core JS Files   -->
    <script src="{{ asset('js/admin/bootstrap.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
    
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="{{ asset('js/admin/bootstrap-checkbox-radio.js') }}"></script>

    <!--  Charts Plugin -->
    <script src="{{ asset('js/admin/chartist.min.js') }}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/admin/bootstrap-notify.js') }}"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="{{ asset('js/admin/paper-dashboard.js') }}"></script>

    <script src="{{ asset('js/nicescroll.min.js') }}"></script>

    <script src="{{ asset('js/matchHeight-min.js') }}"></script>

    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>

    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('js/admin/admin.js') }}"></script>
    
    <script src="{{ asset('js/dashboard.js') }}"></script>
    
    <script src="{{ asset('js/app.js') }}"></script>

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