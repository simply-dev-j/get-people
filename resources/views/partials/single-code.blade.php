@php

@endphp

<div class="card w-100">
    <div class="card-header d-flex" data-toggle="collapse" data-target="#code-body-{{ $code->id }}" aria-expanded="false">
        {{ $code->code }}

        <small class="ml-auto">{{ $code->created_at->diffForHumans() }}</small>
    </div>

    <div class="collapse" id="code-body-{{ $code->id }}">
        <div class="card-body">
            <div class="row">

                <div class="col-12 mb-2">
                    <label>Created At</label>
                    <div>
                        {{ $code->created_at ?? '-' }}
                    </div>
                </div>

                <div class="col-12">
                    <label>Code</label>
                    <div><b>{{ $code->code }}</b></div>
                </div>
            </div>
        </div>
    </div>

</div>
