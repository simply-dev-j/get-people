@if (Session::has('code'))
    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
        <div class="toast-header">

            <strong class="mr-auto">
                <i class="fas fa-check-circle"></i>
                {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_HOME_CODE_GEN_SUC) }}
            </strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            {{Session::get('code')}}
            <button type="button" class="btn btn-action" style="color: black" onclick="copyToClipboard('{{ Session::get('code') }}'); showTooltip(event);"
                data-toggle="tooltip" data-placement="bottom" title="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_HOME_CODE_COPIED) }}" data-trigger="'click'">
                &#x2398;
            </button>
        </div>
    </div>

    <script>
        window.addEventListener('load', function(e) {
            $('.toast').toast({
                autohide: false,
            }).toast('show');
        });
    </script>
@endif
