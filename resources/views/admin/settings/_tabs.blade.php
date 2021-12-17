<ul class="nav nav-tabs nav-tabs-top nav-underline">
	@if (Auth::user()->admin->getPermission("setting_general") == 'yes')
		<li class="nav-item text-semibold">
			<a class="nav-link {{ $action == "general" ? "active" : "" }}" href="{{ action('Admin\SettingController@general') }}">
			<span class="material-icons-outlined">
tune
</span>  {{ trans('messages.general') }}</a></li>
	@endif
	@if (Auth::user()->admin->getPermission("setting_general") == 'yes')
		<li class="nav-item text-semibold">
			<a class="nav-link {{ $action == "mailer" ? "active" : "" }}" href="{{ action('Admin\SettingController@mailer') }}">
			<span class="material-icons-outlined">
email
</span> {{ trans('messages.system_email') }}</a></li>
	@endif
	@if (Auth::user()->admin->getPermission("setting_sending") == 'yes' && false)
		<li class="nav-item text-semibold">
			<a class="nav-link {{ $action == "sending" ? "active" : "" }}" href="{{ action('Admin\SettingController@sending') }}">
			<span class="material-icons-outlined">
forward_to_inbox
</span> {{ trans('messages.sending') }}</a></li>
	@endif
	@if (Auth::user()->admin->getPermission("setting_system_urls") == 'yes')
		<li class="nav-item text-semibold">
			<a class="nav-link {{ $action == "urls" ? "active" : "" }}" href="{{ action('Admin\SettingController@urls') }}">
			<span class="material-icons-outlined">
link
</span> {{ trans('messages.system_urls') }}</a></li>
	@endif
	@if (Auth::user()->admin->getPermission("setting_background_job") == 'yes')
		<li class="nav-item text-semibold">
			<a class="nav-link {{ $action == "cronjob" ? "active" : "" }}" href="{{ action('Admin\SettingController@cronjob') }}">
			<span class="material-icons-outlined">
alarm
</span> {{ trans('messages.background_job') }}</a></li>
	@endif
	@if (Auth::user()->admin->getPermission("setting_general") == 'yes')
		<li class="nav-item text-semibold">
			<a class="nav-link {{ $action == "license" ? "active" : "" }}" href="{{ action('Admin\SettingController@license') }}">
			<span class="material-icons-outlined">
vpn_key
</span> {{ trans('messages.license_tab') }}</a></li>
	@endif
	@if (Auth::user()->admin->getPermission("setting_upgrade_manager") == 'yes')
		<li class="nav-item text-semibold">
			<a class="nav-link {{ $action == "upgrade" ? "active" : "" }}" href="{{ action('Admin\SettingController@upgrade') }}">
				<img src="{{ url('images/upgrade.svg') }}" width="20px" class="me-2" /> <span>{{ trans('messages.upgrade.title.upgrade') }}</span></a></li>
	@endif
</ul>
