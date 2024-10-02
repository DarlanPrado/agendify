// import { ref, computed } from 'vue'

import type Contact from '../types/contact'
import { defineStore } from 'pinia'

interface State {
    contacts: Contact[]
}

export const useContactsStore = defineStore('contacts', {
    state: ():State => {
        return {
            contacts: []
        }
    },
    actions: {
        defineContacts(contacts: Contact[]) {
            this.contacts = contacts;
        },
        addContact(contact: Contact) {
            this.contacts.push(contact)
        },
        updateContact(contact: Contact) {
            const index = this.contacts.findIndex(c => c.id === contact.id);
            if (index !== -1) {
                this.contacts[index] = contact;
                return contact;
            }
            
            return null; 
        },
        removeContact(contactID: Contact['id']) {
            this.contacts = this.contacts.filter(c => c.id!== contactID);
        },
    },
    getters: {
        getAllContacts: (state) => state.contacts,
        getContactById: (state) => (id: number) => state.contacts.find(c => c.id === id),
        findContact: (state) => (searchValue: string) => {
            return state.contacts.find(c => {
                c.name.toLocaleLowerCase().includes(searchValue.toLocaleLowerCase()) ||
                c.email?.toLocaleLowerCase().includes(searchValue.toLocaleLowerCase()) ||
                c.telephone?.includes(searchValue) ||
                c.address?.toLocaleLowerCase().includes(searchValue.toLocaleLowerCase())
            })
        }
    }
})
