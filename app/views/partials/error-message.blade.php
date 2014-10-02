@if ($errors->first($field))
<div class="alert alert-danger" role="alert" style="margin-top: 5px">
    <strong>Error: </strong>{{ $errors->first($field) }}
</div>
@endif