@extends('layouts.main')

@section('content')
<div class="row">
	<div class="col-12">
		<h1>Create a task</h1>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<form method="POST" action="{{ route('tasks.store') }}">
            @csrf
			<input type="text" name="description">
            <input type="submit" value="Create">
		</form>
	</div>
</div>
@endsection
