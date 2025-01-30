@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Create Admins</h5>

                <form method="POST" action="{{ route('store.admins') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Email input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required />
                    </div>
                    @if ($errors->has('email'))
						<p class="alert alert-success">{{ $errors->first('email') }}</p>
					@endif
                    <!-- Name input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" required />
                    </div>
                    @if ($errors->has('name'))
						<p class="alert alert-success">{{ $errors->first('name') }}</p>
					@endif
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                    </div>
                    @if ($errors->has('password'))
						<p class="alert alert-success">{{ $errors->first('password') }}</p>
					@endif
                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
