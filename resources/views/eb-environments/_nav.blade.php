<ul class="nav nav-pills nav-stacked">
    <li role="presentation" @if(Request::is('eb-environments/'.Request::segment(2))) class="active" @endif>
        <a href="/eb-environments/{{ $eb_environment->id }}">
            <i class="fa fa-dashboard"></i>&nbsp;
            Dashboard
        </a>
    </li>
    <li role="presentation" @if(Request::is('eb-environments/*/deployments')) class="active" @endif>
        <a href="/eb-environments/{{ $eb_environment->id }}/deployments">
            <i class="fa fa-rocket"></i>&nbsp;
            Deployment Logs
        </a>
    </li>
    <li role="presentation" @if(Request::is('eb-environments/*/status')) class="active" @endif>
        <a href="/eb-environments/{{ $eb_environment->id }}/status">
            <i class="fa fa-circle"></i>&nbsp;
            Status Logs
        </a>
    </li>
    <li role="presentation" @if(Request::is('eb-environments/*/settings')) class="active" @endif>
        <a href="/eb-environments/{{ $eb_environment->id }}/settings">
            <i class="fa fa-cog"></i>&nbsp;
            Settings
        </a>
    </li>
</ul>