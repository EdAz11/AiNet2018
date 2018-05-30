<?php

namespace App\Http\Controllers;

use App\Account;
use App\Document;
use App\Http\Requests\StoreMovementRequest;
use App\Http\Requests\UpdateMovementRequest;
use App\Movement;
use App\MovementCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\DeclareDeclare;

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
        //$this->authorize('view', $account);
        $movements = Movement::with('category')->orderBy('date', 'desc')->get();
        return view('movements.index', compact('movements', 'account'));
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
        $movement['movement_category_id'] = $type['id'];
        $movement['type'] = $type['type'];
        $movement['date'] = $data['date'];
        $movement['account_id'] = $account->id;
        $movement['value'] = $data['value'];

        if ($request->has('description')){
            $movement['description'] = $data['description'];
        }

        if ($movements != null){
            $movement['start_balance'] = $movements['end_balance'];
        }else
            $movement['start_balance']= 0;

        if ($movement['type'] == 'expense'){
            $movement['end_balance'] = $movement['start_balance'] - $movement['value'];
        } elseif ($movement['type'] == 'revenue'){
            $movement['end_balance'] = $movement['start_balance'] + $movement['value'];
        }

        if ($request->has('document_file')){
            $document['type'] = $data['document_file']->getClientOriginalExtension();
            $document['original_name'] = $data['document_file']->getClientOriginalName();
            if ($request->has('document_description')){
                $document['description'] = $data['document_description'];
            }
            $document = Document::create($document);
            $movement['document_id'] = $document->id;
        }

        $movement = Movement::create($movement);

        if ($request->has('document_file')) {
            $data['document_file']->storeAs('documents/' . $account->id, $movement->id .'.'.$document['type']);
        }

        return redirect()
            ->route('movements', $account)
            ->with('success', 'Movement added successfully');
    }

    //Movements US.21
    public function edit(Movement $movement)
    {
        $types = MovementCategory::all();
        $account = Account::find($movement->account_id);
        //$movement =  Movement::with('document')->where('id', $movement->document_id)->get();
        //dd($movement);
        return view('movements.edit', compact('types', 'movement', 'account'));
    }

    //Movements US.21
    public function update(UpdateMovementRequest $request, Movement $movement)
    {
        $data = $request->validated();
        $type = MovementCategory::find($data['movement_category_id']);
        $account = Account::find($movement->account_id);

        $movementUpdate['movement_category_id'] = $type['id'];
        $movementUpdate['type'] = $type['type'];
        $movementUpdate['date'] = $data['date'];
        $movementUpdate['value'] = $data['value'];

        if ($request->has('description')){
            $movement['description'] = $data['description'];
        }


        if ($request->has('document_file')){
            $document['type'] = $data['document_file']->getClientOriginalExtension();
            $document['original_name'] = $data['document_file']->getClientOriginalName();
            if ($request->has('document_description')){
                $document['description'] = $data['document_description'];
            }
            $document = Document::create($document);
            $movementUpdate['document_id'] = $document->id;
        }

        $docToDelete = Document::find($movement->document_id);
        Storage::delete('documents/'. $movement->account_id.'/'.$movement->id .'.'.$docToDelete['type']);
        $movement->document()->delete();

        $movement->fill($movementUpdate);

        if ($request->has('document_file')) {
            $data['document_file']->storeAs('documents/' . $movement->account_id, $movement->id .'.'.$document['type']);
        }

        $movement->save();

        return redirect()
            ->route('movements', $account)
            ->with('success', 'Movement updated successfully');
    }

    //Movements US.21
    public function destroy(Movement $movement)
    {
        $account = Account::find($movement->account_id);
        $docToDelete = Document::find($movement->document_id);
        Storage::delete('documents/'. $movement->account_id.'/'.$movement->id .'.'.$docToDelete['type']);
        $movement->delete();
        return redirect()
            ->route('movements', $account)
            ->with('success', 'Movement deleted successfully');
    }
}
