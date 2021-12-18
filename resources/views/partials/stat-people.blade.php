<div class="col-12 col-lg-4 col-md-6 col-sm-6">
    <div class="stat stat-people">
        <img src="{{asset('img/people.png')}}"/>

        <div class="stat-content ml-1">
            <div class="row">
                <div class="col-6">
                    <div class="stat-item-title">
                        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_HOME_TOTAL_CODE) }}
                    </div>
                    <div class="stat-item-value">
                        {{ auth()->user()->invite_codes()->count() }}
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-item-title">
                        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_HOME_ACCEPTED_CODE) }}
                    </div>
                    <div class="stat-item-value">
                        {{ auth()->user()->invite_codes()->where('accepted', true)->count() }}
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12 text-right">
                    <a class="stat-action" href="{{ route(App\WebRoute::CODE_INDEX) }}">
                        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_HOME_VIEW_ALL) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
