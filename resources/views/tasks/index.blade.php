@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Task list</h1>
    </div>
</div>
<div class="row">
	<div class="col-12">
        Create a task:
        <input type="text" name="description" id="description">
        <input type="button" value="Create" onclick="createTask()">
	</div>
</div>
<br>
<div class="row">
    <div class="col-12">
        <table class="table">
            <thead>
                <th>#</th>
                <th>Description</th>
                <th>Estatus</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr id="{{ 'delete' . $task->id }}" name="{{ 'delete' . $task->id }}">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->description }}</td>
                        <td id="{{ 'status' . $task->id }}" name="{{ 'status' . $task->id }}">{{ $task->is_done ? 'Done' : 'Pending' }}</td>
                        <td><input type="button" class="btn btn-secondary" value="Change" onclick="changeStatus({{ $task->id }})"></td>
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteTask({{ $task->id }})"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('layout_end_body')
<script>
    function createTask() {
        let theDesciption = $('#description').val();
        $.ajax({
            url: '{{ route('tasks.store') }}',
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                description: theDesciption
            }
        })
        .done(function(response) {
            $('#description').val('');
            $('.table tbody').append('<tr><td>' + response.id + '</td><td>' + response.description + '</td><td>Pending</td><td><input type="button" class="btn btn-secondary" value="Change" onclick="changeStatus({{ ' + response.id + ' }})"></td><td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteTask({{ ' + response.id + ' }})"></td></tr>');
        })
        .fail(function(jqXHR, response) {
            console.log('Fail', response);
        });
    }

    function changeStatus(theID) {
        let theUrl = '{{ route('tasks.update', 0) }}' + theID;
        // sustituir el 0 por id
        $.ajax({
            url: theUrl,
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: theID
            }
        })
        .done(function(response) {
            console.log(response);
            if(response.is_done == 1) {
                $('#status' + theID).html('Done');
            }
            else {
                $('#status' + theID).html('Pending');
            }
        })
        .fail(function(jqXHR, response) {
            console.log('Fail', response);
        });
    }

    function deleteTask(theID) {
        let theUrl = '{{ route('tasks.destroy', 0) }}' + theID;
        $.ajax({
            url: theUrl,
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: theID
            }
        })
        .done(function(response) {
            console.log(response);
            $('#delete' + theID).html('');
        })
        .fail(function(jqXHR, response) {
            console.log('Fail', response);
        });
    }
</script>
@endpush
