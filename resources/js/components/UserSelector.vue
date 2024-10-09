<template>
  <div class="mb-4">
    <label class="block text-sm font-semibold text-gray-800">Seleccionar Usuarios</label>
    <div class="flex flex-wrap gap-2">
      <!-- Mostrar usuarios seleccionados -->
      <div v-for="(user, index) in selectedUsers" :key="user.id" class="flex items-center">
        <span class="px-2 py-1 bg-gray-200 rounded-md">{{ user.name }}</span>
        <button type="button" @click="removeUser(index)" class="ml-2 text-red-600 hover:text-red-800">
          &times;
        </button>
      </div>
    </div>

    <!-- Campo de búsqueda de usuarios -->
    <div class="mt-2">
      <input v-model="searchQuery" @input="searchUsers" type="text" placeholder="Buscar usuarios..." class="mt-1 block w-full p-2 border border-gray-400 rounded-md focus:ring focus:ring-blue-400 focus:outline-none" />
      <div v-if="filteredUsers.length > 0" class="mt-2 bg-white border border-gray-400 rounded-md shadow-md">
        <ul>
          <li v-for="user in filteredUsers" :key="user.id" @click="selectUser(user)" class="p-2 cursor-pointer hover:bg-gray-100">
            {{ user.name }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue'; // Asegúrate de importar onMounted

export default {
  props: {
    selectedUsers: Array, // Recibe los usuarios seleccionados como prop
  },
  setup(props, { emit }) {
    const searchQuery = ref('');
    const filteredUsers = ref([]);
    const allUsers = ref([]); // Aquí cargarías todos los usuarios desde la API o una fuente de datos

    // Simular usuarios obtenidos de una API
    const mockUsers = [
      { id: 1, name: 'Usuario 1' },
      { id: 2, name: 'Usuario 2' },
      { id: 3, name: 'Usuario 3' },
      // Agrega más usuarios aquí
    ];

    onMounted(() => {
      allUsers.value = mockUsers; // Aquí podrías hacer una llamada a la API para obtener usuarios reales
    });

    // Función para filtrar usuarios según la búsqueda
    const searchUsers = () => {
      filteredUsers.value = allUsers.value.filter(user => 
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) && 
        !props.selectedUsers.some(selected => selected.id === user.id)
      );
    };

    // Selecciona un usuario de la lista filtrada
    const selectUser = (user) => {
      emit('update:selected-users', [...props.selectedUsers, user]);
      searchQuery.value = '';
      filteredUsers.value = [];
    };

    // Elimina un usuario seleccionado
    const removeUser = (index) => {
      const updatedUsers = [...props.selectedUsers];
      updatedUsers.splice(index, 1);
      emit('update:selected-users', updatedUsers);
    };

    watch(searchQuery, searchUsers); // Vuelve a filtrar usuarios cuando cambia la búsqueda

    return {
      searchQuery,
      filteredUsers,
      selectUser,
      removeUser,
    };
  },
};
</script>

<style scoped>
/* Puedes agregar estilos aquí si es necesario */
</style>
