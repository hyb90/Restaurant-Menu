<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel>
            <Form id="create-item" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name" :label="trans('items.labels.name')"/>
                <TextInput class="mb-4" type="number" :required="true" name="price" v-model="form.price" :label="trans('items.labels.price')"/>
                <TextInput class="mb-4" type="number" :required="true" name="discount" v-model="form.discount" :label="trans('items.labels.discount')"/>
              <Dropdown class="mb-4" :enable-search="false" :multiple="false" :server="'available-categories'" :server-per-page="15" :required="true" name="category_id" v-model="form.category" :label="trans('items.labels.category')"/>
            </Form>
        </Panel>
    </Page>
</template>

<script>
import {defineComponent, onMounted, reactive} from "vue";
import {trans} from "@/helpers/i18n";
import {useAuthStore} from "@/stores/auth";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Dropdown from "@/views/components/input/Dropdown";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import UserService from "@/services/UserService";
import {clearObject, reduceProperties} from "@/helpers/data";
import {toUrl} from "@/helpers/routing";
import Form from "@/views/components/Form";
import ItemService from "@/services/ItemService";
import CategoryService from "@/services/CategoryService";

export default defineComponent({
    components: {Form, FileInput, Panel, Alert, Dropdown, TextInput, Button, Page},
    setup() {
        const {user} = useAuthStore();
        const form = reactive({
            name: '',
            price: 0 ,
            discount: 0 ,
            category: null,
        });

        const page = reactive({
            id: 'create_items',
            title: trans('global.pages.items_create'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.items'),
                    to: toUrl('/items/list'),

                },
                {
                    name: trans('global.pages.items_create'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/items/list'),
                    theme: 'outline',
                },
                {
                    id: 'submit',
                    name: trans('global.buttons.save'),
                    icon: "fa fa-save",
                    type: 'submit',
                }
            ]
        });

        const service = new ItemService();

        function onAction(data) {
            switch(data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-item', {
              name: form.name,
              price: form.price ,
              category_id: form.category!=null?form.category.id:null,
            }).then(() => {
                clearObject(form)
            })
            return false;
        }

        return {
            trans,
            user,
            form,
            page,
            onSubmit,
            onAction,
        }
    }
})
</script>

<style scoped>

</style>
