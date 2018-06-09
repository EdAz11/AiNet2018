<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MovementCategory;
use App\User;
use App\Movement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class StatisticController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index($interval1 = null, $interval2 = null){        
        $catName = "";
        $movements = null;
        $byCategory = [];
        $idKey = [];
        $month1 = null;
        $month2 = null;
        $user = Auth::user();
        
        //$interval1 = Carbon::parse($request->input('interval1'))->format('m/d/Y');        
        //$interval2 = Carbon::parse($request->input('interval1'))->format('m/d/Y');
        
        $categories = MovementCategory::all();
        
        if(!isset($interval1) && !isset($interval2) ){
            
            $movements = Movement::select('type','movement_category_id', 'value', 'account_id')->where('account_id', $user->id)->get();
            $numRevenues = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->get());
            $numExpenses = count(\App\Movement::where('account_id', $user->id)->where('value', '<', 0)->get());
            $allMovements = count(\App\Movement::all());
            
            
        }else if(!isset($interval1) && isset($interval2)){
        
            $movements = Movement::select('type','movement_category_id', 'value', 'account_id')->where('account_id', $user->id)->whereBetween('date', array(Carbon::minvalue(), $interval2))->get();
            $numRevenues = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->whereBetween('date', array(Carbon::minvalue(), $interval2)));
            $numExpenses = count(\App\Movement::where('account_id', $user->id)->where('value', '<', 0)->whereBetween('date', array(Carbon::minvalue(), $interval2)));
            $allMovements = count(\App\Movement::where('account_id', $user->id)->whereBetween('date', array(Carbon::minvalue(), $interval2))->get());

        } else if(isset($interval1) && !isset($interval2)){

            $movements = Movement::select('type','movement_category_id', 'value', 'account_id')->where('account_id', $user->id)->whereBetween('date', array($interval1, Carbon::maxValue()))->get();
            $numRevenues = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->whereBetween('date', array($interval1, Carbon::maxValue()))->get());
            $numExpenses = count(\App\Movement::where('account_id', $user->id)->where('value', '<', 0)->whereBetween('date', array($interval1, Carbon::maxValue()))->get());
            $allMovements = count(\App\Movement::where('account_id', $user->id)->whereBetween('date', array($interval1, Carbon::maxValue()))->get());

        }else{
            
            $movements = Movement::select('type','movement_category_id', 'value', 'account_id')->where('account_id', $user->id)->whereBetween('date', array($interval1, $interval2))->get();
            $numRevenues = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->whereBetween('date', array($interval1, $interval2))->get());
            $numExpenses = count(\App\Movement::where('account_id', $user->id)->where('value', '<', 0)->whereBetween('date', array($interval1, $interval2))->get());
            $allMovements = count(\App\Movement::where('account_id', $user->id)->where('value', '>', 0)->whereBetween('date', array($interval1, $interval2))->get());
        }

        $monthlyData = $this->monthlyBalances($user, $interval1, $interval2, $categories);
        
        foreach($movements as $mov){
            
            if(array_search($mov->movement_category_id, $idKey) === false){
                array_push($idKey, strval($mov->movement_category_id));
                
                $byCategory[$mov->movement_category_id] = $mov->value;
            }else{
                $byCategory[$mov->movement_category_id] = $byCategory[$mov->movement_category_id] + $mov->value;
            }    
        }
        
        foreach($categories as $cat){
            if(array_key_exists($cat->id, $byCategory)){
                $byCategory[$cat->name] = $byCategory[$cat->id];
                array_push($idKey, $cat->name);
                array_splice($idKey, array_search($cat->id, $idKey), 1);
                unset($byCategory[$cat->id]);
            }
        }
        
        $sendCat = json_encode($byCategory, JSON_NUMERIC_CHECK);
        
        return view('statistics.index', compact('user', 'movements', 'byCategory', 'idKey', 'sendCat', 'monthlyData'));
    }
    
    public function monthlyBalances(User $user, $interval1, $interval2, $categories){
        $months = [];
        $idKey = [];
        $countBalances = [];
        
        if(!isset($interval1) && !isset($interval2) ){
            
            $movements = Movement::select('type','movement_category_id', 'value', 'account_id')->where('account_id', $user->id)->get();
            
        }else if(!isset($interval1) && isset($interval2)){
            
            $month2 = explode('/', $interval2);
            $month2 = Carbon::CreateFromDate($month2[2], $month2[1], 1);
            
            $movements = Movement::select('type','movement_category_id', 'value')->where('account_id', $user->id)->whereBetween('date', array(Carbon::minvalue(), $interval2))->get();

        } else if(isset($interval1) && !isset($interval2)){
            
            $month1 = explode('/', $interval1);
            $month1 = Carbon::CreateFromDate($month1[2], $month1[1], 1);
            
            $movements = Movement::select('type', 'movement_category_id', 'value')->where('account_id', $user->id)->whereBetween('date', array($interval1, Carbon::maxValue()))->get();

        }else{
            
            $month1 = explode('/', $interval1);
            $month1 = Carbon::CreateFromDate($month1[2], $month1[1], 1);
            $month2 = explode('/', $interval2);
            $month2 = Carbon::CreateFromDate($month2[2], $month2[1], 1);
            
            $movements = Movement::select('type', 'movement_category_id', 'value')->where('account_id', $user->id)->whereBetween('date', array($interval1, $interval2))->orderBy('movement_category_id')->get();
        }
        
        foreach($movements as $mov){
            
            if(array_search($mov->movement_category_id, $idKey) === false){
                array_push($idKey, strval($mov->movement_category_id));
                
                $months[$mov->movement_category_id] = $mov->value;
            }else{
                $months[$mov->movement_category_id] = $months[$mov->movement_category_id] + $mov->value;
            }    
        }
        
        foreach($categories as $cat){
            if(array_key_exists($cat->id, $months)){
                $months[$cat->name] = $months[$cat->id];
                array_push($idKey, $cat->name);
                array_splice($idKey, array_search($cat->id, $idKey), 1);
                unset($months[$cat->id]);
            }
        }
        
        return $months;
    }
}
