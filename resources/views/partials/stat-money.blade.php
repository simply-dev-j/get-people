<div class="col-12 col-lg-4 col-md-6 col-sm-6">
    <div class="stat stat-money">
        <img src="{{asset('img/currency_yen.png')}}"/>

        <div class="stat-content ml-1">
            <div class="row">
                <div class="col-6">
                    <div class="stat-item-title">
                        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_HOME_PENDING) }}
                    </div>
                    <div class="stat-item-value">
                        {{ auth()->user()->pending }}
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-item-title">
                        {{ __(App\LocaleConstants::FORM_BASE.App\LocaleConstants::FORM_HOME_RELEASED) }}
                    </div>
                    <div class="stat-item-value">
                        {{ auth()->user()->released }}
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12 text-right">
                    {{-- <a class="stat-action">Transactions</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
