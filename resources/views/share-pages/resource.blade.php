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
<meta property="og:image" itemprop="image" content="{{url('images\thumbnail')}}/{{$info->thumbnail}}" />
<meta property="og:image:secure_url" content="{{url('images\thumbnail')}}/{{$info->thumbnail}}" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:alt" content="{{$info->resource_title}}" />
@endsection

@section('content')
@endsection