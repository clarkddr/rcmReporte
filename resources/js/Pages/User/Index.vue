<script setup>
import { ref, watch, nextTick } from 'vue';
import { Head, Link, useForm, router} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/FlowbiteLayout.vue';
import Modal from '@/Components/Modal.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TableFooter from '@/Components/TableFooter.vue';
import { initFlowbite } from 'flowbite';
import debounce from 'lodash/debounce';

const props = defineProps({
    users: {type: Object },
    filter: {type: Object }
});

const showModalState = ref(false);
const showUserInfo = ref({});
const showShowModal = (user) => {
     showModalState.value = true;
     showUserInfo.value.id = user.id;
     showUserInfo.value.name = user.name;
     showUserInfo.value.username = user.username;
     showUserInfo.value.email = user.email;
     showUserInfo.value.type = user.type;
     showUserInfo.value.created_at = user.created_at;
     showUserInfo.value.updated_at = user.updated_at;
    };
const hideShowModal = () => { showModalState.value = false};

const addModalState = ref(false);
const showAddModal = () => { addModalState.value = true;}
const hideAddModal = () => { addModalState.value = false; form.reset();}
const form = useForm({
    name: '',
    username: '',
    email: '',
    type: '',
});
const submit = () => {
    changeAddButton();
    form.post(route('user.store'), {
        onSuccess: () => {            
            form.reset('name', 'username','type','email');
            hideAddModal();
            nextTick(() => {
                initFlowbite();
            });
            addSubmitButton.value.status = false;
            addSubmitButton.value.text = 'Guardar Usuario';
        },
        onError: () => {
            addSubmitButton.value.status = false;
            addSubmitButton.value.text = 'Guardar Usuario';
        }
    })
};


const updateForm = useForm({
        id:'',
        name: '',
        username: '',
        email: '',
        type: '',
        updated_at: '',
    });
const updateModalState = ref(false);
const showUpdateModal = (user) => {
     updateModalState.value = true;
     updateForm.id = user.id;
     updateForm.name = user.name;
     updateForm.username = user.username;
     updateForm.email = user.email;
     updateForm.type = user.type;
     updateForm.updated_at = user.updated_at;   
    }
const hideUpdateModal = () => { 
    updateModalState.value = false;
    updateForm.errors = {};
}

const submitUpdate = () => {
    changeEditButton();
    updateForm.post(route('user.update'), {
        onSuccess: (page) => {            
            showUserInfo.value.id = page.props.jetstream.flash.user.id;
            showUserInfo.value.name = page.props.jetstream.flash.user.name;
            showUserInfo.value.username = page.props.jetstream.flash.user.username;
            showUserInfo.value.email = page.props.jetstream.flash.user.email;
            showUserInfo.value.type = page.props.jetstream.flash.user.type;
            showUserInfo.value.updated_at = page.props.jetstream.flash.user.updated_at;
            updateForm.reset('name', 'username','type','email');
            hideUpdateModal();            
            nextTick(() => {
                initFlowbite();
            });
            editSubmitButton.value.status = false;
            editSubmitButton.value.text = 'Actualizar';
        },
        onError: () => {
            editSubmitButton.value.status = false;
            editSubmitButton.value.text = 'Actualizar';            
        }
    })
};

const deleteModalState = ref(false);
const userToDelete = ref({});
const showDeleteModal = (user) => {
    deleteModalState.value = true;
    userToDelete.value = user;
}
const hideDeleteModal = () => {
    deleteModalState.value = false;
    deleteButton.value.status = false;
    deleteButton.value.text = 'Eliminar';
}
    
const searchInput = ref(null);
const search = ref(props.filter.search);
watch(search, debounce( value => {    
    router.get('/users', {search:value},{ preserveState: true, replace: true});
    
},300));
const cleanFilter = () => {
    if(search.value != ''){
        search.value = '';
    }
    changeFocusToSearch();
}
const changeFocusToSearch = () => {
    searchInput.value.focus();
}

const addSubmitButton = ref({
    status: false,
    text: 'Guardar Usuario'
});
const changeAddButton = () => {
    addSubmitButton.value.status = true;
    addSubmitButton.value.text = 'Guardando...';
};

const editSubmitButton = ref({
    status: false,
    text: 'Actualizar Usuario'
});
const changeEditButton = () => {
    editSubmitButton.value.status = true;
    editSubmitButton.value.text = 'Actualizando...';
};

const deleteButton = ref({
    status: false,
    text: 'Eliminar'
});
const changeDeleteButton = () => {
    deleteButton.value.status = true;
    deleteButton.value.text = 'Eliminando...';
}



</script>

<template>
    <AppLayout title="FlowbiteLayout">       
        <section>
            <div class="flex space-x-4 justify-between">
                <h1 class="text-white text-4xl my-4">Usuarios</h1>                    
            </div>                                
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center" >
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <TextInput autofocus v-model="search" ref="searchInput" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Buscar por nombre, usuario o correo" />
                            </div>
                            <button @click="cleanFilter" type="button" class="mx-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-xs p-1.5 text-center inline-flex items-center me-1 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="p-0 m-0 w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>                                    <span class="sr-only">Icon description</span>
                            </button>                                
                        </div>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button @click="showAddModal" type="button" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="mr-1 w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
                            </svg>        
                            Agregar
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Usuario</th>
                                <th scope="col" class="px-4 py-3">Correo</th>
                                <th scope="col" class="px-4 py-3">Tipo</th>
                                <th scope="col" class="px-4 py-3">Iglesia</th>                                    
                                <th scope="col" class="px-4 py-3">Creado</th>                                    
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr v-for="(user, index) in users.data" :key="user.id" class="border-b dark:border-gray-700">
                                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{user.name}}</th>
                                <td class="px-4 py-3">{{ user.username }}</td>
                                <td class="px-4 py-3">{{ user.email }}</td>
                                <td class="px-4 py-3">{{user.type}}</td>
                                <td class="px-4 py-3">{{ user.church.name }}</td>                                    
                                <td class="px-4 py-3">{{ user.created_at_human }}</td>                                    
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button @click="showShowModal(user)" :key="user.id" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-blue-700 dark:hover:text-gray-800" type="button">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white dark:hover:text-blue-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </button>
                                    <button @click="showUpdateModal(user)" :key="user.id" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 dark:hover:text-gray-900 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white dark:hover:text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
                                        </svg>
                                    </button>
                                    <button @click="showDeleteModal(user)" :key="user.id" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 dark:hover:text-gray-900 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white dark:hover:text-red-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>                                
                        </tbody>
                    </table>
                </div>
                
                <TableFooter :data="users"/>
            </div>
        </section>
        <!-- Read Modal -->
        <Modal :show="showModalState" @close="hideShowModal">            
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <!-- Modal header -->
                    <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                        <div class="text-lg text-gray-900 md:text-xl dark:text-white">                            
                            <h2 class="font-semibold ">
                                {{ showUserInfo.name }}
                            </h2>
                        </div>
                        <div>
                            <button @click="hideShowModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                    </div>
                    <dl>
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Usuario</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ showUserInfo.username }}</dd>
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Correo</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ showUserInfo.email }}</dd>
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Tipo de Usuario</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ showUserInfo.type }}</dd>
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Fecha de Creación</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ showUserInfo.created_at }}</dd>
                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Ultima Actualización</dt>
                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ showUserInfo.updated_at }}</dd>
                    </dl>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3 sm:space-x-4">
                            <button @click="showUpdateModal(showUserInfo)" type="button" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                <svg aria-hidden="true" class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                Editar
                            </button>               
                            <button @click="showDeleteModal(showUserInfo)" type="button" class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                <svg aria-hidden="true" class="w-5 h-5 mr-1.5 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                Eliminar
                            </button>
                        </div>  
                       
                    </div>
            </div>
        </Modal>
        
        <!-- Add modal -->
        <Modal :show="addModalState" @close="hideAddModal">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Agregar Usuario
                    </h3>
                    <button @click="hideAddModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form @submit.prevent="submit">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <InputLabel for="name" value="Nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"/>
                            <TextInput id="name" v-model="form.name" type="text" required placeholder="Nombre y Apellido" autocomplete="new-name"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
                            <InputError class="mt-2" :message="form.errors.name" />                            
                            <!-- <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required=""> -->
                        </div>
                        <div>
                            <InputLabel for="Nombre de Usuario" value="Nombre de usuario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"/>
                            <TextInput name="Nombre de Usuario" id="username" v-model="form.username" type="text" required placeholder="Nombre de usuario" autocomplete="new-username"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
                            <InputError class="mt-2" :message="form.errors.username" />
                        </div>
                        <div>
                            <InputLabel for="email" value="Correo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"/>
                            <TextInput id="email" v-model="form.email" type="email" placeholder="Correo electrónico" autocomplete="new-email"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div>
                            <label for="Tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                            <select name="Tipo" v-model="form.type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <optgroup label="Seleccionar Tipo">
                                    <option value="admin">Administrador</option>
                                    <option value="user">Usuario</option>
                                    <option value="member">Miembro</option>
                                </optgroup>
                            </select>
                            <InputError class="mt-2" :message="form.errors.type" />
                        </div>
                    </div>
                    <button :disabled="addSubmitButton.status" @click="submit()" type="submit" :class="{'cursor-not-allowed opacity-50':addSubmitButton.status}" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <svg v-show="!addSubmitButton.status" class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        <svg v-if="addSubmitButton.status" aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                        </svg>
                        {{ addSubmitButton.text }}
                    </button>
                </form>
            </div>            
        </Modal>
        <!-- Edit Modal -->
        <Modal :show="updateModalState" @close="hideUpdateModal">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Editar Usuario
                    </h3>
                    <button @click="hideUpdateModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form @submit.prevent="submitUpdate">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <InputLabel for="name" value="Nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"/>
                            <TextInput id="name" v-model="updateForm.name" type="text" required placeholder="Nombre y Apellido" autocomplete="new-name"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
                            <InputError class="mt-2" :message="updateForm.errors.name" />                            
                            <!-- <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required=""> -->
                        </div>
                        <div>
                            <InputLabel for="Nombre de Usuario" value="Nombre de usuario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"/>
                            <TextInput name="Nombre de Usuario" id="username" v-model="updateForm.username" type="text" required placeholder="Nombre de usuario" autocomplete="new-username"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
                            <InputError class="mt-2" :message="updateForm.errors.username" />                            
                        </div>
                        <div>
                            <InputLabel for="email" value="Correo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"/>
                            <TextInput id="email" v-model="updateForm.email" type="email" placeholder="Correo electrónico" autocomplete="new-email"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
                            <InputError class="mt-2" :message="updateForm.errors.email" />
                        </div>
                        <div>
                            <label for="Tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                            <select name="Tipo" v-model="updateForm.type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <optgroup label="Seleccionar Tipo">
                                    <option value="admin">Administrador</option>
                                    <option value="user">Usuario</option>
                                    <option value="member">Miembro</option>
                                </optgroup>
                            </select>
                            <InputError class="mt-2" :message="updateForm.errors.type" />
                        </div>
                    </div>
                        
                        <button :disabled="updateForm.processing" type="submit" :class="{'cursor-not-allowed opacity-50':editSubmitButton.status}"class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <svg v-if="!editSubmitButton.status" class="mx-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            <svg v-if="editSubmitButton.status" aria-hidden="true" role="status" class="inline w-6 h-6 mx-1 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            {{ editSubmitButton.text }}
                        </button>                    
                </form>
            </div>           
        </Modal>
        <!-- Delete Modal -->
        <DialogModal :show="deleteModalState" @close="hideDeleteModal">
            <template #title>
                <h3>Esta seguro de eliminar?</h3>
            </template>
            <template #content>
                El usuario <span class="font-bold">{{ userToDelete.name }}</span>  será borrado.
            </template>
            <template #footer>
                <SecondaryButton class="mx-1" @click="hideDeleteModal">Cancelar</SecondaryButton>
                <Link :disabled="deleteButton" @click="changeDeleteButton" :href="'/users/'+ userToDelete.id +'/delete'" :type="'button'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-1 mx-1 rounded inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg v-if="!deleteButton.status" aria-hidden="true" class="w-6 h-6 mx-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <svg v-if="deleteButton.status" aria-hidden="true" role="status" class="inline w-6 h-6 mx-1 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg>
                    {{deleteButton.text}}
                </Link>

            </template>
        </DialogModal>
    </AppLayout>
</template>