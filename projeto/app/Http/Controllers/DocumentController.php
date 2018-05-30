<?php

namespace App\Http\Controllers;

use App\Account;
use App\Document;
use App\Http\Requests\StoreDocumentRequest;
use App\Movement;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Documents download US.25
    public function download(Document $document)
    {
        $movement = Movement::find($document->id);
        $account = Account::find($movement->id);
        //Storage::setVisibility('documents/'. $movement->account_id.'/'.$movement->id .'.'.$document->type, 'public');
        //Storage::download('documents/'. $movement->account_id.'/'.$movement->id .'.'.$document->type);
        return response()->download('documents/'. $movement->account_id.'/'.$movement->id .'.'.$document->type);
    }

    //Destroy document US.24
    public function destroy(Document $document)
    {
        $movement = Movement::find($document->id);
        $account = Account::find($movement->id);


        $movementUpdate['document_id'] = null;

        $movement->fill($movementUpdate);
        $movement->save();


        $document->delete();

        return redirect()
            ->route('movements', $account)
            ->with('success', 'Account reopened successfully');
    }

    //Store document US.23
    public function create(Movement $movement)
    {
        $account = Account::find($movement->account_id);
        return view('movements.document.add', compact('movement', 'account'));
    }

    public function store(StoreDocumentRequest $request, Movement $movement)
    {
        $account = Account::find($movement->account_id);
        $data = $request->validated();
        $document['type'] = $data['document_file']->getClientOriginalExtension();
        $document['original_name'] = $data['document_file']->getClientOriginalName();
        if ($request->has('document_description')){
            $document['description'] = $data['document_description'];
        }
        $document = Document::create($document);
        $movementUpdate['document_id'] = $document->id;

        if ($movement->document_id != null){
            $docToDelete = Document::find($movement->document_id);
            Storage::delete('documents/'. $movement->account_id.'/'.$movement->id .'.'.$docToDelete['type']);
            $movement->document()->delete();
        }

        $movement->fill($movementUpdate);

        $data['document_file']->storeAs('documents/' . $movement->account_id, $movement->id .'.'.$document['type']);

        $movement->save();

        return redirect()
            ->route('movements', $account)
            ->with('success', 'Document created successfully');
    }
}
