{{ Notification::showAll() }}
<!--
@if($errors->all())
	<div class="form-section">
	@foreach($errors->all() as $message)
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger" role="alert">
			    	{{ $message }}
			    </div>
			</div>
		</div>
	@endforeach
	</div>
@endif
-->