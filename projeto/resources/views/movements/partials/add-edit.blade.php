<div class="form-group">
    <label for="inputType">Movement Type</label>
    <select name="movement_category_id" id="inputType" class="form-control">
        <option disabled selected> -- select an option -- </option>
        @foreach($types as $type)
            <option value="{{$type->id}}">{{$type->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="inputDate">Date</label>
    <input
            type="text" class="form-control"
            name="date" id="inputDate"
            value="{{old('date', $movement->date)}}"/>
</div>
<div class="form-group">
    <label for="inputValue">Value</label>
    <input
            type="text" class="form-control"
            name="value" id="inputValue"
            value="{{old('value', $movement->value)}}"/>
</div>
<div class="form-group">
    <label for="inputDescription">Description</label>
    <input
            type="text" class="form-control"
            name="description" id="inputPassword"
            value="{{old('description', $movement->description)}}"/>
</div>
