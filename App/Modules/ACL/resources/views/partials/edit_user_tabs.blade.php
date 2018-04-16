@if(is_null($user))

    <ul class="nav nav-pills flex-md-column">
        <li class="nav-item"><a class="nav-link active" href="#">{{ trans('acl::user.user_details') }}</a></li>
    </ul>

@else

    <ul class="nav nav-pills flex-md-column">
        <li class="nav-item">
            <a class="nav-link {{ active_class(if_route(['user.details.edit'])) }}"
               href="{{ route('user.details.view', $user->id) }}">{{ trans('acl::user.user_details') }}</a>
        </li>
    </ul>

@endif
