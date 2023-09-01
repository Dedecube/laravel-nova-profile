<template>
  <loading-view :loading="initialLoading">

    <Head title="Profile" />

    <Heading class="mb-6">Profile</Heading>

    <!-- Info Card -->
    <div class="mb-8">
      <Heading class="mb-6">Information</Heading>

      <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow mt-3 py-2 px-6 divide-y divide-gray-100 dark:divide-gray-700">

        <component
            :key="index"
            v-for="(field, index) in fields"
            :index="index"
            :is="resolveComponentName(field)"
            :resource-name="resourceName"
            :resource-id="resourceId"
            :resource="resource"
            :field="field"
            @actionExecuted="actionExecuted"
        />
      </div>
    </div>

    <!-- Form Card -->
    <form class="space-y-8">
      <Heading class="mb-6">Update Password</Heading>

      <div class="bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700">
        <div class="md:flex md:flex-row space-y-2 md:space-y-0 py-5" index="2">
          <div class="w-full md:mt-2 px-6 md:px-8 md:w-1/5">
            <label for="password-create-user-password-field" class="inline-block leading-tight space-x-1">
              <span>Current Password</span>
              <span class="text-red-500 text-sm">*</span>
            </label>
          </div>

          <div class="w-full space-y-2 px-6 md:px-8 md:w-3/5">
            <input
              id="password-create-user-password-field"
              dusk="password"
              type="password"
              class="w-full form-control form-input form-input-bordered"
              placeholder="Current Password"
              autocomplete="current-password"
              v-model="passwordForm.current"
            />
          </div>
        </div>

        <div class="md:flex md:flex-row space-y-2 md:space-y-0 py-5" index="2">
          <div class="w-full md:mt-2 px-6 md:px-8 md:w-1/5">
            <label
              for="password-create-user-password-field"
              class="inline-block leading-tight space-x-1"
            >
              <span>New Password</span>
              <span class="text-red-500 text-sm">*</span>
            </label>
          </div>

          <div class="w-full space-y-2 px-6 md:px-8 md:w-3/5">
            <input
              id="password-create-user-password-field"
              dusk="password"
              type="password"
              v-model="passwordForm.new"
              class="w-full form-control form-input form-input-bordered"
              placeholder="New Password"
              autocomplete="new-password"
            />
          </div>
        </div>

        <div class="md:flex md:flex-row space-y-2 md:space-y-0 py-5" index="2">
          <div class="w-full md:mt-2 px-6 md:px-8 md:w-1/5">
            <label for="password-create-user-password-field" class="inline-block leading-tight space-x-1">
              <span>Confirm Password</span>
              <span class="text-red-500 text-sm">*</span>
            </label>
          </div>

          <div class="w-full space-y-2 px-6 md:px-8 md:w-3/5">
            <input
              id="password-create-user-password-field"
              dusk="password"
              type="password"
              class="w-full form-control form-input form-input-bordered" placeholder="Confirm Password"
              autocomplete="new-password"
              v-model="passwordForm.new_confirmation"
            />
          </div>
        </div>
      </div>

      <div
        class="flex flex-col md:flex-row md:items-center justify-center md:justify-end space-y-2 md:space-y-0 space-x-3"
      >
        <button
          size="lg"
          align="center"
          component="button"
          tabindex="0"
          @click="onCancel"
          dusk="cancel-create-button"
          type="button"
          class="appearance-none bg-transparent text-gray-400 hover:text-gray-300 active:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600 dark:hover:bg-gray-800 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3">
          Cancel
        </button>

        <button
          size="lg"
          align="center"
          component="button"
          dusk="create-button"
          type="submit"
          @click="onUpdate"
          class="cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900"
        >
          <span class="">Update Password</span>
        </button>
      </div>
    </form>
  </loading-view>
</template>

<script>
import { computed, ref, reactive } from "vue";
import { merge } from "lodash";
import {
  PreventsFormAbandonment,
} from 'laravel-nova';

export default {
  mixins: [PreventsFormAbandonment],

  setup() {
    const user = reactive({
        fields: []
    });

    const initialLoading = ref(true);
    const passwordForm = reactive({
      current: "",
      new: "",
      new_confirmation: "",
    })

    const fields = computed(() => user.fields);

    return {
      user,
      initialLoading,
      passwordForm,
      fields,
    }
  },

  mounted() {

    Nova.request().get("/nova-vendor/profile/user").then((res) => {
      if (!res.data || !res.data.fields) return;

      merge(this.user, res.data);
      this.initialLoading = false;
    });
  },

  methods: {
    onCancel(e) {
      e.preventDefault();
      e.stopPropagation();
      this.passwordForm.current = "";
      this.passwordForm.new = "";
      this.passwordForm.new_confirmation = "";
    },
    resolveComponentName(field) {
      return field.prefixComponent
        ? 'detail-' + field.component
        : field.component
    },
    onUpdate(e) {
      e.preventDefault();
      e.stopPropagation();

      const request = Nova.request();
      request.interceptors.response.use(
        response => response,
        error => {
          if (error.response.status === 422) {
            Nova.error(
              'Password update failed',
              { type: "error", duration: 1000 }
            )
          }
          return Promise.reject(error);
        }
      );

      request.post('/nova-vendor/profile/password', this.passwordForm).then(res => {
        Nova.success(
          'Password updated',
          { type: "success", duration: 6000 }
        )
      })
    }
  }
}

</script>

<style>/* Scoped Styles */</style>
