<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction" :is-loading="page.loading">
        <Panel>
            <Form id="edit-category" @submit.prevent="onSubmit">
              <TextInput class="mb-4" type="text" :required="true" name="first_name" v-model="form.name" :label="trans('categories.labels.name')"/>
              <TextInput class="mb-4" type="text" :required="true" name="child_type" v-model="form.child_type" :label="trans('categories.labels.child_type')"/>
              <TextInput class="mb-4" type="number" :required="true" name="discount" v-model="form.discount" :label="trans('categories.labels.discount')"/>
              <Dropdown class="mb-4" :enable-search="false" :multiple="false" :server="'available-parents'" :server-per-page="15" :required="false" name="category_id" v-model="form.category" :label="trans('categories.labels.category')"/>
            </Form>
        </Panel>
    </Page>
</template>

<script>
import {defineComponent, onBeforeMount, reactive, ref} from "vue";
import {trans} from "@/helpers/i18n";
import {fillObject, reduceProperties} from "@/helpers/data"
import {useRoute} from "vue-router";
import {useAuthStore} from "@/stores/auth";
import {toUrl} from "@/helpers/routing";
import CategoryService from "@/services/CategoryService";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Dropdown from "@/views/components/input/Dropdown";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";

export default defineComponent({
    components: {
        Form,
        FileInput,
        Panel,
        Alert,
        Dropdown,
        TextInput,
        Button,
        Page
    },
    setup() {
        const {user} = useAuthStore();
        const route = useRoute();
        const form = reactive({
          name: '',
          child_type: '',
          discount: 0,
          category: null,
        });

        const page = reactive({
            id: 'edit_category',
            title: trans('global.pages.categories_edit'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.categories'),
                    to: toUrl('/categories/list'),
                },
                {
                    name: trans('global.pages.categories_edit'),
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
                    name: trans('global.buttons.update'),
                    icon: "fa fa-save",
                    type: 'submit'
                }
            ]
        });

        const service = new CategoryService();

        onBeforeMount(() => {
            service.edit(route.params.id).then((response) => {
                fillObject(form, response.data.model);
                page.loading = false;
            })
        });

        function onAction(data) {
            switch(data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate('edit-category', route.params.id, reduceProperties(form, ['id']));
            return false;
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page
        }
    }
})
</script>

<style scoped>

</style>
