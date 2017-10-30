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
        $address = Address::where('client_id',$clientId)->where('id',$id)->get()->first();
       return son_response()->make($address);
    }

    public function store(Request $request, $clientId)
    {
        if(!($client = Client::find($clientId))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }
        $this->validate($request,[
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required'
        ]);
        $address = $client->addresses()->create($request->all());
        //return response()->json($client,201);
        return son_response()->make($address,201);
    }
    public function update(Request $request,$id,$clientId)
    {
        if(!( Client::find($clientId))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }
        if(!(Address::find($id))){
            throw new ModelNotFoundException("Endereco requisitado nao existe");
        }
        $this->validate($request,[
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required'
        ]);
        $address = Address::where('client_id',$clientId)->where('id',$id)->get()->first();
        if(!$address){
            throw new ModelNotFoundException("Endereco requisitado nao existe");
        }
        $address->fill($request->all());
        $address->save();
        return son_response()->make($address,200);
    }

    public function destroy($id, $clientId){
        if(!( Client::find($clientId))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }
        if(!(Address::find($id))){
            throw new ModelNotFoundException("Endereco requisitado nao existe");
        }
        $address = Address::where('client_id',$clientId)->where('id',$id)->get()->first();
        if(!$address){
            throw new ModelNotFoundException("Endereco requisitado nao existe");
        }
        $address->delete();
       return son_response()->make("",204);
    }
}
