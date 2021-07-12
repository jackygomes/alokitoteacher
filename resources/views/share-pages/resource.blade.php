@extends('master')
{{--@php 
$url = url('overview').'/r/'.$info->slug ;
$urlImg = url('images\thumbnail').'/'.$info->thumbnail ;
@endphp
@section('fb_url', $url)
@section('fb_title', $info->resource_title)
@section('fb_description', $info->description)
@section('fb_image', $urlImg)--}}

@section('meta')
<meta property="og:url" content="{{route('metaResource', $info->slug)}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{$info->resource_title}}" /> 
<meta property="og:description" content="{{$info->description}}" />
<meta property="og:image" content="{{url('images\thumbnail')}}/{{$info->thumbnail}}" />
@endsection

@section('content')
@endsection