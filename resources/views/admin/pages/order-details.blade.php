@extends('admin.layouts.app')
@section('content')
@livewire('admin.order-details', ['order'=>$order->id])
@endsection
