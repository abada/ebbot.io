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