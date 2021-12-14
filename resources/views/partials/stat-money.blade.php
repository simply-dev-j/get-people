<div class="col-12 col-lg-4 col-md-6 col-sm-6">
    <div class="stat stat-money">
        <img src="{{asset('img/currency_yen.png')}}"/>

        <div class="stat-content ml-1">
            <div class="row">
                <div class="col-6">
                    <div class="stat-item-title">
                        Pending
                    </div>
                    <div class="stat-item-value">
                        {{ auth()->user()->pending }}
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-item-title">
                        Released
                    </div>
                    <div class="stat-item-value">
                        {{ auth()->user()->released }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 right">
                    <a>See Transactions</a>
                </div>
            </div>
        </div>
    </div>
</div>
