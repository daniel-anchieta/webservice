<?php

namespace App\Soap;
use App\Client;
use Illuminate\Contracts\Support\Arrayable;
use Zend\Config\Config;
use Zend\Config\Writer\Xml;
//use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientsSoapController
{
    /**
     * @return string
     */
    public function listAll()
    {
       // return Client::all();
       return $this->getXML(Client::all());
    }

   /* public function show($id)
    {
        if(!($client = Client::find($id))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }
       // return $client;
       return son_response()->make($client);
    }*/

   /* public function create(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
        $client = Client::create($request->all());
        //return response()->json($client,201);
        return son_response()->make($client,201);
    }*/
    /*public function update(Request $request,$id)
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
    }*/

    protected function getXML($data)
    {
        if($data instanceof Arrayable)
        {
            $data = $data->toArray();
        }
        $config = new Config(['result'=>$data],true);
        $xmlWriter = new Xml();
        return $xmlWriter->toString($config);
    }
}
