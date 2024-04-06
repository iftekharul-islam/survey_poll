@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
    <h4>Home Page</h4>
    <h3>
        Your Basic Information
    </h3>
    <div class="row">
        <div class="col-6">
            <div class="mb-1">
                <label class="form-label fw-bold" for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-1">
                <label class="form-label fw-bold" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-1">
                <label class="form-label  fw-bold" for="country_select">Country</label>
                <div class="col">
                    <select class="select2 form-select" id="country_select" name="country_id">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="mb-1">
                <label class="form-label fw-bold" for="topic_select">Topic</label>
                <select class="select2 form-select" id="topic_select" name="topic_id">
                    <option value="">Please Select a Country First</option>
                </select>
            </div>
        </div>

        <div class="col-6">
            <div class="mb-1">
                <label class="form-label fw-bold" for="topic_select">How Many Questions Do You Want?</label>
                <select class="select2 form-select" id="question_count" name="question_count">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>

            </div>
        </div>
    </div>
@endsection


@section('page-script')
    <script>
        // when client set any country then the topics will be loaded
        $('#country_select').change(function() {
            var country_id = $(this).val();
            $.ajax({
                url: "{{ route('client.topics') }}",
                type: "POST",
                data: {
                    country_id: country_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#topic_select').html(response);
                }
            });
        });
    </script>
@endsection
