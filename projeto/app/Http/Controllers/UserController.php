<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\UpdatePasswordRequest;
use App\Movement;
use App\MovementCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Khill\Lavacharts\Lavacharts;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    // US.1
    public function index()
    {
        $users = User::count();
        $accounts = Account::count();
        $movements = Movement::count();

        return view('users.index', compact('users', 'movements', 'accounts'));
    }

    //render password
    public function renderPassword()
    {
        return view('users.profiles.passwordUpdate');
    }

    //submissao password (US.9)
    public function password(UpdatePasswordRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = Auth::user();

        $user->fill($data);
        $user->save();
        return redirect()
            ->route('profiles')
            ->with('success', 'User saved successfully');
    }

    //Dashboard US.26
    public function dashboard(User $user)
    {
        
        return view('users.dashboard');
    }
    
    public function revenuesExpenses(User $user, $interval1 = null, $interval2 = null){
        $lava = new Lavacharts();
        
        $catName = "";
        $movements = null;
        $byCategory = [];
        $idKey = [];
        
        
        $categories = MovementCategory::all();
        
        if($interval1 == null && $interval2 == null ){
            
            $movements = Movement::select('type','movement_category_id', 'value', 'account_id')->where('account_id', $user->id)->get();
            $numRevenues = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->get());
            $numExpenses = count(\App\Movement::where('account_id', $user->id)->where('value', '<', 0)->get());
            $allMovements = count(\App\Movement::all());
            
            
        }else if($interval1 == null && $interval2 != null){
        
            $movements = Movement::select('type','movement_category_id', 'value')->where('account_id', $user->id)->where('date', '<=', $interval2)->groupBy('movement_category_id')->sum('value');
            $numRevenues = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->where('date', '<=', $interval2));
            $numExpenses = count(\App\Movement::where('account_id', $user->id)->where('value', '<', 0)->where('date', '<=', $interval2));
            $allMovements = count(\App\Movement::where('account_id', $user->id)->where('date', '<=', $interval2)->get());

        } else if($interval1 != null && $interval2 == null){

            $movements = Movement::select('type', 'movement_category_id', 'value')->where('account_id', $user->id)->where('date', '>=', $interval1)->groupBy('movement_category_id')->sum('value');
            $numRevenues = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->where('date', '>=', $interval1)->get());
            $numExpenses = count(\App\Movement::where('account_id', $user->id)->where('value', '<', 0)->where('date', '>=', $interval1)->get());
            $allMovements = count(\App\Movement::where('account_id', $user->id)->where('date', '>=', $interval1)->get());

        }else{
            
            $movements = Movement::select('type', 'movement_category_id', 'value')->where('account_id', $user->id)->whereBetween('date', [$interval1, $interval2])->groupBy('movement_category_id')->sum('value')->get();
            $numRevenues = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->whereBetween('date', [$interval1, $interval2])->get());
            $numExpenses = count(\App\Movement::where('account_id', $user->id)->where('value', '<', 0)->whereBetween('date', [$interval1, $interval2])->get());
            $allMovements = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->whereBetween('date', [$interval1, $interval2])->get());
        }

        foreach($movements as $mov){
            
            if(array_search($mov->movement_category_id, $idKey) === false){
                array_push($idKey, $mov->movement_category_id);
                
                $byCategory[$mov->movement_category_id] = $mov->value;
            }else{
                $byCategory[$mov->movement_category_id] = $byCategory[$mov->movement_category_id] + $mov->value;
            }    
        }
        
        foreach($categories as $cat){
            if(array_key_exists($cat->id, $byCategory)){
                $byCategory[$cat->name] = $byCategory[$cat->id];
                unset($byCategory[$cat->id]);
            }
        }
        
        //dd($byCategory, $movements, $categories);
        $pieChart =  $lava->DataTable();        
        
        $pieChart->addStringColumn('Type')
        ->addNumberColumn('Percent')
        ->addRow(['Revenue', $numRevenues])
        ->addRow(['Expenses', $numExpenses]);
        
        $lava->PieChart('Percentage_Movements', $pieChart);
        
        $barChart = $lava->DataTable();
        
        
        //movements by category
        /*$barChart->addStringColumn('Type')
        ->addStringColumn('Category')
        ->addNumberColumn('Total Value')
        ->addRows($movements);*/
        
        $lava->BarChart('Movements by Category', $barChart);
        
        
        $lineChart = $lava->DataTable();
        
        $lava->LineChart('Revenue Evolution', $lineChart);
        
        return view('users.dashboard', compact('user', 'pieChart', 'movements', 'Percentage_Movements', 'byCategory'));
    
    /** use on blade view
     *<!-- 
            <div id="stat-div"></div>
                {{!! Lava::render('PieChart','pieChart', 'stat-div')}}
        </div>-->
     **/
    }
}
