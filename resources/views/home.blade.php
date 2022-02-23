@extends('layouts.app')

@section('content')
<div id="dashboard">
	<publishers-main></publishers-main>
	<books-main></books-main>
	<users-main></users-main>
	<glossary-main :route-index="'{{ route('glossary.index') }}'"></glossary-main>
	<genres-main></genres-main>
	<langs-main></langs-main>
	<authors-main></authors-main>
</div>
@endsection
