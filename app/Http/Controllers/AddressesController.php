<?php

namespace App\Http\Controllers;
use App\Address;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressesController extends Controller
{
    public function index($clientId)
    {
       if(!($client = Client::find($clientId))){
           throw new ModelNotFoundException("Client requisitado nao existe");
       }
       return son_response()->make(Address::where('client_id',$clientId)->get());
    }

    public function show($id, $clientId)
    {
        if(!(Client::find($clientId))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }
        if(!(Address::find($id))){
            throw new ModelNotFoundException("Endereco requisitado não existe");
        }
        $result = Address::where('client_id',$clientId)->where('id',$id)->get()->first();
       return son_response()->make($result);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
        $client = Client::create($request->all());
        //return response()->json($client,201);
        return son_response()->make($client,201);
    }
    public function update(Request $request,$id)
    {
        if(!($client = Client::find($id))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }

        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required'
        ]);
        $client->fill($request->all());
        $client->save();
        //return response()->json($client,200);
        return son_response()->make($client,200);
    }

    public function destroy($id){
        if(!($client = Client::find($id))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }
        $client->delete();
       // return response()->json("",204);
       return son_response()->make("",204);
    }
}
