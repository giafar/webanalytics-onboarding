@extends('layouts.default')

@section('title', __('ui.pages.500.title'))

@section('content')
  <div class="u-flex u-flexCol u-flexJustifyCenter u-flexAlignItemsCenter">
    <p class="u-textWeight-600 u-textCenter" style="font-size: 2em">{!! nl2br(__('ui.pages.500.description')) !!}</p>
    <p><a href="{{ route('home', [], false) }}">{{ __('ui.return_home') }}</a></p>
  </div>
@endsection
