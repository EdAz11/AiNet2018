<div class="form-group">
    <label for="inputType">Account Type</label>
    <select name="account_type_id" id="inputType" class="form-control">
        <option disabled selected> -- select an option -- </option>
        @foreach($types as $type)
            <option value="{{$type->id}}">{{$type->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="inputCode">Code</label>
    <input
            type="text" class="form-control"
            name="code" id="inputCode"
            value="{{old('code', $account->code)}}"/>
</div>
<div class="form-group">
    <label for="inputStartBalance">Start Balance</label>
    <input
            type="text" class="form-control"
            name="start_balance" id="inputStartBalance"
            value="{{old('start_balance', $account->start_balance)}}"/>
</div>
<div class="form-group">
    <label for="inputDescription">Description</label>
    <input
            type="text" class="form-control"
            name="description" id="inputPassword"
            value="{{old('description', $account->description)}}"/>
</div>