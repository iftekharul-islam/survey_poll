@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
  <div class="container mt-5">
    <div class="row">
      <div class="col-8 mx-auto text-center">
        @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif
      </div>
      <div class="col-6 mx-auto">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Your Basic Information for the Quiz</h5>
            <a class="btn btn-warning" href="{{ route('suggest-paper') }}">Explore More</a>
          </div>
          <div class="card-body">
            <form class="form form-vertical" action="{{ route('exam.info') }}" method="POST" id="info_form">
              @csrf
              <div class="mb-3">
                <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                <div class="input-group input-group-merge">
                  <span id="basic-icon-default-fullname2" class="input-group-text"><i class="ti ti-user"></i></span>
                  <input type="text" class="form-control" id="basic-icon-default-fullname" placeholder="John Doe" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" name="name" required/>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-icon-default-email">Email</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="ti ti-mail"></i></span>
                  <input type="text" id="basic-icon-default-email" class="form-control" name="email" placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-icon-default-email2" required/>
                  <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                </div>
                <div class="form-text"> You can use letters, numbers & periods </div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-icon-default-phone">Country</label>
                <div class="input-group input-group-merge">
                  <select class="select2 form-select" id="country_select" name="country_id">
                    @foreach ($countries as $country)
                      <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
{{--              <div class="mb-3">--}}
{{--                <label class="form-label fw-bold" for="topic_select">Topic</label>--}}
{{--                <select class="select2 form-select" id="topic_select" name="topic_id">--}}
{{--                  <option value="">Please Select a Country First</option>--}}
{{--                </select>--}}
{{--              </div>--}}
{{--              <div class="mb-3">--}}
{{--                <label class="form-label fw-bold" for="question_count">How Many Questions Do You Want?</label>--}}
{{--                <select class="select2 form-select" id="question_count" name="question_count">--}}
{{--                  <option value="">Please Select a Topic First</option>--}}
{{--                </select>--}}
{{--              </div>--}}
              <button type="submit" class="btn btn-primary">Confirm</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


{{--@section('page-script')--}}
{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('#country_select').on('change', function() {--}}
{{--                var country_id = $(this).val();--}}
{{--                $.ajax({--}}
{{--                    url: "{{ route('client.topics') }}",--}}
{{--                    type: "POST",--}}
{{--                    data: {--}}
{{--                        country_id: country_id,--}}
{{--                        _token: "{{ csrf_token() }}"--}}
{{--                    },--}}
{{--                    success: function(response) {--}}
{{--                        $html = '<option value="">Please Select a Topic</option>';--}}
{{--                        response.forEach(element => {--}}
{{--                            $html += '<option value="' + element.id + '">' + element--}}
{{--                                .name + '</option>';--}}
{{--                        });--}}
{{--                        response?.length > 0 ? $('#topic_select').html($html) : $(--}}
{{--                            '#topic_select').html(--}}
{{--                            '<option value="">No Topic Found</option>');--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}

{{--            $('#topic_select').on('change', function() {--}}
{{--                var topic_id = $(this).val();--}}
{{--                var country_id = $('#country_select').val();--}}

{{--                $.ajax({--}}
{{--                    url: "{{ route('client.questions.range') }}",--}}
{{--                    type: "POST",--}}
{{--                    data: {--}}
{{--                        country_id: country_id,--}}
{{--                        topic_id: topic_id,--}}
{{--                        _token: "{{ csrf_token() }}"--}}
{{--                    },--}}
{{--                    success: function(response) {--}}
{{--                        $html = '<option value="">Please Select a Range</option>';--}}
{{--                        for (let index = 0; index < response; index = index + 10) {--}}
{{--                            $html += '<option value="' + (response <--}}
{{--                                    index +--}}
{{--                                    10 ? response : index + 10) + '">' + '1 - ' + (response <--}}
{{--                                    index +--}}
{{--                                    10 ? response : index + 10) +--}}
{{--                                '</option>';--}}
{{--                        }--}}
{{--                        $('#question_count').html($html);--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--            $("#info_form").submit(function(event) {--}}
{{--                event.preventDefault();--}}
{{--                // validate the form--}}
{{--                var name = $('#name').val();--}}
{{--                var email = $('#email').val();--}}
{{--                var country_id = $('#country_select').val();--}}
{{--                var topic_id = $('#topic_select').val();--}}
{{--                var question_count = $('#question_count').val();--}}

{{--                if (name == '' || email == '' || country_id == '' || topic_id == '' || question_count ==--}}
{{--                    '') {--}}
{{--                    alert('Please fill all the fields');--}}
{{--                    return;--}}
{{--                }--}}

{{--                this.submit();--}}
{{--            });--}}
{{--        })--}}
{{--    </script>--}}
{{--@endsection--}}
