@extends('layouts.core.backend')

@section('title', trans('messages.open_log'))

@section('page_header')

			<div class="page-title">				
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li class="breadcrumb-item"><a href="{{ action("Admin\HomeController@index") }}">{{ trans('messages.home') }}</a></li>
				</ul>
				<h1>
					<span class="text-semibold"><span class="material-icons-round">
                format_list_bulleted
                </span> {{ trans('messages.open_log') }}</span>
				</h1>				
			</div>

@endsection

@section('content')
				
				<div class="listing-form"
					data-url="{{ action('Admin\OpenLogController@listing') }}"
					per-page="{{ Acelle\Model\OpenLog::$itemsPerPage }}"					
				>				
					<div class="d-flex top-list-controls top-sticky-content">
						<div class="me-auto">
							@if ($items->count() >= 0)					
								<div class="filter-box">
									<span class="filter-group">
										<span class="title text-semibold text-muted">{{ trans('messages.sort_by') }}</span>
										<select class="select" name="sort_order">
                                            <option value="open_logs.created_at">{{ trans('messages.created_at') }}</option>
										</select>										
										<input type="hidden" name="sort_direction" value="desc" />
<button type="button" class="btn btn-xs sort-direction" data-popup="tooltip" title="{{ trans('messages.change_sort_direction') }}" role="button" class="btn btn-xs">
											<span class="material-icons-outlined desc">
sort
</span>
										</button>
									</span>
									<span class="me-2">										
										<select data-placeholder="{{ trans('messages.all_campaigns') }}" class="select2-ajax" name="campaign_uid" data-url="{{ action('CampaignController@select2') }}">
											
										</select>									
									</span>
									<span class="text-nowrap">
										<input type="text" name="keyword" class="form-control search" value="{{ request()->keyword }}" placeholder="{{ trans('messages.type_to_search') }}" />
										<span class="material-icons-round">
search
</span>
									</span>
								</div>
							@endif
						</div>
					</div>
					
					<div class="pml-table-container">
						
						
						
					</div>
				</div>				

				<script>
					var OpenLogsIndex = {
						getList: function() {
							return makeList({
								url: '{{ action('Admin\OpenLogController@listing') }}',
								container: $('.listing-form'),
								content: $('.pml-table-container')
							});
						}
					};
			
					$(function() {
						OpenLogsIndex.getList().load();
					});
				</script>
@endsection
