<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'telefone', 'site', 'image'];

    

    /**
     * Filter Contacts
     *
     * @param  Array $data filtros
     * @param  int $totalPage itens por página
     *
     * @return \Illuminate\Http\Response
     */
    public function getResults(Array $data, int $totalPage)
    {
        // Se não existir filtro retorna todos os resultados, paginados
    	if (!isset($data['name']) && !isset($data['email']) && !isset($data['telefone']) && !isset($data['site']) && !isset($data['filter']))
    		return $this->orderBy('id', 'DESC')->paginate($totalPage);

        // Traz os resultados filtrados
    	return $this->where(function ($query) use ($data) {
    				if (isset($data['name'])) {
    					$name = $data['name'];
    					$query->where('name', 'LIKE', "%{$name}%");
                    }
                    
                    if (isset($data['email'])) {
    					$email = $data['email'];
    					$query->where('email', 'LIKE', "%{$email}%");
                    }
                    
                    if (isset($data['telefone'])) {
    					$telefone = $data['telefone'];
    					$query->where('telefone', 'LIKE', "%{$telefone}%");
                    }
                    
                    if (isset($data['site'])) {
    					$site = $data['site'];
    					$query->where('site', 'LIKE', "%{$site}%");
    				}

    				if (isset($data['filter'])) {
                        $filter = $data['filter'];

                        $query->where('name', 'LIKE', "%{$filter}%")
                                ->orWhere('telefone', 'LIKE', "%{$filter}%");
                    }

                })
                ->orderBy('id', 'DESC')
                ->paginate($totalPage);// ->toSql();
    }
}
