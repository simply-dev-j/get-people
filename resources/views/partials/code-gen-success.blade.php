@if (Session::has('code'))
    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
        <div class="toast-header">
            <img src="..." class="rounded mr-2" alt="...">
            <strong class="mr-auto">Code Generation Success</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            {{Session::get('code')}}
            <button type="button" class="ml-2 mb-1 close" onclick="copyToClipboard('{{Session::get('code')}}')"
                data-toggle="tooltip" data-placement="bottom" title="The code is copied!" data-trigger="'click'">
                <span class="fa fa-copy"></span>
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
