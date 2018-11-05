@extends('layouts.main')

@section('title', 'Користувачі')

@section('content')

    <?php

    use Illuminate\Support\Facades\Auth;

    $curUser = Auth::user();
    ?>

    <div class="card card-profile shadow mt--300">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
                <tr class="row-user-{{ $user->id  }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="role-name">{{ $user->getRoleName() }}</td>
                    <td>



                        @if ($user->id !== $curUser->id)
                            <a class="btn btn-primary " href="{{ url('/admin/edit-user', ['id' => $user->id ]) }}">Edit</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    </div>
@endsection