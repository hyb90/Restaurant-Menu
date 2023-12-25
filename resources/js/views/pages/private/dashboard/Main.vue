<template>
    <Page>
        <div class="w-1/2 m-auto text-center pt-10">
            <h1 class="text-6xl mb-4 font-bold text-gray-600">Welcome To HRRM</h1>
            <h4 class="text-gray-500 text-2xl">(Humam Restaurant Menu Management)</h4>
        </div>
      <FormMenu :show-update="false" class="mb-4"/>
        <footer class="py-5 text-center">
            <p class="text-gray-400">{{ trans('global.phrases.inspire') }}</p>
        </footer>
    </Page>
</template>

<script>
import {defineComponent} from 'vue';
import {trans} from "@/helpers/i18n";
import Page from "@/views/layouts/Page";
import FormMenu from "@/views/pages/private/profile/partials/FormMenu.vue";

export default defineComponent({
    components: {
      FormMenu,
        Page
    },
    setup() {
        return {
            trans
        }
    }
});
</script>
