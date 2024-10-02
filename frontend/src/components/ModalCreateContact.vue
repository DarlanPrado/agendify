<script setup lang="ts">
import { reactive, watch } from 'vue';

import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';

import type Contact from '@/types/contact';


defineEmits(['createContact'])

const showModal = defineModel<boolean>({required: true});

const state = reactive<Omit<Contact, 'id'>>({
    name: '',
})

watch(showModal, (newValue) => {
    if (newValue) {
        state.name = '';
        state.telephone = '';
        state.email = '';
        state.address = '';
    }
});

</script>
<template>
    <section>
        <Dialog v-model:visible="showModal" modal header="Adicionar contato" :style="{ width: '45rem' }">
            <div style="width: 100%;">
                <form @submit.prevent="(e) => {$emit('createContact', state); showModal = false }" id="form">
                    <div>
                        <label for="name" class="font-semibold w-24" >Nome</label>
                        <InputText id="name" class="flex-auto" autocomplete="off" v-model="state.name" required placeholder="Nome do contato"/>
                    </div>
                    <div>
                        <label for="phone" class="font-semibold w-24">Telefone</label>
                        <InputMask id="phone" mask="(99) 99999-9999" placeholder="(99) 99999-9999" v-model="state.telephone"/>
                    </div>
                    <div>
                        <label for="email" class="font-semibold w-24">Email</label>
                        <InputText id="email" class="flex-auto" type="email" autocomplete="off" v-model="state.email" placeholder="exemplo@email.com"/>
                    </div>
                    <div>
                        <label for="address" class="font-semibold w-24">Endereço</label>
                        <InputText id="address" class="flex-auto" autocomplete="off" v-model="state.address" placeholder="Ex: Rua das Flores, 123 - Bairro Jardim Encantado, Cidade Sol Nascente, SP"/>
                    </div>
                    <div style="flex-direction: row; gap: 0.5rem;">
                        <Button type="button" label="Cancelar" severity="secondary" @click="showModal = false"></Button>
                        <Button type="submit" label="Salvar"></Button>
                    </div>
                </form>
            </div>
        </Dialog>
    </section>
</template>
<style lang="css" scoped>

#form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

#form > div {
    width: 100%;
    display: flex;
    flex-direction: column;
}

#form > div > label {
    margin-bottom: 0.5rem;
}

</style>