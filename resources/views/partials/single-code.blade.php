@php

@endphp

<div class="card w-100">
    <div class="card-header d-flex align-items-center" data-toggle="collapse" data-target="#code-body-{{ $code->id }}" aria-expanded="false">
        @if ($code->accepted)
            <span class="fa fa-check text-success mr-1"></span>
        @endif

        {{ $code->code }}

        <small class="ml-auto">{{ $code->created_at->diffForHumans() }}</small>
    </div>

    <div class="collapse" id="code-body-{{ $code->id }}">
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-2">
                    <label>
                        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_CODE_CREATE_AT) }}
                    </label>
                    <div>
                        {{ $code->created_at ?? '-' }}
                    </div>
                </div>

                <div class="col-12">
                    <label>
                        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_CODE_CODE) }}
                    </label>
                    <div>
                        <b>{{ $code->code }}</b>
                        <button type="button" class="btn btn-action" style="color: white" onclick="copyToClipboard('{{ $code->code }}'); showTooltip(event);"
                            data-toggle="tooltip" data-placement="bottom" title="{{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_HOME_CODE_COPIED) }}" data-trigger="'click'">
                            &#x2398;
                        </button>
                    </div>
                </div>
            </div>

            @if (!$code->accepted)
            <hr/>

            <div class="d-flex justify-content-end">
                <a href="#" onclick="event.preventDefault(); getElementById('code-delete-form-{{$code->id}}').submit();" class="text-danger">
                    <i class="far fa-trash-alt"></i>
                </a>
            </div>
            @endif
        </div>
    </div>

    <form class="d-none" id="code-delete-form-{{$code->id}}" method="post" action="{{ route(App\WebRoute::CODE_DELETE, $code) }}">
        @csrf
        @method('DELETE')
    </form>

</div>
