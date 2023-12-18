<div class="ic_cookie_box js-cookie-consent cookie-consent">
    <div class="ic_cookie_image_box">
        <img src="{{ url('/vendor/cookie-consent/images/cookie.svg') }}" alt="cookie consent image">
    </div>
    <div class="ic_cookie_text_box">
        <p class="ic_cookie_hello">Hey, have a cookie!</p>
        <p class="ic_cookie_explain">{!! trans('cookie-consent::texts.message') !!}</p>
    </div>
    <div class="js-cookie-consent-agree cookie-consent__agree ic_button_cookie_div">
        <div class="ic_cookie_button">
            <span class="ic_span_cookie_consent">{{ trans('cookie-consent::texts.agree') }}</span>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ url('/vendor/cookie-consent/css/cookie-consent.css') }}">
