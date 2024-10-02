<script setup lang="ts">
import { useContactsStore } from '@/stores/contacts';
import ModalCreateContact from './ModalCreateContact.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { ref } from 'vue';
import axios from 'axios';

const showModalCreateContact = ref(false);
const editingRows = ref([]);

const onRowEditSave = (value: any) => {
    if(value.data.id){
        axios.put(`contacts/${value.data.id}`, value.newData).then((res) => {
            switch(res.status){
                case 200:
                    useContactsStore().updateContact(res.data)
                    break;
                default:
                    console.error('Error:', res.status);
                    break;
            }
        });
    }
}

const onRemoveItem = (value: any) => {
    axios.delete(`contacts/${value.id}`).then((res) => {
        switch(res.status){
            case 200:
                useContactsStore().removeContact(value.id)
                break;
            default:
                console.error('Error:', res.status);
                break;
        }
    });
}
</script>

<template>
    <ModalCreateContact v-model="showModalCreateContact" />
    
    <div>
        <Button @click="showModalCreateContact = true" label="Adicionar Contato" />
    </div>
    <DataTable v-model:editingRows="editingRows" :value="useContactsStore().getAllContacts" tableStyle="min-width: 50rem" editMode="row" dataKey="id" @row-edit-save="onRowEditSave">
        <Column field="name" sortable header="Nome">
            <template #editor="{ data, field }">
                <InputText v-model="data[field]" />
            </template>
        </Column>
        <Column field="email" sortable header="Email">
            <template #editor="{ data, field }">
                <InputText v-model="data[field]" />
            </template>
        </Column>
        <Column field="address" sortable header="Endereço">
            <template #editor="{ data, field }">
                <InputText v-model="data[field]" />
            </template>
        </Column>
        <Column field="telephone" sortable header="Telefone">
            <template #editor="{ data, field }">
                <InputText v-model="data[field]" />
            </template>
        </Column>
        <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>
        <Column>
            <template #body="{data}">
                <Button severity="danger" @click="onRemoveItem(data)" text type="button" icon="pi pi-trash" aria-label="Remover" rounded />
            </template>
        </Column>
    </DataTable>

</template>

<!-- id: number;
name: string;
email?: string | undefined;
address?: string | undefined;
telephone?: string | undefined;
created_at?: string | undefined;
updated_at?: string | undefined; -->