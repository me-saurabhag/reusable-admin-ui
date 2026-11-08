<div
    class="modal fade rai-otp-modal"
    id="admin-ui-otp-modal"
    tabindex="-1"
    aria-labelledby="adminUiOtpTitle"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    data-default-top-image="{{ config('admin-ui.auth.otp_dialog.top_image', 'https://bot.kotfumes.com/assets/app/images/otp_top_graphic.webp') }}"
    data-default-timer="{{ (int) config('admin-ui.auth.otp_dialog.resend_timer', 120) }}"
>
    <div class="modal-dialog modal-dialog-centered otp-modal-dialog">
        <div class="modal-content otp-modal">
            <button type="button" class="otp-close-btn" data-otp-close aria-label="Close verification dialog" hidden>
                <i data-feather="x"></i>
            </button>

            <div class="otp-banner" data-otp-banner>
                <img
                    src="{{ config('admin-ui.auth.otp_dialog.top_image', 'https://bot.kotfumes.com/assets/app/images/otp_top_graphic.webp') }}"
                    class="otp-graphic"
                    data-otp-top-image
                    alt="OTP verification"
                >
            </div>

            <div class="modal-body">
                <div class="text-center otp-header">
                    <h4 id="adminUiOtpTitle" class="otp-title">Verify OTP</h4>
                    <p class="otp-subtext mb-0" data-otp-subtitle>We have sent a 6-digit verification code to</p>
                    <div class="otp-mobile-row">
                        <strong class="otp-mobile" data-otp-mobile></strong>
                        <button type="button" class="otp-edit-btn" data-otp-edit aria-label="Edit mobile number" hidden>
                            <i data-feather="edit-2"></i>
                        </button>
                    </div>
                </div>

                <div class="otp-inputs" data-otp-inputs role="group" aria-label="OTP verification code">
                    @php($otpLength = max(4, min(8, (int) config('admin-ui.auth.otp_dialog.otp_length', 6))))
                    @for($i = 1; $i <= $otpLength; $i++)
                        <input
                            type="text"
                            maxlength="1"
                            class="otp-input"
                            data-otp-digit
                            inputmode="numeric"
                            autocomplete="{{ $i === 1 ? 'one-time-code' : 'off' }}"
                            pattern="[0-9]*"
                            placeholder="&bull;"
                            aria-label="OTP digit {{ $i }}"
                        >
                    @endfor
                </div>

                <button type="button" class="otp-verify-btn" data-otp-verify disabled>
                    <span data-otp-verify-label>Verify OTP</span>
                    <i data-feather="arrow-right"></i>
                </button>

                <div class="otp-divider" data-otp-divider>
                    <span data-otp-resend-prompt>Didn't receive the code?</span>
                </div>

                <div class="text-center otp-resend-wrapper">
                    <button type="button" class="otp-resend-btn" data-otp-resend disabled>
                        Resend OTP <span data-otp-countdown></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
