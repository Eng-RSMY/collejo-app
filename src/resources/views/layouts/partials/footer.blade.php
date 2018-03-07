<footer class="text-center text-muted">
	{{ date('Y', time()) }} {!! trans('common.copyright_text', ['link' => trans('common.copyright_link')]) !!}

	@if(env('APP_DEBUG') && Auth::user())
		<!--pre>
		{{ print_r(['email' => Auth::user()->email, 'roles' => Auth::user()->roles->only('role')->all()]) }}
		</pre-->
	@endif
</footer>

{{ Asset::renderScripts() }}

<script type="text/javascript">
    Collejo.lang = {!! json_encode(Lang::get('common')) !!}
</script>