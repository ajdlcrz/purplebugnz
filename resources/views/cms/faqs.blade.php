@extends('cms.layouts.app')

@section('content')
<faqs-management inline-template v-cloak>
  <div class="cms-page-wrapper">
      <div class="cms-page">
        <div class="header-title mb-4">
          <h1>Frequently Asked Questions</h1>
        </div>

        @if (request()->is('cms/faqs-management'))
        <div class="mb-3">
          <form :action="url" method="POST">
            @csrf

            <div v-if="method">
              @method('PUT')
            </div>

            <div class="form-group">
              <label>Question</label>

              <input name="question" type="text" class="form-control @error('question') is-invalid @enderror" v-model="form.question">

              @error('question')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label>Answer</label>

              <tinymce-editor
                api-key="q5eqi5jopju01p1l2xpwn411by2u4oxvo9men2va1eey6m4w"
                name="answer"
                rows="15"
                :init="tinymceInit()"
                v-model="form.answer"
              ></tinymce-editor>

              @error('answer')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit</button>
            <button type="button" class="btn btn-secondary btn-block" @click="cancel()">Cancel</button>
          </form>
        </div>
        @endif

        <div class="accordion cms-faqs" id="accordionFaqs">
          @foreach ($faqs as $key => $faq)
          <div class="card mb-3">
            <div class="card-header" id="heading-{{ $key }}">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $key }}" aria-expanded="true" aria-controls="collapse-{{ $key }}">
                  {{ $faq->question }}
                </button>
              </h2>
            </div>

            <div id="collapse-{{ $key }}" class="collapse" aria-labelledby="heading-{{ $key }}" data-parent="#accordionFaqs">
              <div class="card-body border-bottom">
                @if (request()->is('cms/faqs-management'))
                <button class="btn btn-info float-right" @click="editFaq({{ $faq }})">Edit FAQ</button>
                @endif

                {!! $faq->answer !!}
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
  </div>
</faqs-management>
@endsection