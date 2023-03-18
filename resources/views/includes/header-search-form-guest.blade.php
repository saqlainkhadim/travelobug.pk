<div class="position-absolute right bg-white shadow-lg mt-4 p-5 border rounded-4" id="guest_input_modal" style="width:300px;margin-right:-40px;display:none">
    {{-- Adults --}}
    <div class="adults d-flex justify-content-between align-items-center border-bottom-0 pb-2">
        <div class="_1hhulki">
            <div class="_rtmzs6z">Adults</div>
            <div class="small text-secondary">Ages 13 or above</div>
        </div>
        <div id="stepper-adults">
            <div class="py-2 d-flex align-items-center">
                <button class="gstepper minus border rounded-circle p-3" type="button" role="button" disabled>
                    <svg viewBox="0 0 32 32" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.33333; overflow: visible">
                        <path d="m2 16h28"></path>
                    </svg>
                </button>
                <div class="px-3 text-center" style="width:35px">
                    <span class="adult_count">1</span>
                </div>
                <button class="gstepper plus border rounded-circle p-3" type="button" role="button">
                    <svg viewBox="0 0 32 32" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.33333; overflow: visible">
                        <path d="m2 16h28m-14-14v28"></path>
                    </svg>
                </button>
            </div>
            <input type="hidden" value="1" id="adult_count">
        </div>
    </div>
    {{-- Children --}}
    {{-- <div class="children d-flex justify-content-between align-items-center border-bottom py-4">
        <div class="_1hhulki">
            <div class="_rtmzs6z">Children</div>
            <div class="small text-secondary">Ages 2 - 12</div>
        </div>
        <div id="stepper-children">
            <div class="py-2 d-flex align-items-center">
                <button class="gstepper minus border rounded-circle p-3" type="button" role="button" disabled>
                    <svg viewBox="0 0 32 32" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.33333; overflow: visible">
                        <path d="m2 16h28"></path>
                    </svg>
                </button>
                <div class="px-3 text-center" style="width:35px">
                    <span class="child_count">0</span>
                </div>
                <button class="gstepper plus border rounded-circle p-3" type="button" role="button">
                    <svg viewBox="0 0 32 32" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.33333; overflow: visible">
                        <path d="m2 16h28m-14-14v28"></path>
                    </svg>
                </button>
            </div>
            <input type="hidden" value="0" id="child_count">
        </div>
    </div>
    {{-- Infants --}}
    {{-- <div class="infants d-flex justify-content-between align-items-center pt-4">
        <div class="_1hhulki">
            <div class="_rtmzs6z">Infants</div>
            <div class="small text-secondary">Under 2</div>
        </div>
        <div id="stepper-infants">
            <div class="py-2 d-flex align-items-center">
                <button class="gstepper minus border rounded-circle p-3" type="button" role="button" disabled>
                    <svg viewBox="0 0 32 32" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.33333; overflow: visible">
                        <path d="m2 16h28"></path>
                    </svg>
                </button>
                <div class="px-3 text-center" style="width:35px">
                    <span class="infant_count">0</span>
                </div>
                <button class="gstepper plus border rounded-circle p-3" type="button" role="button">
                    <svg viewBox="0 0 32 32" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.33333; overflow: visible">
                        <path d="m2 16h28m-14-14v28"></path>
                    </svg>
                </button>
            </div>
            <input type="hidden" value="0" id="infant_count">
        </div>
    </div> --}}
</div>

@push('scripts')
    <script>
        $(function(jq){
            const guest_input_show = jq('#guest_input_show');
            const guest_input_total = jq('#front-search-guests');
            const adult_input = jq('#stepper-adults #adult_count');
            const adult_text = jq('#stepper-adults .adult_count');
            const adult_plus_btn = jq('#stepper-adults .gstepper.plus');
            const adult_minus_btn = jq('#stepper-adults .gstepper.minus');
            const child_input = jq('#stepper-children #child_count');
            const child_text = jq('#stepper-children .child_count');
            const child_plus_btn = jq('#stepper-children .gstepper.plus');
            const child_minus_btn = jq('#stepper-children .gstepper.minus');
            const infant_input = jq('#stepper-infants #infant_count');
            const infant_text = jq('#stepper-infants .infant_count');
            const infant_plus_btn = jq('#stepper-infants .gstepper.plus');
            const infant_minus_btn = jq('#stepper-infants .gstepper.minus');
            const all_plus_btn = jq('.gstepper.plus');
            const all_minus_btn = jq('.gstepper.minus');

            const MIN_ADULT = 1;
            const MIN_INFANT = 5;
            const MAX_GUEST = 16;

            const get_total_guest = function () {
                // return parseInt(adult_input.val()) + parseInt(child_input.val())
                return parseInt(adult_input.val());
            }

            const GetMaxGuest = function (guest) {
                if (guest == 'adult') {
                    return MAX_GUEST - parseInt(child_input.val());
                }
                // if (guest == 'child') {
                //     return MAX_GUEST - parseInt(adult_input.val());
                // }
                return  0;
            }

            const enable_disable_adult_btns = function (adultCount) {
                if (adultCount >= MIN_ADULT) {
                    adult_minus_btn.prop('disabled', false);
                }
                if (adultCount <= MIN_ADULT) {
                    adult_minus_btn.prop('disabled', true);
                }
                if (adultCount < GetMaxGuest('adult')){
                    adult_plus_btn.prop('disabled', false);
                } else {
                    adult_plus_btn.prop('disabled', true);
                }
            }

            // const enable_disable_child_btns = function (childCount) {
            //     if (childCount > 0) {
            //         child_minus_btn.prop('disabled', false);
            //     } else {
            //         child_minus_btn.prop('disabled', true);
            //     }
            //     if (childCount < GetMaxGuest('child')){
            //         child_plus_btn.prop('disabled', false);
            //     } else {
            //         child_plus_btn.prop('disabled', true);
            //     }
            // }

            // const enable_disable_infant_btns = function (infantCount) {
            //     if (infantCount > 0) {
            //         infant_minus_btn.prop('disabled', false);
            //     } else {
            //         infant_minus_btn.prop('disabled', true);
            //     }
            //     if (infantCount < 5){
            //         infant_plus_btn.prop('disabled', false);
            //     } else {
            //         infant_plus_btn.prop('disabled', true);
            //     }
            // }

            const update_guest_inputs = function () {
                const total_guest = get_total_guest();
                // const infant_count = parseInt(infant_input.val());

                guest_input_text = `${total_guest} ${total_guest > 1 ? 'guests' : 'guest'}`;

                // if(infant_count > 0){
                //     guest_input_text += `, ${infant_count} ${infant_count > 1 ? 'infants' : 'infant'}`;
                // }

                guest_input_show.val(guest_input_text);

                if(total_guest != 0){
                    guest_input_total.val(total_guest);
                }  else {
                    guest_input_total.val(1);
                }
            }

            const disable_adult_child_plus_btns = function () {
                const TOTAL_GUEST = get_total_guest();
                // console.log({TOTAL_GUEST, MAX_GUEST});

                if (TOTAL_GUEST >= MAX_GUEST) {
                    adult_plus_btn.attr('disabled', 'disabled')
                    child_plus_btn.attr('disabled', 'disabled');
                } else {
                    adult_plus_btn.prop('disabled', false);
                    child_plus_btn.prop('disabled', false);
                }
            }

            const set_adult_stepper_value = function (adultCount) {
                adult_input.val(adultCount);
                adult_text.text(adultCount);
                update_guest_inputs();
                disable_adult_child_plus_btns();
            }

            // const set_child_stepper_value = function (childCount) {
            //     child_input.val(childCount);
            //     child_text.text(childCount);
            //     update_guest_inputs();
            //     disable_adult_child_plus_btns();
            // }

            // const set_infant_stepper_value = function (infantCount) {
            //     infant_input.val(infantCount);
            //     infant_text.text(infantCount);
            //     update_guest_inputs();
            // }

            adult_plus_btn.on('click', function(){
                let adultCount = parseInt(adult_input.val());
                adultCount = adultCount ? (adultCount + 1) : 1;
                enable_disable_adult_btns(adultCount);
                set_adult_stepper_value(adultCount);
            });

            adult_minus_btn.on('click', function(){
                let adultCount = parseInt(adult_input.val());
                adultCount = adultCount ? (adultCount - 1) : 1;
                enable_disable_adult_btns(adultCount);
                set_adult_stepper_value(adultCount);
            });

            // child_plus_btn.on('click', function () {
            //     let childCount = parseInt(child_input.val());
            //     childCount = childCount ? (childCount + 1) : 1;
            //     enable_disable_child_btns(childCount);
            //     set_child_stepper_value(childCount);
            // });

            // child_minus_btn.on('click', function(){
            //     let childCount = parseInt(child_input.val());
            //     childCount = childCount ? (childCount - 1) : 0;
            //     enable_disable_child_btns(childCount);
            //     set_child_stepper_value(childCount);
            // });

            // infant_plus_btn.on('click', function () {
            //     let infantCount = parseInt(infant_input.val());
            //     infantCount = infantCount ? (infantCount + 1) : 1;
            //     enable_disable_infant_btns(infantCount);
            //     set_infant_stepper_value(infantCount);
            // });

            // infant_minus_btn.on('click', function(){
            //     let infantCount = parseInt(infant_input.val());
            //     infantCount = infantCount ? (infantCount - 1) : 0;
            //     enable_disable_infant_btns(infantCount);
            //     set_infant_stepper_value(infantCount);
            // });

            jq('#guest_input_show').on('click', function(e){
                e.stopPropagation();
                jq('#guest_input_modal').toggle();
            });

            jq('body').on('click', function(){
                jq('#guest_input_modal').hide();
            });

            jq('#guest_input_modal').on('click', function (e) {
                e.stopPropagation();
            });
        });
    </script>
@endpush
