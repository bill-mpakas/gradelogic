<script setup lang="ts">
const form = ref();
const state = reactive({
  className: "",
  academicYear: "",
});

const { refresh: onSubmit, status: classRoomStatus } = useFetch<any>(
  "classroom/create",
  {
    method: "POST",
    body: state,
    immediate: false,
    watch: false,
    async onResponse({ response }) {
      if (response?.status === 422) {
        form.value.setErrors(response._data?.errors);
      } else if (response._data?.ok) {
        useToast().add({
          icon: "i-heroicons-check-circle-20-solid",
          title: "Classroom created successfully.",
          color: "emerald",
          // actions: [
          //   {
          //     label: 'View Classroom',
          //     to: '/classroom',
          //     color: 'emerald',
          //   },
          // ],
        });
      }
    },
  }
);
</script>

<template>
  <div class="flex flex-col items-center justify-center h-full space-y-4">
    <h1 class="text-3xl font-bold">Dashboard</h1>
    <p class="text-lg text-gray-500">
      Hello and Welcome to the Dashboard. Start by creating a new Classroom
    </p>
    <UForm ref="form" :state="state" @submit="onSubmit" class="space-y-4">
      <UFormGroup label="Class Name" name="className" required>
        <UInput v-model="state.className" type="text" autofocus />
      </UFormGroup>

      <UFormGroup label="Academic Year" name="academicYear" required>
        <UInput v-model="state.academicYear" type="text" />
      </UFormGroup>

      <UButton type="submit" color="emerald">Create Classroom</UButton>
    </UForm>
  </div>
</template>
