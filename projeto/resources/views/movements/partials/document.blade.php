<div class="form-group">
    <label for="inputDocument">Document</label>
    <input id="inputDocument" type="file"
           name="document_file" value="{{ old('document_file', $movement->document_file)}}" >
</div>
<div class="form-group">
    <label for="inputDocumentDescription">Document Description</label>
    <input id="inputDocumentDescription" type="text" class="form-control"
           name="document_description" value="{{ old('document_description', $movement->document_description)}}" >
</div>