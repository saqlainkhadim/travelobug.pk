<?php
        $requestUri = request()->segment(4);
        ?>
<ul class="list-group customlisting">
	<li>
		<a class="btn  text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ $requestUri == 'basics'?'vbtn-outline-success active-side':'btn-outline-secondary'}} {{ $requestUri == 'basics' ? '' : 'step-inactive'  }} " href="{{$result->status != ""? url("activity/listing/$result->id/basics"):"#"}}">{{trans('messages.listing_sidebar.basic')}}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ $requestUri == 'description'?'vbtn-outline-success active-side':' btn-outline-secondary'}} {{ $requestUri == 'description' ? '' : 'step-inactive'  }}" href="{{$result->status != ""? url("activity/listing/$result->id/description"):"#"}}">{{trans('messages.listing_sidebar.description')}}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ $requestUri == 'location'?'vbtn-outline-success active-side':' btn-outline-secondary'}} {{ $requestUri == 'location' ? '' : 'step-inactive'  }}" href="{{$result->status != ""? url("activity/listing/$result->id/location"):"#"}}"> {{trans('messages.listing_sidebar.location')}}</a>
	</li>
	
	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ $requestUri == 'amenities'?'vbtn-outline-success active-side':' btn-outline-secondary'}} {{ $requestUri == 'amenities' ? 'step-inactive' : ''  }}" href="{{$result->status != ""? url("activity/listing/$result->id/amenities"):"#"}}"> {{trans('messages.listing_sidebar.amenities')}}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ $requestUri == 'photos'?'vbtn-outline-success active-side':' btn-outline-secondary'}} {{ $requestUri == 'photos' ? '' : 'step-inactive'  }}" href="{{$result->status != ""? url("activity/listing/$result->id/photos"):"#"}}"> {{trans('messages.listing_sidebar.photos')}}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ $requestUri == 'pricing'?'vbtn-outline-success active-side':' btn-outline-secondary'}} {{ $requestUri == 'pricing' ? '' : 'step-inactive'  }}" href="{{$result->status != ""? url("activity/listing/$result->id/pricing"):"#"}}"> {{trans('messages.listing_sidebar.price')}}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ $requestUri == 'booking'?'vbtn-outline-success active-side':' btn-outline-secondary'}} {{ $requestUri == 'booking'? '' : 'step-inactive'  }}" href="{{$result->status != ""? url("activity/listing/$result->id/booking"):"#"}}"> {{trans('messages.listing_sidebar.booking')}}</a>
	</li>

	<li>
		<a class="btn text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 rounded-3 {{ $requestUri == 'calendar'?'vbtn-outline-success active-side':' btn-outline-secondary'}}" href="{{$result->status != ""? url("activity/listing/$result->id/calendar"):"#"}}">{{trans('messages.listing_sidebar.calender')}}</a>
	</li>
</ul>