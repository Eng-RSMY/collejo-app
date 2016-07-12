@extends('collejo::dash.sections.tab_view')

@section('title', $student->name)

@section('tools')

<a href="{{ route('student.addresses.edit', $student->id) }}" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> Edit</a>  

@endsection

@section('tabs')

    @include('students::partials.view_tabs')

@endsection

@section('tab')


<div id="addresses" class="column-list">

    <div class="columns">

        @foreach($student->addresses as $address)

            @include('students::partials.address')

        @endforeach

    </div>

    <div class="col-md-6">
        <div class="placeholder">This user does not have any contacts defined.</div>
    </div>


</div>  

<div class="clearfix"></div>


@endsection