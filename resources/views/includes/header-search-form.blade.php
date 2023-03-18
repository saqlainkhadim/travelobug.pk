<div class="property_search_form">
    <div class="property_category" style="display:none">
        <div class="d-flex justify-content-center">
            <label for="cat_hotel" class="mx-5 mb-4">
                @lang('Hotel') <input type="radio" name="category" {{ request('category', 'hotel') != 'hotel' ?: "checked" }} value="hotel" id="cat_hotel" hidden>
            </label>
            <label for="cat_guest_house" class="mx-5 mb-4">
                @lang('Guest House') <input type="radio" name="category" {{ request('category', 'hotel') != 'guest_house' ?: "checked" }} value="guest_house" id="cat_guest_house" hidden>
            </label>
            <label for="cat_activities" class="mx-5 mb-4">
                @lang('Activities') <input type="radio" name="category" {{ request('category', 'hotel') != 'activities' ?: "checked" }} value="activities" id="cat_activities" hidden>
            </label>
        </div>
    </div>
    <div class="header_form">
        <input type="hidden" id="category_search" value="hotel">
        <div class="input-group">
            <div class="w-25">
                <div class="position-relative">
                    <input class="form-control p-3 text-14 address_input" id="front-search-address" placeholder="{{trans('messages.home.where_want_to_go')}}" autocomplete="off" name="location" type="search" value="{{ request('location') }}">
                    <div class="address_html"></div>
                </div>
            </div>
            <div id="daterange-btn" class="d-flex" style="width:40%">
                <input class="form-control p-3 border-right-0 border text-14 text-center checkinout" name="checkin" value="{{ request('checkin') }}" id="startDate" type="text" placeholder="{{trans('messages.search.check_in')}}" autocomplete="off" readonly="readonly" required role="button">
                <input class="form-control p-3 border-right-0 border text-14 text-center checkinout" name="checkout" value="{{ request('checkout') }}" id="endDate" placeholder="{{trans('messages.search.check_out')}}" type="text" readonly="readonly" required role="button">
            </div>
            <div class="input-group-append" style="width:35%">
                <div class="d-flex">
                    <div class="position-relative">
                        <input type="text" placeholder="Guests" class="form-control text-center px-0 small" id="guest_input_show" role="button" readonly>
                        <input type="hidden" id="front-search-guests" value="1">
                        @include('includes.header-search-form-guest')
                    </div>
                    <div class="input-group-append">
                        <button type="submit" class="btn vbtn-default btn-block p-3 text-16">
                            <span class="d-none d-sm-block">{{trans('messages.home.search')}}</span>
                            <span class="d-block d-sm-none">
                                <svg width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Header menu scripts --}}
@push('scripts')
<script>
    $(function(){
        $('#front-search-form input[name="category"]:checked').parent().addClass('category_active');
        $('#front-search-form input[name="category"]').on('change', function(){
            $('#front-search-form label.category_active').removeClass('category_active');
            $('#front-search-form input[name="category"]:checked').parent().addClass('category_active');
            $('#category_search').val($(this).val());
        });
        $(".header_form input").on('focus', function(e){
            $('#front-search-form .property_category').slideDown();
        });
        // $('body').on('click', function() {
        //     $('#front-search-form .property_category').slideUp();
        // });
        // $('#front-search-form .property_category').on('click', function (e) {
        //     e.stopPropagation();
        // });
        // $('.header_form').on('click', function (e) {
        //     e.stopPropagation();
        // });
        // $("#front-search-form").on('submit', function (e) {
        //     e.preventDefault();
        //     const property_search_url = "{{asset('property.search')}}";
        //     const activity_search_url = "{{asset('activity.search')}}";
        //     const category_input = $(this).find('input[name="category"]');
        //     console.log({category_input, property_search_url, activity_search_url});
        //     if (category_input.val() == 'activities') {
        //         console.log(category_input.val());
        //     }
        // });
    });
</script>
@endpush
