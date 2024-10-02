<script setup lang="ts">
import ModalCreateContact from './ModalCreateContact.vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Card from 'primevue/card';

import { useContactsStore } from '@/stores/contacts';
import { ref, computed } from 'vue';
import axios from 'axios';
import TableContacts from './TableContacts.vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";

const showModalCreateContact = ref(false);
const searchValue = ref('');
const toast = useToast();
const confirm = useConfirm();

const onRowEditSave = (value: any) => {
    if(value.data.id){
        axios.put(`contacts/${value.data.id}`, value.newData).then((res) => {
            switch(res.status){
                case 200:
                    toast.add({
                        severity: 'success',
                        summary: 'Atualizado',
                        detail: 'o item foi alterado com sucesso',
                        life: 5000,
                    })
            
                    useContactsStore().updateContact(res.data)
                    break;
                default:
                    toast.add({
                        severity: 'warn',
                        summary: 'Ocorreu um retorno inesperado',
                        detail: 'Entre em contato com o suporte',
                        life: 5000,                
                    })
                    break;
            }
        }).catch((err) => {
            switch(err.status){
                case 409:
                    if(err.response?.data?.email_exists){
                        toast.add({
                            severity: 'warn',
                            summary: 'Falha',
                            detail: 'Já existe um contato com este email',
                            life: 5000,                
                        })
                    }
                    if(err.response?.data?.telephone_exists){
                        toast.add({
                            severity: 'warn',
                            summary: 'Falha',
                            detail: 'Já existe um contato com este telefone',
                            life: 5000,                
                        })
                    }
                    break;
                case 422:
                    toast.add({
                        severity: 'warn',
                        summary: 'Falha',
                        detail: 'Preencha os campos corretamente',
                        life: 5000,                
                    })
                    break;
                default: 
                    toast.add({
                        severity: 'error',
                        summary: 'Ocorreu um erro inesperado',
                        detail: 'Tente novamente mais tarde',
                        life: 5000,                
                    })
                    break;
            }
        });
    }
}

const onRemoveItem = (value: any) => {
    axios.delete(`contacts/${value.id}`).then((res) => {
        switch(res.status){
            case 200:
                toast.add({
                    severity: 'success',
                    summary: 'Removido',
                    detail: 'o item foi removido com sucesso',
                    life: 5000,
                })
                useContactsStore().removeContact(value.id)
                break;
            default:
                toast.add({
                    severity: 'error',
                    summary: 'Ocorreu um erro inesperado',
                    detail: 'Tente novamente mais tarde',
                    life: 5000,          
                })
                console.error('Error:', res.status);
                break;
        }
    }).catch((err) => {
        switch(err.status){
            default: 
                toast.add({
                    severity: 'error',
                    summary: 'Ocorreu um erro inesperado',
                    detail: 'Tente novamente mais tarde',
                    life: 5000,                
                })
                break;
        }
    });
}

const onCreateContact = (value: any) => {
    axios.post("contacts", value).then((res) => {
        switch (res.status) {
            case 201:
                toast.add({
                    severity: 'success',
                    summary: 'Adicionado',
                    detail: 'o item foi adicionado com sucesso',
                    life: 5000,
                })
                useContactsStore().addContact(res.data);
                break;
            default:
                toast.add({
                    severity: 'error',
                    summary: 'Ocorreu um erro inesperado',
                    detail: 'Tente novamente mais tarde',        
                    life: 5000,           
                })
                console.error("Error creating contact", res.data);
                break;
        }
    }).catch((err) => {
        switch(err.status){
            case 409:
                if(err.response?.data?.email_exists){
                    toast.add({
                        severity: 'warn',
                        summary: 'Falha',
                        detail: 'Já existe um contato com este email',
                        life: 5000,                
                    })
                }
                if(err.response?.data?.telephone_exists){
                    toast.add({
                        severity: 'warn',
                        summary: 'Falha',
                        detail: 'Já existe um contato com este telefone',
                        life: 5000,                
                    })
                }
                break;
            case 422:
                toast.add({
                    severity: 'warn',
                    summary: 'Falha',
                    detail: 'Preencha os campos corretamente',
                    life: 5000,                
                })
                break;
            default: 
                toast.add({
                    severity: 'error',
                    summary: 'Ocorreu um erro inesperado',
                    detail: 'Tente novamente mais tarde',
                    life: 5000,                
                })
                break;
        }
    });
}

const filteredRows = computed(() => {
    if (!searchValue.value) {
        return useContactsStore().getAllContacts
    }

    return useContactsStore().getAllContacts.filter((person) => {
        return Object.values(person).some((value) => {
            return String(value).toLowerCase().includes(searchValue.value.toLowerCase())
        })
    })
})
</script>
<template>
    <section>
        <ModalCreateContact v-model="showModalCreateContact" @create-contact="onCreateContact" />
        <Card>
            <template #title>
                <div>
                    <h6 style="margin-bottom: 1rem; font-size: 2rem; font-weight: bold;">Contatos</h6>
                </div>
                <div>
                    <div style="display: flex; gap: 1rem;">
                        <div style="width: 100%">
                            <InputText style="width: 100%" v-model="searchValue" placeholder="Pesquisar..." />
                        </div>
                        <div>
                            <Button @click="showModalCreateContact = true" label="Adicionar" />
                        </div>
                    </div>
                </div>
            </template>
            <template #content>
                <TableContacts v-if="filteredRows.length" v-model="filteredRows" @edit-save="onRowEditSave" @remove-item="data => {
                    confirm.require({
                        accept: () => onRemoveItem(data),
                        header: 'Excluir contato',
                        icon: 'pi pi-exclamation-circle',
                        acceptLabel: 'Excluir',
                        rejectLabel: 'Cancelar',
                        message: 'Tem certeza que deseja excluir permanentemente este contato?',
                    })
                }" />
                <div style="display: flex; justify-content: center; align-items: center; height: 10rem;" v-show="!filteredRows.length">
                    <span style="font-weight: bold; font-size: 1rem;">Nenhum item encontrado</span>
                </div>
            </template>
        </Card>
    </section>
</template>