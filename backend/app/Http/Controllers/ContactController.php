<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacts;

class ContactController extends Controller
{
    // Método para listar todos os contatos
    public function index() {
        $contacts = Contacts::all();
        return response()->json($contacts);
    }

    // Método para criar um novo contato
    public function create(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'sometimes|nullable|email',
            'address' => 'sometimes|nullable|string',
            'telephone' => 'sometimes|nullable|string|max:15',
        ]);

        $existingEmail = !empty($validatedData['email']) && Contacts::where('email', $validatedData['email'])->exists();
        $existingTelephone = !empty($validatedData['telephone']) && Contacts::where('telephone', $validatedData['telephone'])->exists();

        if ($existingEmail || $existingTelephone) {
            return response()->json([
                'message' => 'E-mail or telephone already in use.',
                'email_exists' => $existingEmail,
                'telephone_exists' => $existingTelephone
            ], 409);
        }


        $newContact = Contacts::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'telephone' => $validatedData['telephone'] ?? null,
        ]);

        return response()->json($newContact, 201);
    }

    // Método para buscar um contato por ID
    public function getById($id) {
        $contact = Contacts::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        return response()->json($contact);
    }

    // Método para atualizar um contato existente
    public function update(Request $request, $id) {
        // Busca o contato pelo ID
        $contact = Contacts::find($id);
    
        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }
    
        // Validação básica dos dados
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'sometimes|nullable|email',
            'address' => 'sometimes|nullable|string',
            'telephone' => 'sometimes|nullable|string|max:15',
        ]);
    
        // Verifica se o e-mail já existe em outro contato
        $existingEmail = !empty($validatedData['email']) && Contacts::where('email', $validatedData['email'])->where('id', '!=', $id)->exists();
    
        // Verifica se o telefone já existe em outro contato
        $existingTelephone = !empty($validatedData['telephone']) && Contacts::where('telephone', $validatedData['telephone'])->where('id', '!=', $id)->exists();
    
        // Retorna 409 se o e-mail ou telefone já estiver em uso por outro contato
        if ($existingEmail || $existingTelephone) {
            return response()->json([
                'message' => 'E-mail or telephone already in use by another contact.',
                'email_exists' => $existingEmail,
                'telephone_exists' => $existingTelephone
            ], 409);
        }
    
        // Atualiza os dados do contato
        $contact->update([
            'name' => $validatedData['name'] ?? $contact->name,
            'email' => $validatedData['email'] ?? $contact->email,
            'address' => $validatedData['address'] ?? $contact->address,
            'telephone' => $validatedData['telephone'] ?? $contact->telephone,
        ]);
    
        return response()->json($contact);
    }
    

    // Método para deletar um contato por ID
    public function delete($id) {
        $contact = Contacts::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully']);
    }
}
