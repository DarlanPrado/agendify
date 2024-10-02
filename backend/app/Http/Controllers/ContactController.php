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
            'email' => 'required|email|unique:contacts,email',
            'address' => 'nullable|string',
            'telephone' => 'nullable|string|unique:contacts,telephone|max:15',
        ]);

        $newContact = Contacts::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
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
        $contact = Contacts::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:contacts,email,' . $id,
            'address' => 'nullable|string',
            'telephone' => 'nullable|string|unique:contacts,telephone,' . $id . '|max:15',
        ]);

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
