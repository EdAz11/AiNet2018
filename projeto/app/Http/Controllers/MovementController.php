<?php

namespace App\Http\Controllers;

use App\Account;
use App\Document;
use App\Http\Requests\StoreMovementRequest;
use App\Http\Requests\UpdateMovementRequest;
use App\Movement;
use App\MovementCategory;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    /**
     * MovementController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Movements US.20
    public function movementsIndex(Account $account)
    {
        $movements = $account->movements()->orderBy('date', 'desc')->get();
        $document = 1;
        return view('movements.index', compact('movements', 'account', 'document'));
    }

    //Movements US.21
    public function create(Account $account)
    {
        $types = MovementCategory::all();
        $movement = new Movement;
        return view('movements.add', compact('account','types', 'movement'));
    }

    //Movements US.21
    public function store(StoreMovementRequest $request, Account $account)
    {
        $movements = $account->movements()->orderBy('date', 'desc')->first();
        $data = $request->validated();
        $type = MovementCategory::find($data['movement_category_id']);
        $data['type'] = $type['type'];
        $data['account_id'] = $account->id;
        if ($movements != null){
            $data['start_balance'] = $movements['end_balance'];
        }else
            $data['start_balance']= 0;
        if ($data['type'] == 'expense'){
            $data['end_balance'] = $data['start_balance'] - $data['value'];
        } elseif ($data['type'] == 'revenue'){
            $data['end_balance'] = $data['start_balance'] + $data['value'];
        }

        /*
        if ($request->has('document_file')){
            $splitDoc = explode('.',$data['document_file']);
            $document['type'] = $splitDoc[0];
            Document::create($document);
        }
        */
        Movement::create($data);

        return redirect()
            ->route('movements', $account)
            ->with('success', 'Movement added successfully');
    }

    //Movements US.21
    public function edit(Movement $movement)
    {
        $types = MovementCategory::all();
        $account = Account::find($movement->account_id);
        return view('movements.edit', compact('types', 'movement', 'account'));
    }

    //Movements US.21
    public function update(UpdateMovementRequest $request, Movement $movement)
    {
        $data = $request->validated();
        $type = MovementCategory::find($data['movement_category_id']);
        $data['type'] = $type['type'];
        $movement->fill($data);
        $movement->save();
        return redirect()
            ->route('movements', $movement->account())
            ->with('success', 'Movement updated successfully');
    }

    //Movements US.21
    public function destroy(Movement $movement)
    {
        $account = Account::find($movement->account_id);
        $movement->delete();
        return redirect()
            ->route('movements', $account)
            ->with('success', 'Movement deleted successfully');
    }
}
