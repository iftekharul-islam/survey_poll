@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Question Create')

@section('content')
<h4>Create Question</h4>


<!-- Basic Horizontal form layout section start -->
<section id="basic-horizontal-layouts">
  <div class="row">
    <div class="col-md-6 col-12">

    </div>
    <div class="col-md-6 col-12">
      <div class="card">

        <div class="card-body">
          <form class="form form-vertical" action="{{ route('store-question') }}" method="POST">
            @csrf
            <div class="row">

              <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="select2-basic">Country</label>

                  <div class="col">
                    <select class="select2 form-select" id="select2-basic">
                      @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                      @endforeach
                    </select>

                    {{-- <div class="col-auto">
                      <button type="button" class="btn btn-primary me-1 addMore">Submit</button>
                    </div> --}}

                  </div>

                </div>
              </div>

              <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="select2-basic">Topic</label>
                  <select class="select2 form-select" id="select2-basic" name="topic_id">
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                      @endforeach

                  </select>

                </div>
              </div>

              <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="question">Question</label>
                  <input
                    type="text"
                    id="question"
                    class="form-control"
                    name="question"
                    placeholder="New Question"
                  />
                </div>
              </div>

              <div class="row">
                <div class="col-8">
                    <div class="mb-1">
                        <label class="form-label" for="question">Options</label>
                        <div id="inputFieldContainer">
                            <div class="row inputField">
                                <div class="col">
                                    <input
                                        type="text"
                                        id="options"
                                        class="form-control"
                                        name="options[]"
                                        placeholder="New options"
                                    />
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary me-1 addMore">Add More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary me-1">Submit</button>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



</section>
<!-- Basic Horizontal form layout section end -->


@endsection


@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function() {
      $('.addMore').click(function() {
          var inputField = $('.inputField:first').clone();
          inputField.find('input').val('');
          inputField.find('.addMore').remove();
          $('#inputFieldContainer').append(inputField);
      });
  });
  </script>
@endsection



