<script setup lang="ts">
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputMask from 'primevue/inputmask';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

import { ref } from 'vue';

import type Contact from '@/types/contact';

const editingRows = ref([]);
defineEmits(['editSave','removeItem'])

const data = defineModel<Contact[]>({required: true})
</script>
<template>
    <section>
        <DataTable v-model:editingRows="editingRows" :value="data" tableStyle="min-width: 50rem" editMode="row" dataKey="id" @row-edit-save="e => $emit('editSave', e)">
            <Column field="name" sortable header="Nome">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" required placeholder="Nome do contato"/>
                </template>
            </Column>
            <Column field="email" sortable header="Email">
                <template #editor="{ data, field }">
                    <InputText type="email" v-model="data[field]" placeholder="exemplo@email.com" />
                </template>
            </Column>
            <Column field="address" sortable header="Endereço">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" placeholder="Ex: Rua das Flores, 123 - Bairro Jardim Encantado, Cidade Sol Nascente, SP"/>
                </template>
            </Column>
            <Column field="telephone" sortable header="Telefone">
                <template #editor="{ data, field }">
                    <InputMask v-model="data[field]" mask="(99) 99999-9999" placeholder="(99) 99999-9999"/>
                </template>
            </Column>
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>
            <Column>
                <template #body="{data}">
                    <Button severity="danger" @click="$emit('removeItem', data)" text type="button" icon="pi pi-trash" aria-label="Remover" rounded />
                </template>
            </Column>
        </DataTable>
    </section>
</template>