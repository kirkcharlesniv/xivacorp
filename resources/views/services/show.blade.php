@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>
<div class="container-fluid mt--6">
    @if(auth()->user()->role->value == 1)
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Create New Answerable Form</h3>
                </div>
                <!-- Light table -->
                <form action="{{ route('services.forms.create', $current_id) }}" method="POST">
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <select class="custom-select" id="form_id" name="form_id">
                                    <option disabled>Choose...</option>
                                    @foreach($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="custom-select" id="user_id" name="user_id">
                                    <option disabled>Choose...</option>
                                    <option value="{{ $service->client->id }}">{{ $service->client->name }}</option>
                                    <option value="{{ auth()->user()->id }}">Health Care Provider (You)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col">
        <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Forms</h3>
                </div>
                <!-- Light table -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Form</th>
                                    <th scope="col" class="sort" data-sort="name">Answerable By</th>
                                    <th scope="col" class="sort" data-sort="name">Timestamp</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($available_forms as $form)
                                    <tr>
                                        <th>{{ $form->form->name }}</th>
                                        <td>{{ $form->answerer->name }}</td>
                                        <td>{{ $form->created_at }}</td>
                                        <td>
                                        @if( $form->answerable_by == auth()->user()->id)
                                        <a href="{{ route('services.forms.answer', [$service->id, $form->id]) }}" class="btn btn-primary my-4">Answer/Update</a>
                                        @endif
                                        <a href="{{ route('services.forms.response', [$service->id, $form->id]) }}" class="btn btn-primary my-4">View Response</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
@endpush