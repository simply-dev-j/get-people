<div class="col-12 col-lg-4 col-md-6 col-sm-6">
    <div class="stat stat-people">
        <img src="{{asset('img/people.png')}}"/>

        <div class="stat-content ml-1">
            <div class="row">
                <div class="col-6">
                    <div class="stat-item-title">
                        Total
                    </div>
                    <div class="stat-item-value">
                        {{ auth()->user()->invite_codes()->count() }}
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-item-title">
                        Accept
                    </div>
                    <div class="stat-item-value">
                        {{ auth()->user()->invite_codes()->where('accepted', true)->count() }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 right">
                    <a href="{{ route(App\WebRoute::CODE_INDEX) }}">Details</a>
                </div>
            </div>
        </div>
    </div>
</div>
