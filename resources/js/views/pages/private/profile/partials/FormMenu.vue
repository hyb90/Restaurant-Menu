<template>
    <Panel :title="trans('menu.labels.general_settings')">
        <form @submit.prevent="onFormSubmit">
            <TextInput type="text"  :label="trans('menu.labels.menu_name')" name="menu_name" v-model="form.name" class="mb-2"/>
            <TextInput type="text" :label="trans('menu.labels.menu_discount')" name="menu_discount" v-model="form.discount" class="mb-2"/>
            <TextInput type="text" :disabled="true" :label="trans('menu.labels.original_price')" name="original_price" v-model="form.original_price" class="mb-2"/>
            <TextInput type="text" :disabled="true" :label="trans('menu.labels.discount_price')" name="discount_price" v-model="form.discount_price" class="mb-2"/>
            <Button  type="submit" :label="trans('global.buttons.update')"/>
        </form>
    </Panel>
</template>

<script>
import AuthService from "@/services/AuthService";
import {trans} from "@/helpers/i18n";
import {defineComponent, reactive, onMounted, watch} from "vue";
import {getResponseError} from "@/helpers/api";
import {useAuthStore} from "@/stores/auth";
import {useAlertStore} from "@/stores";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Panel from "@/views/components/Panel";

export default defineComponent({
    components: {
        Panel,
        Button,
        TextInput,
    },

    setup: function () {

        const authService = new AuthService();
        const alertStore = useAlertStore();
        const authStore = useAuthStore();
        const form = reactive({
          name: '',
          discount: 0,
          original_price: 0,
          discount_price: 0
        })

        onMounted(() => {
            if (!authStore.user) {
                return;
            }
            form.name = authStore.user.menu.name;
            form.discount = authStore.user.menu.discount;
            form.original_price = authStore.user.menu.prices["originalPrice"];
            form.discount_price = authStore.user.menu.prices["discountPrice"];
        })

        function onFormSubmit() {
            authService.updateMenu({id:authStore.user.id,name:form.name,discount:form.discount})
                .then(() => authStore.getCurrentUser())
                .then((response) => (alertStore.success(trans('global.phrases.menu_updated'))))
                .catch((error) => (alertStore.error(getResponseError(error))));
        }

        return {
            authStore,
            onFormSubmit,
            form,
            trans,
        }
    },
});
</script>
