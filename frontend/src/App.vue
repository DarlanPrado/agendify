<script setup lang="ts">
import axios from 'axios';
import ContactsView from './components/ContactsView.vue';
import { useContactsStore } from './stores/contacts';

import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';


(async() => {
  axios.get('contacts').then(res => {
    switch(res.status){
      case 200:
        useContactsStore().defineContacts(res.data)
        break;
      default:
        console.error('Error fetching contacts', res.status);
    }
  });
})();
</script>
<template>
  <ConfirmDialog></ConfirmDialog>
  <Toast></Toast>
  <main>
    <ContactsView />
  </main>
</template>
