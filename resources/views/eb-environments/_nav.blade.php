

<div class="media">
    <div class="media-left">
        <i class="fa fa-circle fa-4x status-{{ strtolower($eb_environment->status->status) }}"></i>
    </div>
    <div class="media-body">
        <h3 class="media-heading">
            {{ $eb_environment->eb_environment }}<br />
            <small>{{ $eb_environment->eb_application }}</small>
        </h3>
    </div>
</div>

<br />

<ul class="nav nav-tabs nav-tabnav">
    <li role="presentation" @if(Request::is('eb-environments/'.Request::segment(2))) class="active" @endif>
        <a href="/eb-environments/{{ $eb_environment->id }}">
            <i class="fa fa-dashboard"></i>&nbsp;
            Dashboard
        </a>
    </li>
    <li role="presentation" @if(Request::is('eb-environments/*/deployments')) class="active" @endif>
        <a href="/eb-environments/{{ $eb_environment->id }}/deployments">
            <i class="fa fa-rocket"></i>&nbsp;
            Deployments
        </a>
    </li>
    <li role="presentation" @if(Request::is('eb-environments/*/settings')) class="active pull-right" @else class="pull-right" @endif>
        <a href="/eb-environments/{{ $eb_environment->id }}/settings">
            <i class="fa fa-cog"></i>&nbsp;
            Settings
        </a>
    </li>
</ul>