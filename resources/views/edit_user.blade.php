@extends('layouts.main')

@section('title', 'Користувачі')

@section('content')

    <?php
    use App\Role;

    $roles = Role::query()->get();
    ?>

    <div class="card card-profile shadow mt--300">
        <div class="px-4">

            <div class="mt-5 py-5 border-top">
                <div class="row">
                    <div class="col-lg-9 m-lg-auto">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                            </div>
                        @endif

                        <form action="{{ url('/admin/edit-user-save', ['id' => $user->id]) }}" method="post">
                            @csrf

                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <input id="name" placeholder="Name" type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name" value="{{ old('name')?old('name'):$user->name }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <input id="email" placeholder="Email" type="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email"
                                           value="{{ old('email')?old('email'):$user->email }}" >

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <select name="role_id" class="form-control" id="role-select">
                                        @foreach($roles as $role)
                                            <option <?php if($role->id == $user->getRoleId()) { ?> selected="selected"<?php } ?>value="{{ $role->id }}">{{ strtoupper($role->name) }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('role_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('role_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection