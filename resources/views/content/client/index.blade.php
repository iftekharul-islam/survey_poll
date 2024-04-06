@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
    <div class="container mt-5">
        <h3>
            Your Basic Information
        </h3>
        <div class="row">
            <form class="form form-vertical" action="{{ route('exam.info') }}" method="POST" id="info_form">
                @csrf
                <div class="col-6">
                    <div class="mb-1">
                        <label class="form-label fw-bold" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter your name">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-1">
                        <label class="form-label fw-bold" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your email">
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
                        <label class="form-label fw-bold" for="question_count">How Many Questions Do You Want?</label>
                        <select class="select2 form-select" id="question_count" name="question_count">
                            <option value="">Please Select a Topic First</option>
                        </select>

                    </div>
                </div>

                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#country_select').on('change', function() {
                var country_id = $(this).val();
                $.ajax({
                    url: "{{ route('client.topics') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $html = '<option value="">Please Select a Topic</option>';
                        response.forEach(element => {
                            $html += '<option value="' + element.id + '">' + element
                                .name + '</option>';
                        });
                        response?.length > 0 ? $('#topic_select').html($html) : $(
                            '#topic_select').html(
                            '<option value="">No Topic Found</option>');
                    }
                });
            });

            $('#topic_select').on('change', function() {
                var topic_id = $(this).val();
                var country_id = $('#country_select').val();

                $.ajax({
                    url: "{{ route('client.questions.range') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        topic_id: topic_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $html = '<option value="">Please Select a Range</option>';
                        for (let index = 0; index < response; index = index + 10) {
                            $html += '<option value="' + (response <
                                    index +
                                    10 ? response : index + 10) + '">' + '1 - ' + (response <
                                    index +
                                    10 ? response : index + 10) +
                                '</option>';
                        }
                        $('#question_count').html($html);
                    }
                });
            });
            $("#info_form").submit(function(event) {
                event.preventDefault();
                // validate the form
                var name = $('#name').val();
                var email = $('#email').val();
                var country_id = $('#country_select').val();
                var topic_id = $('#topic_select').val();
                var question_count = $('#question_count').val();

                if (name == '' || email == '' || country_id == '' || topic_id == '' || question_count ==
                    '') {
                    alert('Please fill all the fields');
                    return;
                }

                this.submit();
            });
        })
    </script>
@endsection
