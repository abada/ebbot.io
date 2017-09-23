@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            <strong>
                                SNS Subscription HTTPS Endpoint
                            </strong>
                        </p>
                        <div style="font-family:monospace;">
                            {{ url('/api/hooks/'.$team->endpoint) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</home>
@endsection
