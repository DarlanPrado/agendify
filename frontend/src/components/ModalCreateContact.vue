<template>
    <section>
        <Dialog v-model:visible="showModal" modal header="Adicionar contato" :style="{ width: '45rem' }">
            <div class="flex flex-col">
                <form @submit.prevent="submit">
                    <div>
                        <label for="name" class="font-semibold w-24" >Nome</label>
                        <InputText id="name" class="flex-auto" autocomplete="off" v-model="state.name" required/>
                    </div>
                    <div>
                        <label for="phone" class="font-semibold w-24">Telefone</label>
                        <InputText id="phone" class="flex-auto" autocomplete="off" />
                    </div>
                    <div>
                        <label for="email" class="font-semibold w-24">Email</label>
                        <InputText id="email" class="flex-auto" autocomplete="off" />
                    </div>
                    <div>
                        <label for="address" class="font-semibold w-24">Endereço</label>
                        <InputText id="address" class="flex-auto" autocomplete="off" />
                    </div>
                    <div class="flex justify-end gap-2">
                        <Button type="button" label="Cancel" severity="secondary" @click="showModal = false"></Button>
                        <Button type="submit" label="Save"></Button>
                    </div>
                </form>
            </div>
        </Dialog>
    </section>
</template>
<script setup lang="ts">
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { reactive, watch } from 'vue';
import type Contact from '@/types/contact';
import axios from 'axios';
import { useContactsStore } from '@/stores/contacts';

const showModal = defineModel<boolean>({required: true});

const state = reactive<Omit<Contact, 'id'>>({
    name: '',
})

watch(showModal, () => {
    state.name = '';
    state.address = '';
    state.email = '';
    state.telephone = '';
});

const submit = () => {
    console.log("submit form")
    showModal.value = false
    axios.post("contacts", state).then((res) => {
        switch (res.status) {
            case 201:
                useContactsStore().addContact(res.data);
                break;
            default:
                console.error("Error creating contact", res.data);
                break;
        }
    })
}
</script>