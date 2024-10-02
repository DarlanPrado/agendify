<script setup lang="ts">
import axios from 'axios';
import ContactsView from './components/ContactsView.vue';
import { useContactsStore } from './stores/contacts';

import Toast from 'primevue/toast';

axios.get('contacts').then(res => {
  switch(res.status){
    case 200:
      useContactsStore().defineContacts(res.data)
      console.log(res.data);
      break;
    default:
      console.error('Error fetching contacts', res.status);
  }
});

</script>

<template>
  <Toast></Toast>
  <main>
    <ContactsView />
  </main>
</template>
