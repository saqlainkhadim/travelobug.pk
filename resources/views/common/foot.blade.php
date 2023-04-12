


        <!-- New Js start-->
		<script src="{{asset('public/js/jquery-2.2.4.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('public/js/main.js')}}"></script>

		  {!! @$head_code !!}

		<!-- New Js End -->
		<!-- Needed Js from Old Version Start-->
		<script type="text/javascript">
			var APP_URL = "{{ url('/') }}";
			var USER_ID = "{{ isset(Auth::user()->id)  ? Auth::user()->id : ''  }}";
			var sessionDate      = '{!! Session::get('date_format_type') !!}';

            $(".currency_footer").on('click', function() {
                var currency = $(this).data('curr');
                    $.ajax({
                        type: "POST",
                        url: APP_URL + "/set_session",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'currency': currency
                            },
                        success: function(msg) {
                            location.reload()
                        },
                });
            });

            $(".language_footer").on('click', function() {
                var language = $(this).data('lang');
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/set_session",
                    data: {
                            "_token": "{{ csrf_token() }}",
                            'language': language
                        },
                    success: function(msg) {
                        location.reload()
                    },
                });
            });

            $(document.body).on('input','.address_input', function() {
                var search = $(this).val();
                $(this).closest('div').find('.address_html').html('');
                if(search.length > 3) {
                    $.ajax({
                    type: "POST",
                    url: APP_URL + "/address/search",
                    data: {
                            "_token": "{{ csrf_token() }}",
                            'search': search
                        },
                        context: this,
                        success: function(data) {

                            var address_html = '<ul>';
                                if (data.length) {
                                    for (let index = 0; index < data.length; index++) {
                                        const element = data[index];
                                        address_html += '<li data-longitude="'+element.longitude+'" data-latitude="'+element.latitude+'" data-name="'+element.name+'" class="address_list  text-truncate">'+element.name+'</li>';
                                    }
                                }
                            address_html += '</ul>';

                            $(this).closest('div').find('.address_html').html(address_html);
                        },
                    });
                }
            });
            $(document.body).on('click','.address_list', function() {
                var address_name = $(this).data('name');
                var latitude = $(this).data('latitude');
                var longitude = $(this).data('longitude');
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);

                $(this).closest('.position-relative').find('.address_input').val(address_name);
                $(this).closest('div').html('');
            });
		</script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{asset('public/js/inc.func.js')}}"></script>

		<!-- Needed Js from Old Version End -->
		@stack('scripts')
	</body>
</html>
