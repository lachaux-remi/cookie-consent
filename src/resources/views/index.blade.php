@if($cookieConsentConfig['enabled'] && !$alreadyConsentedWithCookies)

    @include('cookieConsent::dialogContents')

    <script type="text/javascript">
        window.cookieConsent = (function () {
            const COOKIE_VALUE = 1;
            const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';

            function consentWithCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', COOKIE_VALUE, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                document.querySelectorAll('[data-cookie-consent]').forEach(el => {
                    el.style.display = 'none';
                })
            }

            function setCookie(name, value, expirationInDays) {
                const date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value
                    + ';expires=' + date.toUTCString()
                    + ';domain=' + COOKIE_DOMAIN
                    + ';path=/{{ config('session.secure') ? ';secure' : null }}';
            }

            if (cookieExists('{{ $cookieConsentConfig['cookie_name'] }}')) {
                hideCookieDialog();
            }

            document.querySelectorAll('[data-cookie-consent-agree]').forEach(el => {
                el.addEventListener('click', consentWithCookies)
            });

            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

@endif