<div class="modal fade rai-status-dialog" id="admin-ui-status-dialog" tabindex="-1"
     aria-hidden="true" aria-labelledby="admin-ui-status-title" aria-describedby="admin-ui-status-message">
    <div class="modal-dialog modal-dialog-centered rai-status-dialog-dialog">
        <div class="modal-content rai-status-dialog-content rai-status-dialog-success" data-status-content>
            <div class="modal-body rai-status-dialog-body text-center">
                <div class="rai-status-dialog-icon-badge" aria-hidden="true">
                    <div class="rai-status-dialog-lottie" data-status-animation>
                        <img class="rai-status-dialog-animation"
                             data-status-gif
                             data-gif-success="{{ asset('vendor/admin-ui/gif/status-dialog/success.gif') }}"
                             data-gif-failed="{{ asset('vendor/admin-ui/gif/status-dialog/failed.gif') }}"
                             data-gif-pending="{{ asset('vendor/admin-ui/gif/status-dialog/pending.gif') }}"
                             data-gif-warning="{{ asset('vendor/admin-ui/gif/status-dialog/error_yellow.gif') }}"
                             data-gif-location="{{ asset('vendor/admin-ui/gif/status-dialog/location_map.gif') }}"
                             src="{{ asset('vendor/admin-ui/gif/status-dialog/success.gif') }}"
                             alt="">
                    </div>
                </div>

                <h3 class="rai-status-dialog-title" id="admin-ui-status-title" data-status-title></h3>
                <p class="rai-status-dialog-message" id="admin-ui-status-message" data-status-message></p>

                <div class="rai-status-dialog-actions">
                    <button type="button" class="btn rai-status-dialog-primary-button" data-status-primary>OK</button>
                    <button type="button" class="btn rai-status-dialog-secondary-button" data-status-secondary hidden>Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
