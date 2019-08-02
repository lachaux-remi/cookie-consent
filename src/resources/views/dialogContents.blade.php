<div data-cookie-consent class="card shadow fixed-bottom" style="width: 335px; bottom: 30px; left: 30px;">
    <div class="card-header">
        @lang('cookieConsent::cookie.title')
    </div>

    <div class="card-body">
        @lang('cookieConsent::cookie.message')
    </div>

    <div class="card-footer d-flex justify-content-end">
        <button data-cookie-consent-agree class="btn btn-sm btn-primary">
            @lang('cookieConsent::cookie.agree')
        </button>
    </div>
</div>