@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
  <div class="container mt-5">
    <div class="row ">
      <div class="col-6 mx-auto card py-3 px-3">
        <h3 class="text-center">
          Select from Catalog
          <a class="btn btn-warning" href="{{ route('home') }}">Back To Home</a>
        </h3>
        <form action="{{ route('suggest-paper') }}" method="get">
          <div class="mb-1">
            <label class="form-label" for="country_select">Country</label>
            <div class="col">
              <select class="select2 form-select" id="country_select" name="country_id">
                @foreach ($countries as $country)
                  <option value="{{ $country->id }}" @if(request()->has('country_id')) {{ request()->has('country_id') == $country->id ? 'selected' : ''}}  @endif>{{ $country->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div style="display: flex; justify-content: center;">
            <button class="btn btn-success mt-3" type="submit">Get suggestions</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @if(count($questions))
    <div class="container mt-5">
      <div class="row ">
      <div class="col-6 mx-auto card py-3 px-3">
        <h2 class="text-center">
          Suggestions
        </h2>
        <div class="row">
          @foreach ($questions as $index => $question)
            <div class="border rounded mb-1 p-2">
              <div class="mb-1">
                @if ($question->images)
                  @foreach ($question->images as $image)
                    <img src="{{ asset('storage/images/' . $image->image) }}" alt="question image"
                         class="img-fluid" style="max-height: 200px; max-width: 200px;">
                  @endforeach
                @endif
              </div>
              <div class="mb-1">
                <h3>{{ $index + 1 . '. ' . $question->question }}</h3>
              </div>
              <div class="mb-1">
                @foreach ($question->options as $key => $option)
                  <br />
                  <label for="option1"
                         class="{{ $question->right_id == $option->id ? 'text-success' : '' }}">{{ $key + 1 . '.' . $option->option }}
                      @if ($option->id == $question->right_id)
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check"
                             width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                             stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M5 12l5 5l10 -10" />
                        </svg>
                      @endif
                  </label>
                  <br />
                @endforeach
              </div>
            </div>
          @endforeach

        </div>
        <div class="row mt-3">
          <div class="mx-auto d-flex justify-content-center">
            <nav aria-label="Page navigation">
              <ul class="pagination mt-2">
                <li class="page-item prev"><a class="page-link"
                                              style="pointer-events: {{ $questions->currentPage() == 1 ? 'none' : '' }}"
                                              href="{{ $questions->url($questions->currentPage() - 1) }}">
                    {{ '<' }}
                  </a>
                </li>
                @for ($i = 1; $i <= $questions->lastPage(); $i++)
                  <li class="page-item {{ $i == $questions->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $questions->url($i) }}">{{ $i }}</a>
                  </li>
                @endfor
                <li class="page-item next" disabled><a class="page-link"
                                                       style="pointer-events: {{ $questions->currentPage() == $questions->lastPage() ? 'none' : '' }}"
                                                       href="{{ $questions->url($questions->currentPage() + 1) }}">{{ '>' }}</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
    </div>
  @elseif (request()->has('country_id'))
    <div class="container mt-5">
      <div class="row ">
        <div class="col-6 mx-auto">
      <div class="card-body">
        <div class="alert alert-danger" role="alert">
          No suggestions Found
        </div>
      </div>
        </div>
    </div>
  @endif
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
