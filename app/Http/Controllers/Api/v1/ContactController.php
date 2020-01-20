<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\StoreUpdateContactValidate;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    private $contact;
    private $totalPage = 4;
    private $path = 'contacts';
    
    /**
     * DI of \App\Models\Contact
     *
     * @param  \App\Models\Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
    

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response JSON
     */
    public function index(Request $request)
    {
        //Teste de preloader
        sleep(2);
        $contact = $this->contact->getResults($request->all(), $this->totalPage);
        
        return response()->json($contact);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateContactValidate $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateContactValidate $request)
    {
        $data = $request->all();

        // Verifica se informou a imagem para upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Define o nome para a imagem
            $name = kebab_case($request->name);
    
            // Recupera a extensão do arquivo
            $extension = $request->image->extension();
    
            // Define finalmente o nome
            $nameFile = "{$name}.{$extension}";

            $data['image'] = $nameFile;
    
            // Faz o upload:
            $upload = $request->image->storeAs($this->path, $nameFile);
            // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao
    
            // Verifica se NÃO deu certo o upload
            if ( !$upload )
                return response()->json(['error' => 'fail_upload'], 500);
        }

        if ( !$contact = $this->contact->create($data) )
            return response()->json(['error' => 'error_insert'], 500);
        
        return response()->json($contact, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( !$contact = $this->contact->find($id) )
           return response()->json(['error' => 'contact_not_found_1'], 404);
        
        return response()->json($contact);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateContactValidate $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateContactValidate $request, $id)
    {
        $data = $request->all();

        if ( !$contact = $this->contact->find($id) )
           return response()->json(['error' => 'contact_not_found_2'], 404);

        // Verifica se informou a imagem para upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            
            if ($contact->image != null) {
                // !importante: Deleta o arquivo de imagem que já existia
                if (Storage::exists("{$this->path}/{$contact->image}"))
                    Storage::delete("{$this->path}/{$contact->image}");
            }

            // Define o nome para a imagem
            $name = kebab_case($request->name);
        
            // Recupera a extensão do arquivo
            $extension = $request->image->extension();
    
            // Define finalmente o nome
            $contact->image = "{$name}.{$extension}";

            $data['image'] = $contact->image;
    
            // Faz o upload:
            $upload = $request->image->storeAs($this->path, $contact->image);
    
            // Verifica se NÃO deu certo o upload
            if ( !$upload )
                return response()->json(['error' => 'fail_upload'], 500);
        } else {
            unset($data['image']);
        }
        
        if ( !$contact->update($data) )
            return response()->json(['error' => 'contact_not_update_3'], 500);
        
        return response()->json($contact);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( !$contact = $this->contact->find($id) )
           return response()->json(['error' => 'contact_not_found_4'], 404);

        // !importante: Deleta o arquivo de imagem que já existia
        if ($contact->image != null) {
            if (Storage::exists("{$this->path}/{$contact->image}"))
                Storage::delete("{$this->path}/{$contact->image}");
        }
        
        if ( !$contact->delete() )
            return response()->json(['error' => 'contact_not_delete'], 500);
        
        return response()->json($contact, 204);
    }
}