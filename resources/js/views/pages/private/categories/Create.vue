<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel>
            <Form id="create-user" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="first_name" v-model="form.name" :label="trans('categories.labels.name')"/>
                <TextInput class="mb-4" type="text" :required="true" name="child_type" v-model="form.child_type" :label="trans('categories.labels.child_type')"/>
                <TextInput class="mb-4" type="number" :required="true" name="discount" v-model="form.discount" :label="trans('categories.labels.discount')"/>
              <Dropdown class="mb-4" :enable-search="false" :multiple="false" :server="'available-parents'" :server-per-page="15" :required="false" name="category_id" v-model="form.category" :label="trans('categories.labels.parent')"/>
            </Form>
        </Panel>
    </Page>
</template>

<script>
import {defineComponent, reactive} from "vue";
import {trans} from "@/helpers/i18n";
import {useAuthStore} from "@/stores/auth";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Dropdown from "@/views/components/input/Dropdown";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import CategoryService from "@/services/CategoryService";
import {clearObject} from "@/helpers/data";
import {toUrl} from "@/helpers/routing";
import Form from "@/views/components/Form";

export default defineComponent({
    components: {Form, FileInput, Panel, Alert, Dropdown, TextInput, Button, Page},
    setup() {
        const {user} = useAuthStore();
        const form = reactive({
            name: '',
            child_type: '',
            discount: 0,
            category: null,
        });

        const page = reactive({
            id: 'create_categories',
            title: trans('global.pages.categories_create'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.categories'),
                    to: toUrl('/categories/list'),

                },
                {
                    name: trans('global.pages.categories_create'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/categories/list'),
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

        const service = new CategoryService();

        function onAction(data) {
            switch(data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-category', {
              name: form.name,
              child_type:form.child_type,
              discount: form.discount ,
              parent_id: form.category==null?null:form.category.id,
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
