@extends('master')

@section('title', 'Edit Movement')

@section('content')
    @if ($errors->count() > 0)
        @include('partials.errors')
    @endif
    <form action="{{route('movements.update', $movement)}}" method="post" class="form-group">
        @method('put')
        @csrf
        @include('movements.partials.add-edit')
        <div class="form-group">
            <label for="inputDocument">Document</label>
            <input id="inputDocument" type="file"
                   name="document_file" value="{{ old('document_file')}}" >
        </div>
        @if($movement->document_id != null)
        @foreach($movement_doc as $doc)
            <div class="form-group">
                <label for="inputDocumentDescription">Document Description</label>
                <input id="inputDocumentDescription" type="text" class="form-control"
                       name="document_description" value="{{ old('document_description', $doc->document->description)}}" >
            </div>
        @endforeach
        @else
            <div class="form-group">
                <label for="inputDocumentDescription">Document Description</label>
                <input id="inputDocumentDescription" type="text" class="form-control"
                       name="document_description" value="{{ old('document_description')}}" >
            </div>
        @endif
        <div class="form-group">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a class="btn btn-default" href="{{route('movements', $account)}}">Cancel</a>
        </div>
    </form>
@endsection
